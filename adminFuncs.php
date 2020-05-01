<?php include "moreFPDF.php"; ?>


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
s_ce = statement check existence
r = row / result
t = time
*/



    // ======================================================== //
    // -------------------- POSTS MESSAGES ---------------------//
    // ======================================================== //

    if($_POST['message'] == "insertItem") //new inventory item
    {
        $n = $_POST['item_name'];
        $a = $_POST['item_number'];
        insertItem(connDB(), $n, $a);
    }
    
    if($_POST['message'] == "changePW") //change admin password
    {
        $A = verifyOld(connDB(), $_POST['oldPW']);
        if(!$A)
        {
            echo '<script>alert("Old Password Inserted is Incorrect");</script>';
            echo '<script>location.replace("admin.php");</script>';
        }
        $B = $_POST['newPW1'] == $_POST['newPW2'];
        if(!$B)
        {
            echo '<script>alert("Passwords Do not match");</script>';
            echo '<script>location.replace("admin.php");</script>';
        }
        if($A && $B)
        {
            if(verifyPastPasswords(connDB(), $_POST['newPW1'])) 
            {
                echo '<script>alert("This password was already used in the past, try a different one!");</script>';
            }
            else
            {
                updatePWHistory(connDB(), $_POST['oldPW']);
                changePWinDB(connDB(), $_POST['newPW1']);
                echo '<script>alert("Password Changed Successfully!");</script>';
            }
            echo '<script>location.replace("admin.php");</script>'; 
        } 
        return;
    }

    if($_POST['message'] == 'submitNewMarket') //create new market
    {
        newMarket(connDB(), substr($_POST['new_market_date'],0,4).substr($_POST['new_market_date'],5,2).substr($_POST['new_market_date'],8,2));
    }

    if($_POST['message'] == 'adminOption') //choose an action option per market
    {
        
        $d = $_POST['marketDate'];
        $d_f = substr($d,10,4).substr($d,0,2).substr($d,5,2);

        if($_POST['marketDate'] == "Choose a market (by date)" || $_POST['marketDate'] == "No Markets to Show")
        {
            echo '<script>alert("Please choose a date");</script>';
            echo '<script> location.replace("admin.php") </script>';
            return; 
        }
        else
        {
            if($_POST['adminOption'] == "invoke") activateMarket(connDB(), $d_f);
            elseif($_POST['adminOption'] == "report") generate_report(connDB(), $d_f);
            elseif($_POST['adminOption'] == "terminate") terminateActiveMarket(connDB(), $d_f);
            elseif($_POST['adminOption'] == "inventory") changeInventoryStatus(connDB(), $d_f);
            elseif($_POST['adminOption'] == "deleteMarket")
            {
                changeToDeleteStatus(connDB(), $d_f);
                deleteMarket(connDB());
            }
        }
        echo '<script> location.replace("admin.php") </script>'; 
        return;
    }

    if($_POST['message'] == 'editThatItem') //edit an inventory item
    {
        updateInventoryItem(connDB(), $_POST['editItemName'], $_POST['editItemAmount']);
        echo '<script> location.replace("inventory.php") </script>';
    }

    if($_POST['message'] == 'pdfreport') //generate a pdf report
    {
        pdf_report(connDB());
        echo '<script> location.replace("report.php");</script>';
    }

    if($_POST['message'] == 'verifyPassword') //verify password to admin page
    {
        if(md5($_POST['inputAdminPW']) == getPassword(connDB()))
        { 
            echo '<script>location.replace("admin.php");</script>';
        }
        else
        {
            echo '<script> alert("Password Incorrect, Please Try Again!"); location.replace("index.php"); </script>';
        }
    }

    if($_POST['message'] == 'insertNewPats') //new patron visited the market, add to DB
    {
        $c = connDB();
        insertPat($c, $_POST["first_name"], 
                        $_POST["last_name"],
                        $_POST["student?"],
                        $_POST["children_amount"], 
                        $_POST["adults_amount"],
                        $_POST["seniors_amount"], 
                        $_POST["email_address"], 
                        $_POST["phone_number"], 
                        $_POST["promotion"],
                        $_POST["patron_id"]);


        $sql = "SELECT idByDate FROM Markets WHERE active = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s->fetch(PDO::FETCH_ASSOC); 
        loginPat($c, $r['idByDate'], $_POST['patron_id']);
        echo '<script> location.replace("index.php") </script>';
    }

    if($_POST['message'] == 'patronLogin') //Mark a patron's attendance to the market
    {
        $c = connDB();
        
        if(!verifyExistence($c, $_POST['patronID']))
        {
            echo '<script>alert ("Your ID was not found")</script>';
            echo '<script>location.replace("index.php")</script>';
        }
        else
        {

            $sql = "SELECT idByDate FROM Markets WHERE active = 1";
            $s = $c -> prepare($sql);
            $s -> execute(); 
            $r = $s->fetch(PDO::FETCH_ASSOC); 
            loginPat($c, $r['idByDate'], $_POST['patronID']);
            echo '<script>location.replace("index.php");</script>';

        }
    }

    if($_POST['message'] == 'checkID') //check if ID is available
    {
        $c = connDB(); 
        $sql = "SELECT * FROM Patrons WHERE patID = ".$_POST['patron_id'];
        $s = $c -> prepare($sql); 
        $s -> execute(); 
        if(!$s -> fetch(PDO::FETCH_ASSOC)) 
        {
            echo '<script> alert("ID confirmed! Please insert it now in the registration page"); </script>'; 
        }
        else
        {  
            echo '<script> alert("ID is already in use by someone else. Choose a different ID!");</script>';
        }
        echo '<script> location.replace("index.php");</script>';
    }

    // ======================================================== //
    // ------------- REGISTRATION PAGE FUNCTIONS ---------------//
    // ======================================================== //

    function insertPat($c, $f, $l, $ss, $ca, $aa, $sa, $ea, $pn, $pm, $id) //new patrons to DB
    {
        $sql = "SELECT idByDate FROM Markets WHERE active = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r =  $s->fetch(PDO::FETCH_ASSOC);
        $d = $r['idByDate'];


        $first_name = $f;
        $last_name = $l;

        if($ss == "yes") $student_status = TRUE;
        else $student_status = FALSE;

        $children_amount = $ca;
        $adults_amount = $aa;
        $seniors_amount = $sa;

        $email_address = $ea;
        $phone_number = $pn;

        $promotion_method = $pm;

        $sql  = "INSERT INTO Patrons (FirstName, LastName, StudentStatus,
        ChildrenAmount, AdultsAmount, SeniorsAmount, EmailAdd, PhoneNumber, PromotionMethod, patID, firstMarket)
        VALUES ('".$first_name."', '".$last_name."', '".($student_status?1:0)."', 
        '".((int)$children_amount)."', '".((int)$adults_amount)."', '".((int)$seniors_amount)."', 
        '".$email_address."', '".$phone_number."', '".$promotion_method."', ".$id.", ".$d.");";


        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c->exec($sql); 
        echo '<script>location.reaplec("index.php");</script>'; 
    }

    function getPassword($c) //retrieve current password
    {
        $sql = "SELECT passwords FROM AdminPW";
        $s = $c -> prepare($sql);
        $s -> execute();
        while($r = $s -> fetch(PDO::FETCH_ASSOC))
        {
            $pwHidden = $r['passwords'];
        }
        return $pwHidden;
    }

    function populate_dropdown($c) //populate drop down of previously attended patrons with first and last name and their IDs
    {
        $all_options = "";
        $sql = "SELECT DISTINCT FirstName, LastName, patID FROM Patrons ORDER BY FirstName";
        $s = $c -> prepare($sql);
        $s -> execute(); 
        while ($r = $s->fetch(PDO::FETCH_ASSOC))
        { 
            $all_options .= "<option class = 'pull-left ddOption' value = '".$r['FirstName']."".$r['LastName']."'>".$r['FirstName']." ".$r['LastName']."      -       ".$r['patID']."</option><br>";
        }
        return $all_options;
    }
     
    function current_market_date() //retrieve the date of the current market (in a human format)
    {
        $c = connDB();
        $sql = "SELECT idByDate FROM Markets WHERE active = 1";
        $s_ce = $c -> prepare($sql);
        $s_ce -> execute();
        $s = $c -> prepare($sql);
        $s -> execute(); 
        if(!$s_ce -> fetch(PDO::FETCH_ASSOC))
        {
            return "WARNING: No Market has been invoked, ask the admin to invoke a market<br><script>location.replace('noActiveMarket.html');</script>";
        }
        else
        {
            while ($r = $s->fetch(PDO::FETCH_ASSOC))
            { 
                $final_date = substr($r['idByDate'], 4, 2)." / ".substr($r['idByDate'],0, 4);
            }
            return $final_date;
        }
        
    }

    function verifyExistence($c, $id) //check if the patrong ID is used by someone
    {
        $sql = "SELECT * FROM Patrons WHERE patID = ".$id;
        $s = $c -> prepare($sql);
        $s -> execute(); 
        if(!$s->fetch(PDO::FETCH_ASSOC)) return false;
        else return true;
    }

    function loginPat($c, $d, $id) //mark and stamp a patron's arrival
    {
        $c = connDB();
        
        date_default_timezone_set("America/Los_Angeles");
        $t = date("H:i");
        
        $time_digits = substr($t, 0, 2).substr($t, 3, 2);
        

        
        $sql = "SELECT time_stamp FROM MarketLogins WHERE Patrons_patID = ".$id." AND Markets_idByDate = ".$d.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        if(!$s->fetch(PDO::FETCH_ASSOC)) 
        {
            $sql = "INSERT INTO MarketLogins (Markets_idByDate, Patrons_patID, time_stamp) VALUES (".$d.", ".$id."., '".$time_digits."');";
            $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $c->exec($sql); 
            echo '<script>alert("WELCOME TO THE MARKET");</script>';
            return;
        }
        else
        {
            echo '<script> alert("You are already logged in"); </script>';
            return; 
        }
     
       
        return; 
    }

    // ======================================================== //
    // ---------------- ADMIN PAGE FUNCTIONS -------------------//
    // ======================================================== //

    function populate_market_dropdown($c) //insert all markets by date to the drop down of markets
    {
        $c = connDB();
        $sql = "SELECT * FROM Markets";
        $s = $c -> prepare($sql); 
        $s -> execute();
        $s_ec = $c ->prepare($sql);
        $s_ec -> execute();
        $active = "Closed";


        if(!$s_ec -> fetch(PDO::FETCH_ASSOC)) //no markets in the datebase, insert special option to dropdown
        {
            return '<option class="dropdown-item midbigger" href="#">No Markets to Show</option>'; 
        }
        while($r = $s -> fetch(PDO::FETCH_ASSOC))
        { 
            if($r['active'] == 1) $active = "Active!";
            else $active = "Closed";
            echo '&nbsp;<option class = "dropdown-item midbigger" href="#">'.substr($r['idByDate'],4,2).' / '.substr($r['idByDate'],6,2).' / '.substr($r['idByDate'],0,4).' - '.$active.'</option><br>';
        }
        return; 
    }

    function verifyPastPasswords($c, $new) //verify old password when chaing the password
    {
        $sql = "SELECT passwords FROM AdminPW";
        $s = $c -> prepare($sql);
        $s -> execute();
        while($r = $s -> fetch(PDO::FETCH_ASSOC))
        {
            if($new == $r['passwords']) return true; //meaning the password has already been in use
        }
        return false;
    }
    
    function newMarket($c, $d) //create new market with the $d date, add to DB
    {
        $sql_existence = "SELECT * FROM Markets WHERE idByDate = ".$date;
        $s = $c -> prepare($sql_existence); 
        $s -> execute(); 
        if($s -> fetch(PDO::FETCH_ASSOC))
        {
            echo '<script> alert("Sorry, This market already exists in the database. Only one market per day."); </script>';
            echo '<script> location.replace("admin.php") </script>';
            return; 
        }
        $sql = "INSERT INTO Markets (idByDate, active, reported, inventory) VALUES (".$d.", 0, 0, 0);"; //0 = not active, 1 = active (tiny int sserving as boolean)
        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c->exec($sql); 
        echo '<script> location.replace("admin.php") </script>'; 
    }

    function verifyOld($c, $oldPW) //make sure the old password is currect when trying to change a password
    {
        $sql = "SELECT passwords FROM AdminPW WHERE current = 1";
        $s = $c -> prepare($sql); 
        $s -> execute(); 
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $oldPWfromDB = $r['passwords'];
        if (md5($oldPW) == $oldPWfromDB) return true;
        else return false;
    }

    function changePWinDB($c, $newPW) //update the password status in the DB to the new password when changing passwords for admin page
    {
        $monthtouse = date("m") + 3;
        if(date("m") > 10) $monthtouse = date("m") - 9; //recycle to the front
        $changeDate = date("Y")."-".$monthtouse."-".date("d");
        $sql = "INSERT INTO AdminPW VALUES ('".md5($newPW)."', '".$changeDate."', 1);";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
        return;
    }

    function updatePWHistory($c, $oldPW) //update the old password to be no longer relevant when changing the password to the admin page
    {
        date_default_timezone_set("America/Los_Angeles");
        $today = date("Y-m-d");
        $sql = "UPDATE AdminPW SET current = 0, changeDate = '".$today."' WHERE passwords = '".md5($oldPW)."';";
        $c -> prepare($sql) -> execute();
        return;
    }

    function activateMarket($c, $d) //from the existing market, activate a market.
    {
        date_default_timezone_set("America/Los_Angeles"); 
        $starttime = date("H:i"); 
        $start_time_format = substr($starttime, 0, 2).substr($starttime, 3, 2);

        $sql = "UPDATE Markets SET active = 1 WHERE idByDate = ".$d.";";
        $sql .= "UPDATE Markets SET starttime = '".$start_time_format."' WHERE idByDate = ".$d.";";
        $c -> prepare($sql) -> execute();
        return;
    }

    function terminateActiveMarket($c, $d) //terminate a market with a status active = 2 (meaning it can no longer be activated again)
    {
        $c = connDB();
        $sql = "UPDATE Markets SET active = 2 WHERE idByDate = ".$d; //active = 2, means closed for good
        
        $c -> prepare($sql) -> execute();
        date_default_timezone_set("America/Los_Angeles"); 
        $closetime = date("H:i");
        $close_time_digits = substr($closetime, 0, 2).substr($closetime, 3, 2);
        $sql = "UPDATE Markets SET closetime = '".$close_time_digits."' WHERE idByDate = ".$d; 
        $s = $c -> prepare($sql);
        $s -> execute();
        echo '<script> location.replace("admin.php") </script>';
        return;
    }

    function changeToDeleteStatus($c, $d) //mark which market we want to delete
    {
        $sql = "UPDATE Markets SET toDelete = 1 WHERE idByDate = ".$d.";";
        $sql .= "UPDATE Markets SET toDelete = 0 WHERE idByDate <> ".$d.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        return;
    }

    function deleteMarket($c) //delete a market from the database
    {
        $sql = "SELECT idByDate FROM Markets WHERE toDelete = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $d = $r['idByDate']; //first retrieve the right market with the idbydate whete the deletion status is updated (see function above)

        //deleting from the database in the right order, so all information regarding that market are deleted
        //maybe I should use database cascades
        $sql = "DELETE FROM MarketLogins WHERE Markets_idByDate = ".$d.";";
        $sql .= "DELETE FROM Patrons WHERE firstMarket = ".$d.";";
        $sql .= "DELETE FROM Items WHERE Markets_idByDate = ".$d.";";
        $sql .= "DELETE FROM Markets WHERE idByDate = ".$d.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        return;
    }

    // ======================================================== //
    // -------------- REPORT PAGE FUNCTIONS --------------------//
    // ======================================================== //

    function generate_report($c, $d) //update report status per market in db, go to report page if there are markets in the database, and to message page if there aren't
    {
        $c = connDB();
        $sql = "UPDATE Markets SET reported = 1 WHERE idByDate = ".$d; 
        $s = $c -> prepare($sql);
        $s -> execute();

        $sql = "UPDATE Markets SET reported = 0 WHERE idByDate <> ".$d; 
        $s = $c -> prepare($sql);
        $s -> execute();

        //check if there are markets in the database
        $sql = "SELECT COUNT(*) FROM MarketLogins WHERE Markets_idByDate = ".$d;
        if(($c -> query($sql) -> fetchColumn()) == 0) echo '<script> location.replace("noCurrentReport");</script>';
        else echo '<script>location.replace("report.php");</script>';
    }

    function pdf_report($c) //generate pdf report
    {
        

        //--------------- report code ---------------------//


        $pdf = new myFPDFClass(); 
        $pdf -> AddPage();
        $pdf -> Heads(connDB());
        $pdf -> tableHead();
        $pdf -> tableBody(connDB());
        $pdf -> signature();
        //$pdf->Output("~report_".$d.".pdf", 'D'); 
        // IMPORTANT NOTE: had to change the modifications of rt.pdf to in order ot edit it with chmod 777 rt.pdf
        $pdf -> Output('rt.pdf', 'F');
        echo '<script>alert("YOUR PDF IS GENERATED AS:  ~report_'.$d.'.pdf  ");</script>';
        return;
    }

    function getAttData($c, $d) //data for attendance graph
    {
        $dformat = substr($d,0,4)."-".substr($d,4,2)."-".substr($d,6,2)." ";
        $sql_times = "SELECT starttime, closetime FROM Markets WHERE idByDate = ".$d;
        $stmt_times = $c -> prepare($sql_times);
        $stmt_times -> execute();
        $t = $stmt_times -> fetch(PDO::FETCH_ASSOC);
        $st = $t['starttime']; 
        $ct = $t['closetime']; 
        //market beginning and end of range based on open time and close time 

        //if market is currently active, we want a live report, so we change the closing time:
        if($t['closetime'] == NULL) 
        {
            date_default_timezone_set("America/Los_Angeles"); 
            $ct = substr(date("H:i"), 0, 2).substr(date("H:i"), 3, 2); 
        }


        $sti = intval($st); 
        //modify time to be based 60 and not 100 
        $interval = $sti + (10 - ($sti%10)); 
        $sql_amount_a = "SELECT COUNT('Patron_patID') FROM MarketLogins WHERE time_stamp < ".($interval)." AND Markets_idByDate = ".$d.";";
        $stmt_amount_a = $c -> query($sql_amount_a);

        //get amount from start time to first interval mark (in 10 minutes)
        $first_amount = $stmt_amount_a -> fetchColumn(); 

        if(strlen(strval($sti)) == 3) $stite = substr(strval($sti), 0, 1).":".substr(strval($sti), 1, 2);
        elseif(strlen(Strval($sti)) == 4) $stite = substr(strval($sti),0,2).":".substr(strval($sti),2,2);
        
        $chart_data = "{TIME:'".$dformat.$stite."',AMOUNT:'".$first_amount."'}";
        //is new hour in the time range of the market, add 40 to create illusion of time based 60 and not 100
        if($interval % 100 == 60) {$interval += 40;} 
        //for every 10 minute interval before the last ten minutes of the closing time
        while(($interval + 10) < intval($ct)) 
        {
            
            if($interval % 100 == 60) {$interval += 40;} 
            $interval_b = $interval + 10; 

            $sql_i = "SELECT COUNT('Patrons_patID') FROM MarketLogins WHERE time_stamp < ".$interval_b." AND time_stamp >= ".$interval." AND Markets_idByDate = ".$d.";";
            $stmt_amount_a = $c -> query($sql_amount_a);
            $stmt_i = $c -> query($sql_i);

            if(strlen(strval($interval)) == 3) $intervalte = substr(strval($interval), 0, 1).":".substr(strval($interval), 1, 2);
            elseif(strlen(Strval($interval)) == 4) $intervalte = substr(strval($interval),0,2).":".substr(strval($interval),2,2);

            $a = $stmt_i -> fetchColumn();
            //insert amount per time range
            $chart_data .= ", {TIME:'".$dformat.$intervalte."',AMOUNT:'".$a."'}"; 
            $interval = $interval_b;
        }
        $sql_i_b = "SELECT COUNT('Patron_patID') FROM MarketLogins WHERE time_stamp >= ".$interval." AND Markets_idByDate = ".$d.";";
        $stmt_amount_a = $c -> query($sql_amount_a);
        $stmt_i_b= $c -> query($sql_i_b);

        if(strlen(strval($interval)) == 3) $intervalte = substr(strval($interval), 0, 1).":".substr(strval($interval), 1, 2);
        elseif(strlen(Strval($interval)) == 4) $intervalte = substr(strval($interval),0,2).":".substr(strval($interval),2,2);


        $a = $stmt_i_b -> fetchColumn();
        //last amount from last time interval stamp to closing time
        $chart_data .= ", {TIME:'".$dformat.$intervalte."',AMOUNT:'".$a."'}"; 

        return $chart_data;
    }
    
    function promGraphData($c, $d) //data for the comparison of promotion methods
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

    function getRetVSNew($c, $d) //data for the comparison of returning vs new patrons per market
    {
        $data = "";
        $sql_newPs = "SELECT COUNT(*) FROM Patrons WHERE firstMarket = ".$d.";";
        $s_newPs = $c -> query($sql_newPs);
        $noobies = $s_newPs -> fetchColumn();

        $sql_allPs = "SELECT COUNT(*) FROM MarketLogins WHERE Markets_idByDate = ".$d.";";
        $s_allPs = $c -> query($sql_allPs);
        $allies = $s_allPs -> fetchColumn();

        //all attendance in that market - patrons whose new market was that market = patrons who attended a previous market AND that market
        $data = "{value: ".$noobies.", label: 'New Patrons'},{value: ".($allies - $noobies).", label: 'Returning Patrons'}";
        return $data;
    }

    // ======================================================== //
    // -------------- INVENTORY PAGE FUNCTIONS -----------------//
    // ======================================================== //

    function insertItem($c, $n, $a) //insert item to the database
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

    function populateItemTable($c) //insert items to inventory html in table format
    {

        $sql_date = "SELECT idByDate FROM Markets WHERE inventory = 1";
        $s_date = $c -> prepare($sql_date);
        $s_date -> execute();
        $r = $s_date -> fetch(PDO::FETCH_ASSOC);
        $d = $r['idByDate'];

        $tableItemData = ""; 
        $sql = "SELECT Name, Amount FROM Items WHERE Markets_idByDate = ".$d;

        $s_ec = $c -> prepare($sql); 
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

            $counter++; //to modify and create unique ID's reflexibly
            $buttonInsert = "<button class = 'btn btn-warning collapsed' id = 'editbtn' data-toggle='collapse' data-target='#formToEditItem".strval($counter)."' aria-expanded='false'> EDIT </button>";
            //add option to edit an item
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

    function changeInventoryStatus($c, $d) //change status of which market we want to inventory
    {
        $sql = "UPDATE Markets SET inventory = 1 WHERE idByDate = ".$d;
        $s = $c -> prepare($sql);
        $s -> execute();

        
        $sql = "UPDATE Markets SET inventory = 0 WHERE NOT idByDate = ".$d; 
        $s = $c -> prepare($sql);
        $s -> execute();

        echo '<script>location.replace("inventory.php");</script>';

        return;
    }

    function updateInventoryItem($c, $n, $a) //update an inventory item
    {
        $sql = "UPDATE Items SET Amount = ".intval($a)." WHERE Name = '".$n."' AND Markets_idByDate = (SELECT idByDate FROM Markets WHERE inventory = 1)";
        $s = $c -> prepare($sql);
        $s -> execute();
        return;
    }
?>