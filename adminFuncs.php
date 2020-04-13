<?php include "connDB.php"; ?>

<html !DOCTYPE>
    <head>
        <title> Market - Admin </title>
        <link rel="stylesheet" type="text/css" href="capstone.css">
    </head>
    <body class = "body">
        <div class = "midPage">
            <input type = "hidden" id = "justToTest">
        </div>
    </body>
</html>
<?php
/*
c = connection
d = date
a = amount
n = name
s = satetment
r = row / result
*/

    // ======================================================== //
    // -------------------- POSTS MESSAGES ---------------------//
    // ======================================================== //

    if($_POST['message'] == "insertItem")
    {
        $itemName = $_POST['item_name'];
        $amount = $_POST['item_number'];
        insertItem(connDB(), $itemName, $amount);
    }
    
    if($_POST['message'] == "changePW")
    {
        $conn = connDB();
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
        newMarket(connDB(), $date_format_int);
    }

    if($_POST['message'] == 'invokeOrReport')
    {
        
        $date = $_POST['marketDate'];
        $date_format = substr($date,10,4).substr($date,0,2).substr($date,5,2);
        if($_POST['invokeOrReport'] == "invoke")
        {
            if($_POST['marketDate'] == "Choose a market (by date)" || $_POST['marketDate'] == "No Markets to Show")
            {
                echo '<script>alert("Please choose a date");</script>';
                echo '<script> location.replace("admin.php") </script>';
                return; 
            }
            $conn = connDB(); 

            $sql = "UPDATE Markets SET active = 1 WHERE idByDate = ".$date_format; //we use the period dot to concatinate
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            date_default_timezone_set("America/Los_Angeles"); 
            $starttime = date("H:i"); 

            $start_time_format = substr($starttime, 0, 2).substr($starttime, 3, 2);//take only numerical values, to create a flow of values in graphs
            $sql_a = "UPDATE Markets SET starttime = '".$start_time_format."' WHERE idByDate = ".$date_format; //we use the period dot to concatinate
            $stmt_a = $conn -> prepare($sql_a);
            $stmt_a -> execute();

            $sql = "UPDATE Markets SET active = 0 WHERE NOT idByDate = ".$date_format; //we use the period dot to concatinate
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
        }
        elseif($_POST['invokeOrReport'] == "report")
        {
            generate_report(connDB(), $date_format);
        }
        elseif($_POST['invokeOrReport'] == "terminate")
        {
            terminateActiveMarket(connDB(), $date_format); 
        }
        elseif($_POST['invokeOrReport'] == "inventory")
        {
            changeInventoryStatus(connDB(), $date_format);
        }

        echo '<script> location.replace("admin.php") </script>'; 
        return;
    }

    // ======================================================== //
    // ---------------- ADMIN PAGE FUNCTIONS -------------------//
    // ======================================================== //

    function populate_market_dropdown($conn)
    {
        $conn = connDB();
        $sql = "SELECT * FROM Markets";
        $stmt = $conn -> prepare($sql); 
        $stmt -> execute();
        $stmt_existness_check = $conn ->prepare($sql);
        $stmt_existness_check -> execute();
        $active = "Closed";


        if(!$stmt_existness_check -> fetch(PDO::FETCH_ASSOC))
        {
            return '<option class="dropdown-item midbigger" href="#">No Markets to Show</option>'; 
        }
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        { 
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
        $sql = "INSERT INTO Markets (idByDate, active, reported) VALUES (".$date.", 0, 0);"; //0 = not active, 1 = active (tiny int sserving as boolean)
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql update query
        echo '<script> location.replace("admin.php") </script>'; //change location
        //header("Location: admin.php"); //redirect to the main index.php page
    }

    // ======================================================== //
    // ---------------- ADMIN PAGE FUNCTIONS -------------------//
    // ======================================================== //

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

    function terminateActiveMarket($conn, $d)
    {
        $conn = connDB();
        $sql = "UPDATE Markets SET active = 0 WHERE idByDate = ".$d; //update password in the database, add secuirty features later
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        //also change closing time
        date_default_timezone_set("America/Los_Angeles"); //set time zone
        $closetime = date("H:i");
        $close_time_digits = substr($closetime, 0, 2).substr($closetime, 3, 2);//take only numerical values, to create a flow of values in graphs
        $sql = "UPDATE Markets SET closetime = '".$close_time_digits."' WHERE idByDate = ".$d; //update password in the database, add secuirty features later
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        echo '<script> location.replace("admin.php") </script>';
        return;
    }

    // ======================================================== //
    // -------------- REPORT PAGE FUNCTIONS --------------------//
    // ======================================================== //

    function generate_report($conn, $d) //create a pdf later
    {
        $conn = connDB();
        //selected which market to report
        $sql = "UPDATE Markets SET reported = 1 WHERE idByDate = ".$d; //update password in the database, add secuirty features later
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();

        //select which markets not to report
        $sql = "UPDATE Markets SET reported = 0 WHERE NOT idByDate = ".$d; //update password in the database, add secuirty features later
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();

        echo '<script>location.replace("report.php");</script>';

    }

    function getAttData($conn, $d)
    {
        $sql_times = "SELECT starttime, closetime FROM Markets WHERE idByDate = ".$d;
        $stmt_times = $conn -> prepare($sql_times);
        $stmt_times -> execute();
        $times = $stmt_times -> fetch(PDO::FETCH_ASSOC);
        $st = $times['starttime']; //market opening time
        $ct = $times['closetime']; //market closing time

        $sti = intval($st); //calculation purposes
        $interval = $sti + (10 - ($sti%10)); //formula just to get the first interval
        $sql_amount_a = "SELECT COUNT('Patron_patID') FROM MarketLogins WHERE time_stamp < ".($interval)." AND Markets_idByDate = ".$d.";";
        $stmt_amount_a = $conn -> query($sql_amount_a);
        //$stmt_amount_a -> execute();
        $first_amount = $stmt_amount_a -> fetchColumn();
        $chart_data = "{TIME:'".$sti."',AMOUNT:'".$first_amount."'}";
        if($interval % 100 == 60) {$interval += 40;} 
        while(($interval + 10) < intval($ct))
        {
            
            if($interval % 100 == 60) {$interval += 40;} 
            $interval_b = $interval + 10; 

            $sql_i = "SELECT COUNT('Patrons_patID') FROM MarketLogins WHERE time_stamp < ".$interval_b." AND time_stamp >= ".$interval." AND Markets_idByDate = ".$d.";";
            $stmt_amount_a = $conn -> query($sql_amount_a);
            $stmt_i = $conn -> query($sql_i);

            $amount = $stmt_i -> fetchColumn();
            $chart_data .= ", {TIME:'".$interval."',AMOUNT:'".$amount."'}";
            $interval = $interval_b;
        }
        $sql_i_b = "SELECT COUNT('Patron_patID') FROM MarketLogins WHERE time_stamp >= ".$interval." AND Markets_idByDate = ".$d.";";
        $stmt_amount_a = $conn -> query($sql_amount_a);
        $stmt_i_b= $conn -> query($sql_i_b);

        $amount = $stmt_i_b -> fetchColumn();
        $chart_data .= ", {TIME:'".$interval."',AMOUNT:'".$amount."'}";

        return $chart_data;
    }
    
    function promGraphData($c, $d)
    {
        $data = "";

        //COMMUNITY
        $sql_a = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Community' AND MarketLogins.Markets_idByDate = ".$d;
        $s_a = $c -> query($sql_a);
        $comm = $s_a -> fetchColumn();
        $data .= "{METHOD: 'Community',AMOUNT:'".$comm."'}";
        //FRIENDS AND FAMILY
        $sql_b = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'FriendsAndFamily' AND MarketLogins.Markets_idByDate = ".$d;
        $s_b = $c -> query($sql_b);
        $fnf = $s_b -> fetchColumn();
         $data .= ", {METHOD: 'Friends / Family',AMOUNT:'".$fnf."'}";
        // CLASSROOM
        $sql_c = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Classroom' AND MarketLogins.Markets_idByDate = ".$d;
        $s_c = $c -> query($sql_c);
        $class = $s_c -> fetchColumn();
        $data .= ", {METHOD:'Classroom',AMOUNT:'".$class."'}";
        //OTHER
        $sql_d = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Other' AND MarketLogins.Markets_idByDate = ".$d;
        $s_d = $c -> query($sql_d);
        $other = $s_d -> fetchColumn();
        $data .= ", {METHOD:'Other',AMOUNT:'".$other."'}";

        return $data;
    }

    // ======================================================== //
    // -------------- INVENTORY PAGE FUNCTIONS -----------------//
    // ======================================================== //

    function insertItem($c, $n, $a)
    {
        $sql = "SELECT idByDate FROM Markets WHERE inventory = 1";
        $s = $c -> prepare($sql); 
        $s -> execute(); 
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $d = $r['idByDate']; 

        $sqlb = "INSERT INTO Items (Name, Amount, Markets_idByDate) VALUES ('".$n."',".$a.",".$d.");"; 
        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c->exec($sqlb); 
        echo '<script> location.replace("inventory.php"); </script>';
        return;
    }

    function populateItemTable($c)
    {
        $sql_date = "SELECT idByDate FROM Markets WHERE inventory = 1";
        $s_date = $c -> prepare($sql_date);
        $s_date -> execute();
        $r = $s_date -> fetch(PDO::FETCH_ASSOC);
        $d = $r['idByDate'];

        $tableItemData = ""; 
        $sql = "SELECT Name, Amount FROM Items WHERE Markets_idByDate = ".$d;

        $s_ec = $c -> prepare($sql); //ec = exitence check
        $s_ec -> execute();
        $r_ec = $s_ec -> fetch(PDO::FETCH_ASSOC);
        if(count($r_ec) == 0)
        {
            return '<p> NO ITEMS TO DISPLAY AT THE MOMENT </p>';
        }

        $buttonInsert = "<button class = 'btn btn-warning' id = 'editbtn'> EDIT </button>";
        $s = $c -> prepare($sql); 
        $s -> execute(); 
        while($r = $s -> fetch(PDO::FETCH_ASSOC))
        { 
            $tableItemData .= "<tr>";
                $tableItemData .= "<td>".$r['Name']."</td>";
                $tableItemData .= "<td>".$r['Amount']."</td>";
                $tableItemData .= "<td>".$buttonInsert."</td>";
            $tableItemData .= "</tr>";
        }
       
        return $tableItemData;
    }

    function changeInventoryStatus($c, $d)
    {
        $sql = "UPDATE Markets SET inventory = 1 WHERE idByDate = ".$d;
        $s = $c -> prepare($sql);
        $s -> execute();

        
        $sql = "UPDATE Markets SET inventory = 0 WHERE NOT idByDate = ".$d; //update all
        $s = $c -> prepare($sql);
        $s -> execute();

        echo '<script>location.replace("inventory.php");</script>';

        return;
    }
?>