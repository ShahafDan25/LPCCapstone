<?php include "moreFPDF.php"; //include the conn DB function ?>


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
        newMarket(connDB(), substr($_POST['new_market_date'],0,4).substr($_POST['new_market_date'],5,2).substr($_POST['new_market_date'],8,2));
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
        elseif($_POST['invokeOrReport'] == 'deleteMarket')
        {
            changeToDeleteStatus(connDB(), $date_format);
            echo '<script>';
                echo 'if(confirm("WARNING: Deleting a market will also delete any record of the people for whom it was the first market! Are you sure you would like to continue with the deletion?")){<?php deleteMarket()?>}';
                echo 'else { alert("Ok, this market will not be deleted"); location.replace("admin.php");}';
            echo '</script>';
        }

        echo '<script> location.replace("admin.php") </script>'; 
        return;
    }

    if($_POST['message'] == 'editThatItem')
    {
        updateInventoryItem(connDB(), $_POST['editItemName'], $_POST['editItemAmount']);
        echo '<script> location.replace("inventory.php") </script>';
    }

    if($_POST['message'] == 'pdfreport')
    {
        pdf_report(connDB());
        echo '<script> location.replace("report.php");</script>';
    }

    if($_POST['message'] == 'verifyPassword')
    {
        if(md5($_POST['inputAdminPW']) == getPassword(connDB()))
        { 
        //echo '<script> alert("Moving to Admin Page") </script>';  
            echo '<script>location.replace("admin.php");</script>';
        }
        else
        {
            echo '<script> alert("Password Incorrect, Please Try Again!"); </script>';
        }
    }

    if($_POST['message'] == 'insertNewPats')
    {
        insertPat($conn, $_POST["first_name"], 
                        $_POST["last_name"],
                        $_POST["student?"],
                        $_POST["children_amount"], 
                        $_POST["adults_amount"],
                        $_POST["seniors_amount"], 
                        $_POST["email_address"], 
                        $_POST["phone_number"], 
                        $_POST["promotion"],
                        $_POST["patron_id"]);

        //since the are not just adding them to the general database, but also to the mid m:m table we should call:
        //first we need to retirved the date
        $sql = "SELECT idByDate FROM Markets WHERE active = 1";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute(); ///execute the query to the database
        $row = $stmt->fetch(PDO::FETCH_ASSOC); //becasue we are onlu fetching one line
        loginPat($conn, $row['idByDate'], $_POST['patron_id']);
        echo '<script> location.replace("index.php") </script>';
    }

    if($_POST['message'] == 'patronLogin')
    {
        //1. connect
        //2. verify that the id does not already exist in the database
        //3. if verified: insert to M:M mid relationship table
        $conn = connDB();
        
        if(!verifyExistence($conn, $_POST['patronID']))
        {
            echo '<script>alert ("Your ID was not found")</script>';
            echo '<script>location.replace("index.php")</script>';
        }
        else
        {
            // id verified!
            // a. retrive current market's date
            // b. insert the patron's id to the table by calling a function
            // c. change back to index.php
            $sql = "SELECT idByDate FROM Markets WHERE active = 1";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute(); ///execute the query to the database
            $row = $stmt->fetch(PDO::FETCH_ASSOC); //becasue we are onlu fetching one line
            loginPat($conn, $row['idByDate'], $_POST['patronID']);
            echo '<script>location.replace("index.php");</script>';

        }
    }

    //code to verify that the ID is avilable
    if($_POST['message'] == 'checkID')
    {
        $conn = connDB(); //justin casey
        $sql = "SELECT * FROM Patrons WHERE patID = ".$_POST['patron_id'];
        $stmt = $conn -> prepare($sql); //create the statment
        $stmt -> execute(); //execute the statement
        if(!$stmt -> fetch(PDO::FETCH_ASSOC)) //if there is no id found
        {
            echo '<script> alert("ID confirmed! Please insert it now in the registration page"); </script>'; //id is confirmed
        }
        else
        {   //id is already used by someone else
            echo '<script> alert("ID is already in use by someone else. Choose a different ID!");</script>';
        }
        echo '<script> location.replace("index.php");</script>';
    }

    // ======================================================== //
    // ------------- REGISTRATION PAGE FUNCTIONS ---------------//
    // ======================================================== //

    function insertPat($conn, $f, $l, $ss, $ca, $aa, $sa, $ea, $pn, $pm, $id)
    {
        //also need the date of the currently active market
        $sql = "SELECT idByDate FROM Markets WHERE active = 1";
        $s = $conn -> prepare($sql);
        $s -> execute();
        $r =  $s->fetch(PDO::FETCH_ASSOC);
        $d = $r['idByDate'];

        //dont forget to close connection later!
        //might need to transfer to html page? should I make that a php file?
        $first_name = $f;//filter_input(INPUT_POST, 'first_name');
        $last_name = $l;//filter_input(INPUT_POST, 'last_name'); //retrieve information from HTML
        
        if($ss == "yes") $student_status = TRUE;
        else $student_status = FALSE;

        $children_amount = $ca;
        $adults_amount = $aa;
        $seniors_amount = $sa;

        $email_address = $ea;
        $phone_number = $pn;

        $promotion_method = $pm;

        //sql insert new patron code:
        $sql  = "INSERT INTO Patrons (FirstName, LastName, StudentStatus,
        ChildrenAmount, AdultsAmount, SeniorsAmount, EmailAdd, PhoneNumber, PromotionMethod, patID, firstMarket)
        VALUES ('".$first_name."', '".$last_name."', '".($student_status?1:0)."', 
        '".((int)$children_amount)."', '".((int)$adults_amount)."', '".((int)$seniors_amount)."', 
        '".$email_address."', '".$phone_number."', '".$promotion_method."', ".$id.", ".$d.");";


        // just to note: we use the period sign (.) to concatenate in php!!!
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql update query
        /// NEXT STEP IS TO CLOSE CONNECTION - BUT WHERE?
        echo '<script>location.reaplec("index.php");</script>'; //instead of using header (gives e problem ugh)
    }

    function getPassword($conn)
    {
        $sql = "SELECT passwords FROM AdminPW";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        {
            $pwHidden = $row['passwords'];
        }
        return $pwHidden;
    }

    function populate_dropdown($conn)
    {
        $all_options = "";
        $sql = "SELECT DISTINCT FirstName, LastName, patID FROM Patrons ORDER BY FirstName";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute(); ///execute the query to the database
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        { //concatinate to huge string to be passed //concatinaton in php is done with '.='
            $all_options .= "<option class = 'pull-left ddOption' value = '".$row['FirstName']."".$row['LastName']."'>".$row['FirstName']." ".$row['LastName']."      -       ".$row['patID']."</option><br>";
        }
        return $all_options; //return the final string to echo on the html page
    }
     
    function current_market_date()
    {
        $conn = connDB();
        //return month and date as a string
        $sql = "SELECT idByDate FROM Markets WHERE active = 1";
        $stmt_check_existence = $conn -> prepare($sql);
        $stmt_check_existence -> execute();
        $stmt = $conn -> prepare($sql);
        $stmt -> execute(); ///execute the query to the database
        if(!$stmt_check_existence -> fetch(PDO::FETCH_ASSOC))
        {
            return "WARNING: No Market has been invoked, ask the admin to invoke a market<br><script>location.replace('noActiveMarket.html');</script>";
        }
        else
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            { //concatinate to huge string to be passed //concatinaton in php is done with '.='
                $final_date = substr($row['idByDate'], 4, 2)." / ".substr($row['idByDate'],0, 4);
            }
            return $final_date;
        }
        
    }

    function verifyExistence($conn, $id)
    {
        $sql = "SELECT * FROM Patrons WHERE patID = ".$id;
        $stmt = $conn -> prepare($sql);
        $stmt -> execute(); ///execute the query to the database
        if(!$stmt->fetch(PDO::FETCH_ASSOC)) //meaning if not results have been found in the database
        {
            return false; //person not found in the database 
        }
        else return true; //else, the ID already exists in the database
    }

    function loginPat($conn, $date, $id)
    {
        $conn = connDB();
        //first, make sure to get the current time (military time, since we will be using it to conduct a graph later)
        date_default_timezone_set("America/Los_Angeles");
        $time = date("H:i");
        // --------- substring template: -------
        // substr($STRING, STARTING_CHARACTERS, AMOUNT_OF CHARACTERS)
        $time_digits = substr($time, 0, 2).substr($time, 3, 2);//take only numerical values, to create a flow of values in graphs
        // var_dump($date, $id);
        //    GOAL    : insert the two into the mid m:m table

        //first: check if already signed in
        $sql = "SELECT time_stamp FROM MarketLogins WHERE Patrons_patID = ".$id." AND Markets_idByDate = ".$date.";";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        if(!$stmt->fetch(PDO::FETCH_ASSOC)) //meaning if not results have been found in the database
        {
            $sql = "INSERT INTO MarketLogins (Markets_idByDate, Patrons_patID, time_stamp) VALUES (".$date.", ".$id."., '".$time_digits."');";
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec($sql); //execute the sql inset query (insert to data base)
            echo '<script>alert("WELCOME TO THE MARKET");</script>';
            return;
        }
        else
        {
            echo '<script> alert("You are already logged in"); </script>';
            return; //person not found in the database 
        }
        // NOTE: time stamp is a string (varchar of 45 characters)
       
        return; // end function
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
        $sql = "INSERT INTO Markets (idByDate, active, reported, inventory) VALUES (".$date.", 0, 0, 0);"; //0 = not active, 1 = active (tiny int sserving as boolean)
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql update query
        echo '<script> location.replace("admin.php") </script>'; //change location
    }

    function verifyOld($conn, $oldPW)
    {
        $sql = "SELECT passwords FROM AdminPW";
        $stmt = $conn -> prepare($sql); //create the statment
        $stmt -> execute(); //execute the statement
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        $oldPWfromDB = $row['passwords'];
        if (md5($oldPW) == $oldPWfromDB) return true;
        else return false;
    }

    function changePWinDB($conn, $newPW)
    {
        $sql = "UPDATE AdminPW SET passwords = '".md5($newPW)."'"; //update password in the database, add secuirty features later
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        return;
    }

    function terminateActiveMarket($c, $d)
    {
        $c = connDB();
        $sql = "UPDATE Markets SET active = 0 WHERE idByDate = ".$d; //update password in the database, add secuirty features later
        $s = $c -> prepare($sql);
        $s -> execute();
        //also change closing time
        date_default_timezone_set("America/Los_Angeles"); //set time zone
        $closetime = date("H:i");
        $close_time_digits = substr($closetime, 0, 2).substr($closetime, 3, 2);//take only numerical values, to create a flow of values in graphs
        $sql = "UPDATE Markets SET closetime = '".$close_time_digits."' WHERE idByDate = ".$d; //update password in the database, add secuirty features later
        $s = $c -> prepare($sql);
        $s -> execute();
        echo '<script> location.replace("admin.php") </script>';
        return;
    }

    function changeToDeleteStatus($c, $d)
    {
        $sql = "UPDATE Markets SET toDelete = 1 WHERE idByDate = ".$d;
        $sql .= "UPDATE Markets SET toDelete = 1 WHERE idByDate <> ".$d;
        $s = $c -> preapre($sql);
        $s -> execute();
        return;
    }

    function deleteMarket()
    {
        $c = connDB();
        $sql = "SELECT idByDate FROM Markets WHERE toDelete = 1";
        $s = $c -> preapre($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $d = $r['idByDate'];

        //risky moves now
        $sql = "DELETE FROM MarketLogins WHERE Markets_idByDate = ".$d;
        $sql .= "DELETE FROM Patrons WHERE firstMarket = ".$d;
        $sql .= "DELETE FROM Items WHERE Markets_idByDate = ".$d;
        $sql .= "DELETE FROM Markets WHERE idByDate = ".$d;
        $s = $c -> prepare($sql);
        $s -> execute();
        return;
    }

    // ======================================================== //
    // -------------- REPORT PAGE FUNCTIONS --------------------//
    // ======================================================== //

    function generate_report($c, $d) 
    {
        $c = connDB();
        //selected which market to report
        $sql = "UPDATE Markets SET reported = 1 WHERE idByDate = ".$d; //update password in the database, add secuirty features later
        $s = $c -> prepare($sql);
        $s -> execute();

        //select which markets not to report
        $sql = "UPDATE Markets SET reported = 0 WHERE idByDate <> ".$d; //update password in the database, add secuirty features later
        $s = $c -> prepare($sql);
        $s -> execute();

        //see if there is any attendance to report
        $sql = "SELECT COUNT(*) FROM MarketLogins WHERE Markets_idByDate = ".$d;
        if(($c -> query($sql) -> fetchColumn()) == 0) echo '<script> location.replace("noCurrentReport");</script>';
        else echo '<script>location.replace("report.php");</script>';
    }

    function pdf_report($c)
    {
        $sql = "SELECT idByDate FROM Markets WHERE reported = 1";
        $s = $c -> prepare ($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $d = $r['idByDate'];

        //--------------- report code ---------------------//


        $pdf = new myFPDFClass(); //generate a new pdf
        $pdf -> AddPage(); //add page
        $pdf -> SetFont('Arial', 'B', 20); //Font: arial. Bolden. size 16
        $pdf -> Cell(40,10,'The Market - Report from '.substr($d,4,2)." / ".substr($d,6,2)." / ".substr($d,0,4),'C');
        $pdf -> Ln(); //endl;

        $pdf -> tableHead();
        $pdf -> tableBody(connDB());

        



        //$pdf->Output("~report_".$d.".pdf", 'D'); 
        // IMPORTANT NOTE: had to change the modifications of rt.pdf to in order ot edit it with chmod 777 rt.pdf
        $pdf -> Output('rt.pdf', 'F');
        echo '<script>alert("YOUR PDF IS GENERATED AS:  ~report_'.$d.'.pdf  ");</script>';
        return; //it will then switch back to the report page
    }

    function getAttData($conn, $d)
    {
        $dformat = substr($d,0,4)."-".substr($d,4,2)."-".substr($d,6,2)." ";
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
        #stite = Start Time Integer To Enter
        if(strlen(strval($sti)) == 3) $stite = substr(strval($sti), 0, 1).":".substr(strval($sti), 1, 2);
        elseif(strlen(Strval($sti)) == 4) $stite = substr(strval($sti),0,2).":".substr(strval($sti),2,2);
        
        $chart_data = "{TIME:'".$dformat.$stite."',AMOUNT:'".$first_amount."'}";
        if($interval % 100 == 60) {$interval += 40;} 
        while(($interval + 10) < intval($ct))
        {
            
            if($interval % 100 == 60) {$interval += 40;} 
            $interval_b = $interval + 10; 

            $sql_i = "SELECT COUNT('Patrons_patID') FROM MarketLogins WHERE time_stamp < ".$interval_b." AND time_stamp >= ".$interval." AND Markets_idByDate = ".$d.";";
            $stmt_amount_a = $conn -> query($sql_amount_a);
            $stmt_i = $conn -> query($sql_i);

            #intervalte = Interval To Enter
            if(strlen(strval($interval)) == 3) $intervalte = substr(strval($interval), 0, 1).":".substr(strval($interval), 1, 2);
            elseif(strlen(Strval($interval)) == 4) $intervalte = substr(strval($interval),0,2).":".substr(strval($interval),2,2);

            $amount = $stmt_i -> fetchColumn();
            $chart_data .= ", {TIME:'".$dformat.$intervalte."',AMOUNT:'".$amount."'}";
            $interval = $interval_b;
        }
        $sql_i_b = "SELECT COUNT('Patron_patID') FROM MarketLogins WHERE time_stamp >= ".$interval." AND Markets_idByDate = ".$d.";";
        $stmt_amount_a = $conn -> query($sql_amount_a);
        $stmt_i_b= $conn -> query($sql_i_b);

        if(strlen(strval($interval)) == 3) $intervalte = substr(strval($interval), 0, 1).":".substr(strval($interval), 1, 2);
        elseif(strlen(Strval($interval)) == 4) $intervalte = substr(strval($interval),0,2).":".substr(strval($interval),2,2);


        $amount = $stmt_i_b -> fetchColumn();
        $chart_data .= ", {TIME:'".$dformat.$intervalte."',AMOUNT:'".$amount."'}";

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

    function getRetVSNew($c, $d)
    {
        $data = "";
        $sql_newPs = "SELECT COUNT(*) FROM Patrons WHERE firstMarket = ".$d;
        $s_newPs = $c -> query($sql_newPs);
        $noobies = $s_newPs -> fetchColumn();

        $sql_allPs = "SELECT COUNT(*) FROM Patrons";
        $s_allPs = $c -> query($sql_allPs);
        $all = $s_allPs -> fetchColumn();

        $oldies = $all - $noobies;
        $data = "{value: ".$noobies.", label: 'New Patrons'},{value: ".$oldies.", label: 'Returning Patrons'}";
        return $data;
    }

    // ======================================================== //
    // -------------- INVENTORY PAGE FUNCTIONS -----------------//
    // ======================================================== //

    function insertItem($c, $n, $a)
    {
        var_dump($c);
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
        // ====================================== //

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

        $s = $c -> prepare($sql); 
        $s -> execute(); 
        $collapseCounter = 0;
        while($r = $s -> fetch(PDO::FETCH_ASSOC))
        { 
            $counter++;
            $buttonInsert = "<button class = 'btn btn-warning collapsed' id = 'editbtn' data-toggle='collapse' data-target='#formToEditItem".strval($counter)."' aria-expanded='false'> EDIT </button>";
            $editForm = '<form action = "adminFuncs.php" method = "post">';
            $editForm .= '<td><input type = "text" class = "inv_input inline" name = "editItemName" placeholder = "'.$r['Name'].'" value = "'.$r['Name'].'" style = "width: 60% !important;"></td>';
            $editForm .= '<td><input type = "text" class = "inv_input inline" name = "editItemAmount" placeholder = "'.$r['Amount'].'" value = "'.$r['Amount'].'"></td>';
            $editForm .= '<td><input type = "hidden" class = "inline" name = "message" value = "editThatItem">';
            $editForm .= '<button class = "btn btn-success inv_input_btn inline"> SUBMIT </button></td>';
            $editForm .= '</form>';
            // ============================================================== //
            $tableItemData .= "<tr>";
                $tableItemData .= "<td>".$r['Name']."</td>";
                $tableItemData .= "<td>".$r['Amount']."</td>";
                $tableItemData .= "<td>".$buttonInsert."</td>";
            $tableItemData .= "</tr>";
            
            $tableItemData .= "<tr class = 'collapse whiteOut' id = 'formToEditItem".strval($counter)."'>".$editForm."</tr>";
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

    function updateInventoryItem($c, $n, $a)
    {
        $sql = "UPDATE Items SET Amount = ".intval($a)." WHERE Name = '".$n."' AND Markets_idByDate = (SELECT idByDate FROM Markets WHERE inventory = 1)";
        $s = $c -> prepare($sql);
        $s -> execute();
        return;
    }
?>