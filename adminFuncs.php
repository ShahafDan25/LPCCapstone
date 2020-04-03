<html !DOCTYPE>
    <head>
        <title> Market - Admin </title>
        <!-- CSS HARDCODE FILE LINK -->
        <link rel="stylesheet" type="text/css" href="capstone.css">
    </head>
    <body class = "body">
        <div class = "midPage">
            <input type = "hidden" id = "justToTest">
        </div>
    </body>
</html>
<?php
    $CHOSEN_DATE = ""; //MAKE THIS AN GLOBAL VARIABLE (I think this is kinda cheating, but whatever)
    //define('FPDF_FONTPATH','/home/www/font/');
    //require('fpdf_lib'); //include library for pdf generation
    function connDB() //call to get connection
    {
        $username = "root";
        $password = "MMB3189@A";
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306;socket=/tmp/mysql.sock';
      

        //try and catch block to connect to MySQL, or throw an error
        try {
             $conn = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
             echo 'Connection Failed: ' . $e -> getMessage();
        } // end of try and catch
        return $conn;
    }

    if($_POST['message'] == "changePW")
    {
        $conn = connDB();
        //1. verify old password is correct
        //2. verify new password 1 matches new password 2
        //3. insert new password to database
        $a = verifyOld($conn, $_POST['oldPW']);
        if(!$a)
        {
            echo '<script>alert("Old Password Inserted is Incorrect");</script>';
            echo '<script>location.replace("admin.php");</script>';
        }
        $b = $_POST['newPW1'] == $_POST['newPW2'];
        if(!$b)
        {
            echo '<script>alert("Passwords Do not match");</script>';
            echo '<script>location.replace("admin.php");</script>';
        }
        if($a && $b)
        {
            changePWinDB($conn, $_POST['newPW1']);
            echo '<script>alert("Password Changed Successfully!");</script>';
            echo '<script>location.replace("admin.php");</script>';
        } 
        return;
    }

    if($_POST['message'] == 'submitNewMarket')
    {
        $date_format_d = $_POST['new_market_date'];
        $date_format_int = substr($_POST['new_market_date'],0,4).substr($_POST['new_market_date'],5,2).substr($_POST['new_market_date'],8,2);
        //var_dump($date_format_int);
        newMarket(connDB(), $date_format_int);
        //header("Location: admin.php"); //just gonna use javascript
    }

    if($_POST['message'] == 'invokeOrReport')
    {
        
        $date = $_POST['marketDate'];
        $date_format = substr($date,10,4).substr($date,0,2).substr($date,5,2);
        if($_POST['invokeOrReport'] == "invoke")//invoke
        {
            if($_POST['marketDate'] == "Choose a market (by date)" || $_POST['marketDate'] == "No Markets to Show")
            {
            
                echo '<script>alert("Please choose a date");</script>';
                echo '<script> location.replace("admin.php") </script>';
                return; //end function
            }
            $conn = connDB(); //justin casey

            $sql = "UPDATE Markets SET active = 1 WHERE idByDate = ".$date_format; //we use the period dot to concatinate
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            //var_dump($date_format);
            //now: set opening time of the market (for graphing purposes)
            date_default_timezone_set("America/Los_Angeles"); //set time zone
            $starttime = date("H:i"); //only hours and minutes
            $start_time_format = substr($time, 0, 2).substr($time, 3, 2);//take only numerical values, to create a flow of values in graphs
            $sql = "UPDATE Markets SET starttime = '".$start_time_format."' WHERE idByDate = ".$date_format; //we use the period dot to concatinate
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            // BELOW: change all other markets to non active
            $sql = "UPDATE Markets SET active = 0 WHERE NOT idByDate = ".$date_format; //we use the period dot to concatinate
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
        }
        elseif($_POST['invokeOrReport'] == "report")//report
        {
            generate_report($conn, $date_format);

        }
        elseif($_POST['invokeOrReport'] == "terminate")
        {
            terminateActiveMarket($conn, $date_format); // that way we only allow one active market at a time
        }
        echo '<script> location.replace("admin.php") </script>'; //instead of using header, we will use js to change window location
        return;
    }

    // ======================================================== //
    // ------------- ADMIN PAGE FUNCTIONS ----------------------//
    // ======================================================== //

    function populate_market_dropdown($conn)
    {
        $conn = connDB();
        $sql = "SELECT * FROM Markets";
        $stmt = $conn -> prepare($sql); //create the statment
        $stmt -> execute(); //execute the statement
        $stmt_existness_check = $conn ->prepare($sql);
        $stmt_existness_check -> execute();
        $active = "Closed";
        //check if ther are any markets stored in the database
        if(!$stmt_existness_check -> fetch(PDO::FETCH_ASSOC))
        {
            echo '<option class="dropdown-item midbigger" href="#">No Markets to Show</option>';
            return; //return if no markets have been found from the database
        }
        //else statement
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        { //new format: mm / dd / yyyy
            if($row['active'] == 1) $active = "Active!";
            echo '&nbsp;<option class = "dropdown-item midbigger" href="#">'.substr($row['idByDate'],4,2).' / '.substr($row['idByDate'],6,2).' / '.substr($row['idByDate'],0,4).' - '.$active.'</option><br>';
        }
        return; //justin casey
    }

    
    function newMarket($conn, $date)
    {
        $sql_existence = "SELECT * FROM Markets WHERE idByDate = ".$date;
        $stmt = $conn -> prepare($sql_existence); //create the statment
        $stmt -> execute(); //execute the statement
        if($stmt -> fetch(PDO::FETCH_ASSOC))
        {
            echo '<script> alert("Sorry, This market already exists in the database. Only one market per day."); </script>';
            echo '<script> location.replace("admin.php") </script>';
            return; //this market already exists in the data base
        }
        $sql = "INSERT INTO Markets (idByDate, active) VALUES (".$date.", 0);"; //0 = not active, 1 = active (tiny int sserving as boolean)
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql update query
        echo '<script> location.replace("admin.php") </script>'; //change location
        //header("Location: admin.php"); //redirect to the main index.php page
    }

    function verifyOld($conn, $oldPW)
    {
        $sql = "SELECT passwords FROM AdminPW";
        $stmt = $conn -> prepare($sql); //create the statment
        $stmt -> execute(); //execute the statement
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        $oldPWfromDB = $row['passwords'];
        if ($oldPW == $oldPWfromDB) return true;
        else return false;
    }

    function changePWinDB($conn, $newPW)
    {
        $sql = "UPDATE AdminPW SET passwords = '".$newPW."'"; //update password in the database, add secuirty features later
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        return;
    }
    function generate_report($conn) //create a pdf later
    {
        #$pdf = new FPDF(); //generate a new pdf
        #$pdf -> AddPage(); //add page
        #$pdf ->SetFont('Arial', 'B', 16); //Font: arial. Bolden. size 16
        #$pdf->Cell(40,10,'Hello World!');
        #$pdf->Output();
        //Will use FPDF to generate a PDF report (later use angular.sj is possible)

        //simply, for now, just go to the report page, it will be easier I guess
        echo '<script>location.replace("report.php");</script>';

    }
    function terminateActiveMarket($conn, $d)
    {
        $CHOSEN_DATE = $d; //save the date :) in the global variable
        $conn = connDB();
        $sql = "UPDATE Markets SET active = 0 WHERE idByDate = ".$d; //update password in the database, add secuirty features later
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        //also change closing time
        date_default_timezone_set("America/Los_Angeles"); //set time zone
        $closetime = date("H:i");
        $close_time_digits = substr($time, 0, 2).substr($time, 3, 2);//take only numerical values, to create a flow of values in graphs
        $sql = "UPDATE Markets SET closetime = '".$close_time_digits."' WHERE idByDate = ".$d; //update password in the database, add secuirty features later
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        echo '<script> location.replace("admin.php") </script>';
        return;
    }
    //IDEA: ADD LATER CHANGE PASSWORD OPTION --done
    //IDEA: add IP address, hashing, etc. (seurity features) later

    function getAttData($conn, $d)
    {
        $sql_times = "SELECT starttime, closetime FROM Markeys WHERE idByDate = ".$d;
        $stmt_times = $conn -> prepare($sql_times);
        $stmt_times -> execute();
        $times = $stmt_times -> fetch(PDO::FETCH_ASSOC);
        $st = $times['starttime']; //market opening time
        $ct = $times['closetime']; //market closing time


        $interval = $st + (10 - ($st%1000)); //formula just to get the first interval
        $sql_amount_a = "SELECT COUNT('Patron_patID') FROM MarketLogins WHERE time_stamp < ".($interval).";";
        $stmt_amount_a = $conn -> prepare($sql_amount_a);
        $stmt_amount_a -> execute();
        $first_amount = $stmt_amount_a -> fetch(PDO::FETCH_ASSOC);
        $chart_data = "{ TIME:'".$st."', AMOUNT:".$first_amount."}";
        if($interval % 100 == 60) {$interval += 40;} // go to the next hour
        //now number of rep repsents the number of 5 minute inetrvals from the imte the market was openeed, to the time it was closed
        while(($interval + 10) < $ct)
        {
            $interval_b = $interval + 10;
            $sql = "SELECT COUNT('Patrons_patID') FROM MarketLogins WHERE time_stamp < ".$interval_b." AND time_stamp > ".$interval.";"; 
            //one condition for it to work:
            if($interval % 100 == 60) {$interval += 40;} // go to the next hour

            $current_lowtime_limit = intval($times['starttime']) + 5*$x;
            $current_hightime_limit = "";
            $sql_i = "SELECT COUNT(Patron_patID) FROM MarketLogins WHERE (Market_idByDate = ".$d.")";
            $stmt_i = $conn -> prepare($sql_i);
            $stmt_i -> execute();
            $amount = $stmt_times -> fetch(PDO::FETCH_ASSOC);
            $chart_data .= ", {TIME: ".$interval.", AMOUNT: ".$amount."}";
            $interval = $interval_b;
            $interval_b += 10;
        }
        //add the last data piece
       

        return $chart_data;
    }
    
?>