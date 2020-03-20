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
            $sql = "UPDATE Markets SET active = 1 WHERE idByDate = ".$date_format; //we use the period dot to concatinate
            $conn = connDB(); //justin casey
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            //var_dump($date_dormat);

            // BELOW: change all other markets to non active
            $sql = "UPDATE Markets SET active = 0 WHERE NOT idByDate = ".$date_format; //we use the period dot to concatinate
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
        }
        if($_POST['invokeOrReport'] == "report")//report
        {
            generate_report($conn);
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
        //check if ther are any markets stored in the database
        if(!$stmt_existness_check -> fetch(PDO::FETCH_ASSOC))
        {
            echo '<option class="dropdown-item midbigger" href="#">No Markets to Show</option>';
            return; //return if no markets have been found from the database
        }
        //else statement
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        { //new format: mm / dd / yyyy
            echo '&nbsp;<option class = "dropdown-item midbigger" href="#">'.substr($row['idByDate'],4,2).' / '.substr($row['idByDate'],6,2).' / '.substr($row['idByDate'],0,4).'</option><br>';
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
    function generate_report($conn)
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
    //IDEA: ADD LATER CHANGE PASSWORD OPTION --done
    //IDEA: add IP address, hashing, etc. (seurity features) later

?>