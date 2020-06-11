<?php include "moreFPDF.php"; ?>
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
        $d = $_POST['date'];
        insertItem(connDB(), $n, $a, $d);
        echo '<script> location.replace("inventory.php"); </script>';
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
        if($_POST['marketDate'] == "none") echo '<script>alert("Please choose a date");location.replace("admin.php");</script>';
        else
        {
            if($_POST['adminOption'] == "invoke") activateMarket($_POST['date']);
            // elseif($_POST['adminOption'] == "report") generate_report(connDB(), $d_f);
            elseif($_POST['adminOption'] == "terminate") terminateActiveMarket($_POST['date']);
            // elseif($_POST['adminOption'] == "inventory") changeInventoryStatus(connDB(), $d_f);
            elseif($_POST['adminOption'] == "deleteMarket") deleteMarket($_POST['marketid']);
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

    if($_POST['message'] == "add-volunteer") {
        addVolunteer($_POST['firstname'], $_POST['lastname'], $_POST['email']);
        echo '<script>location.replace("volunteers.php");</script>';
    }

    if($_POST['message'] == "deactivateVolunteer") {
        deactivateVolunteer($_POST['id']);
        echo '<script>location.replace("volunteers.php");</script>';
    }

    if($_POST['message'] == "activateVolunteer") {
        if(isset($_POST['activate'])) activateVolunteer($_POST['id']);
        else if (isset($_POST['delete'])) deleteVolunteer($_POST['id']);
        echo '<script>location.replace("volunteers.php");</script>';
    }

    if($_POST['message'] == "display-form-pdf-report") {
       echo displayPdfReportGenerationForm();
    }

    if($_POST['message'] == "start-market-report-session") {
        echo displayReportPage($_POST['date']);
    }

    if($_POST['message'] == "populate-attendance-graph") {
        echo displayAttGraph($_POST['date']);
    }

    if($_POST['message'] == "populate-promotion-graph") {
        echo displayPromGraph($_POST['date']);
    }

    if($_POST['message'] == "populate-newones-graph") {
        echo displayNoobsGraph($_POST['date']);
    }

    if($_POST['message'] == "display-inventory-table") {
        echo displayInventory($_POST['date']);
    }

    if($_POST['message'] == "display-inventory-add-item-form") {
        echo displayAddInventoryForm($_POST['date']);
    }

    if($_POST['message'] == "get-email-list") {
        echo volunteerEmailList();
    }
    // ======================================================== //
    // ------------------- GENERAL FUNCTIONS -------------------//
    // ======================================================== //

    function reformatidByDate($idByDate) {
        return substr($idByDate, 4,2)."\t|\t".substr($idByDate,6,2)."\t|\t".substr($idByDate,0,4);
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

    function populateArrayWithIds($c)
    {
        $idsArray = "";
        $sql = "SELECT patID FROM Patrons";
        $s = $c -> prepare($sql);
        $s -> execute(); 
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $idsArrays .= '"'.$r['patID'].'"';
        while ($r = $s->fetch(PDO::FETCH_ASSOC))
        { 
            $idsArrays .= ', "'.$r['patID'].'"';
        }
        return $idsArrays;
    }

    function populate_dropdown($c) //populate drop down of previously attended patrons with first and last name and their IDs
    {
        $all_options = "";
        $sql = "SELECT DISTINCT FirstName, LastName, patID FROM Patrons ORDER BY FirstName";
        $s = $c -> prepare($sql);
        $s -> execute(); 
        $counter = 0;
        while ($r = $s->fetch(PDO::FETCH_ASSOC))
        { 
            $counter++;
            if($counter <= 6) $all_options .= "<li class='list-group-item' value = '".$r['patID']."'>".$r['FirstName']." ".$r['LastName']."      -       ".$r['patID']."</li>";
            else $all_options .= "<li class='list-group-item' value = '".$r['patID']."'>".$r['FirstName']." ".$r['LastName']."      -       ".$r['patID']."</li>";
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

    function activateMarket($date) //from the existing market, activate a market.
    {
        $c = connDB(); //set connection
        date_default_timezone_set("America/Los_Angeles"); 
        $starttime = date("H:i"); 
        $start_time_format = substr($starttime, 0, 2).substr($starttime, 3, 2);
        $sql = "SELECT active FROM Markets WHERE idByDate = ".$date.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        if($r['active'] == 2) echo '<script>alert("This market is terminated.\r\n It cannot be activated it again");</script>';
        else if ($r['active'] == 1) echo '<script>alert("This market is already active ! ");</script>';
        else {
            $sql = "UPDATE Markets SET active = 1 WHERE idByDate = ".$date.";";
            $sql .= "UPDATE Markets SET starttime = '".$start_time_format."' WHERE idByDate = ".$date.";";
            $c -> prepare($sql) -> execute();
        }
        $c = null; //close connection
        return;
    }

    function terminateActiveMarket($date) //terminate a market with a status active = 2 (meaning it can no longer be activated again)
    {
        $c = connDB(); //set connection
        $sql = "UPDATE Markets SET active = 2 WHERE idByDate = ".$date.";"; //active = 2, means closed for good
        $c -> prepare($sql) -> execute();
        date_default_timezone_set("America/Los_Angeles"); 
        $closetime = date("H:i");
        $close_time_digits = substr($closetime, 0, 2).substr($closetime, 3, 2);
        $sql = "UPDATE Markets SET closetime = '".$close_time_digits."' WHERE idByDate = ".$date.";"; 
        $c -> prepare($sql) -> execute(); 
        $c = null; // close connection
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

    function deleteMarket($date) //delete a market from the database
    {
        // NOTE: consider using cacades instead!
        $c = connDB(); //set connection
        $sql = "DELETE FROM MarketLogins WHERE Markets_idByDate = ".$date.";";
        $sql .= "DELETE FROM Patrons WHERE firstMarket = ".$date.";";
        $sql .= "DELETE FROM Items WHERE Markets_idByDate = ".$date.";";
        $sql .= "DELETE FROM Markets WHERE idByDate = ".$date.";";
        $c -> prepare($sql)-> execute();
        $c = null; //close connection
        return;
    }

    // ======================================================== //
    // -------------- REPORT PAGE FUNCTIONS --------------------//
    // ======================================================== //

    function displayPdfReportGenerationForm() {
        return 
            '<form action = "funcs.php" method = "post" class = "request-pdf-report-form">
                <input type = "hidden" value = "pdfreport" name = "message">
                <button  class = "inline btn request-pdf-report-btn"> Generate PDF Report </button>
            </form>';
    }

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

        $sql = "SELECT idByDate FROM Markets WHERE reported = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);

        $reportFile = fopen('report_'.strval($r['idByDate']).'.pdf', 'w+');
        // var_dump(error_get_last()); //display error
        fclose($reportFile);
        $pdf -> Output('report_'.strval($r['idByDate']).'.pdf', 'F');
        echo '<script>alert("YOUR PDF IS GENERATED AS: report_'.strval($r['idByDate']).'.pdf  ");</script>';
        return;
    }

    function displayAttGraph($rep){
        return "<script>Morris.Line({
            element : 'chart', 
            data:[".getAttData($rep)."], 
            xkey:'TIME',
            ykeys:['AMOUNT'],
            labels:['Attendance'],
            hideHover:'auto',
            stacked:true
        });</script>";
    }

    function getAttData($d) //data for attendance graph
    {
        $c = connDB();
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
        $sql_amount_a = "SELECT COUNT('Patrons_patID') FROM MarketLogins WHERE time_stamp < ".($interval)." AND Markets_idByDate = ".$d.";";
        $stmt_amount_a = $c -> query($sql_amount_a);

        //get amount from start time to first interval mark (in 10 minutes)
        $first_amount = $stmt_amount_a -> fetchColumn(); 

        if(strlen(strval($sti)) == 3) $stite = substr(strval($sti), 0, 1).":".substr(strval($sti), 1, 2);
        elseif(strlen(Strval($sti)) == 4) $stite = substr(strval($sti),0,2).":".substr(strval($sti),2,2);
        
        $chart_data = "{'TIME':'".$dformat.$stite."','AMOUNT':'".$first_amount."'}";
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
            $chart_data .= ", {'TIME':'".$dformat.$intervalte."','AMOUNT':'".$a."'}"; 
            $interval = $interval_b;
        }
        $sql_i_b = "SELECT COUNT('Patron_patID') FROM MarketLogins WHERE time_stamp >= ".$interval." AND Markets_idByDate = ".$d.";";
        $stmt_amount_a = $c -> query($sql_amount_a);
        $stmt_i_b= $c -> query($sql_i_b);

        if(strlen(strval($interval)) == 3) $intervalte = substr(strval($interval), 0, 1).":".substr(strval($interval), 1, 2);
        elseif(strlen(Strval($interval)) == 4) $intervalte = substr(strval($interval),0,2).":".substr(strval($interval),2,2);


        $a = $stmt_i_b -> fetchColumn();
        //last amount from last time interval stamp to closing time
        $chart_data .= ", {'TIME':'".$dformat.$intervalte."','AMOUNT':'".$a."'}"; 
        $c = null; //close connection
        return $chart_data;
    }
    
    function displayPromGraph($rep) {
        return "<script>Morris.Bar({
            element: 'promGraph', 
            data:[".promGraphData($rep)."], 
            xkey:'METHOD',
            ykeys:['AMOUNT'],
            labels:['Impact'],
            hideHover:'auto',
            stacked:true,
            barColors: ['#4DA74D'],
            barSizeRatio:0.40,
            resize:false
        });</script>";
    }

    function promGraphData($d) //data for the comparison of promotion methods
    {
        $data = "";
        $c = connDB();
        //COMMUNITY
        $sql_a = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Community' AND MarketLogins.Markets_idByDate = ".$d;
        $s_a = $c -> query($sql_a);
        $comm = $s_a -> fetchColumn();
        $data .= "{'METHOD': 'Community','AMOUNT':'".$comm."'}";
        //FRIENDS AND FAMILY
        $sql_b = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'FriendsAndFamily' AND MarketLogins.Markets_idByDate = ".$d;
        $s_b = $c -> query($sql_b);
        $fnf = $s_b -> fetchColumn();
         $data .= ", {'METHOD': 'Friends / Family','AMOUNT':'".$fnf."'}";
        // CLASSROOM
        $sql_c = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Classroom' AND MarketLogins.Markets_idByDate = ".$d;
        $s_c = $c -> query($sql_c);
        $class = $s_c -> fetchColumn();
        $data .= ", {'METHOD':'Classroom','AMOUNT':'".$class."'}";
        //OTHER
        $sql_d = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Other' AND MarketLogins.Markets_idByDate = ".$d;
        $s_d = $c -> query($sql_d);
        $other = $s_d -> fetchColumn();
        $data .= ", {'METHOD':'Other','AMOUNT':'".$other."'}";
        $c = null;
        return $data;
    }

    function displayNoobsGraph($rep) {
        return "<script>Morris.Donut({
                element: 'retvsnew',
                data: [".getRetVSNew($rep)."],
                colors:['#994d00','#ffa64d']
            });</script>";
    }

    function getRetVSNew($d) //data for the comparison of returning vs new patrons per market
    {
        $c = connDB();
        $data = "";
        $sql_newPs = "SELECT COUNT(*) FROM Patrons WHERE firstMarket = ".$d.";";
        $s_newPs = $c -> query($sql_newPs);
        $noobies = $s_newPs -> fetchColumn();

        $sql_allPs = "SELECT COUNT(*) FROM MarketLogins WHERE Markets_idByDate = ".$d.";";
        $s_allPs = $c -> query($sql_allPs);
        $allies = $s_allPs -> fetchColumn();

        //all attendance in that market - patrons whose new market was that market = patrons who attended a previous market AND that market
        $data = "{value: ".$noobies.", label: 'New Patrons'},{value: ".($allies - $noobies).", label: 'Returning Patrons'}";
        $c = null;
        return $data;
    }

    function populateMarketsDropDown() {
        $c = connDB();
        $sql = "SELECT idByDate FROM Markets";
        $s = $c -> prepare($sql);
        $s -> execute();
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= '<option class = "market-date-option" value = '.$r['idByDate'].'>'.reformatidByDate($r['idByDate']).'</option>';
        }
        $c = null; //close connection
        if(strlen($data) < 2) return '<p> Sorry, No Markets detected in the database </p>';
        else return $data;
    }

    function displayReportPage($rep) {
        $c = connDB();
        $table_begin = 
        '<table class = "table">
            <thead>
                <tr>
                <th scope="col"> Name</th>
                <th scope="col">Student?</th>
                <th scope="col">Kids</th>
                <th scope="col">Adults</th>
                <th scope="col">Seniors</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Promotion</th>
                </tr>
            </thead>
            <tbody>';
        $table_end = '</tbody>
        </table>';
        $data = ""; 
        $sql = "SELECT p.FirstName, p.LastName, p.StudentStatus, p.ChildrenAmount, p.AdultsAmount, p.SeniorsAmount, p.EmailAdd, p.PhoneNumber, p.PromotionMethod FROM Patrons p JOIN MarketLogins ml ON ml.Patrons_patID = p.patID WHERE ml.Markets_idByDate = '".$rep."' ORDER BY ml.time_stamp;";
        $s = $c -> prepare($sql);
        $s -> execute(); 
        $totalPeople = 0;
        $totalKids = 0;
        $totalAdults = 0;
        $totalSeniors = 0;
        while($r = $s -> fetch(PDO::FETCH_ASSOC))
        { 
            $totalPeople++;
            $totalKids += $r['ChildrenAmount'];
            $totalAdults += $r['AdultsAmount'];
            $totalSeniors += $r['SeniorsAmount'];

            $data .= "<tr><td scope='row'>".$r['FirstName']." ".$r['LastName']."</td>";
            
            if($r['StudentStatus'] == 1) $data .= "<td style = 'text-align: center'><div class = 'student-status-check'><i class='fa fa-check' aria-hidden='true'></i></div></td>";
            else $data .= "<td style = 'text-align: center'><div class = 'student-status-uncheck'><i class='fa fa-times' aria-hidden='true'></i></div></td>";

            $data .= "<td>".$r['ChildrenAmount']."</td>";
            $data .= "<td>".$r['AdultsAmount']."</td>";
            $data .= "<td>".$r['SeniorsAmount']."</td>";
            $data .= "<td>".$r['EmailAdd']."</td>";
            $data .= "<td>".$r['PhoneNumber']."</td>";
            $data .= "<td>".$r['PromotionMethod']."</td></tr>";
        } 
        $c = null;
        $stats = '<p><strong><u>Total Attendees</u></strong>:';
        $stats .= $totalPeople.'&nbsp;&nbsp;&nbsp;&nbsp;';
        $stats .= '<strong><u>Total Children (0 - 17)</u></strong>:';
        $stats .= $totalKids.'&nbsp;&nbsp;&nbsp;&nbsp;';
        $stats .= '<strong><u>Total Adults (18 - 64)</u></strong>:';
        $stats .= $totalAdults.'&nbsp;&nbsp;&nbsp;&nbsp;';
        $stats .= '<strong><u>Total Seniors (65 +)</u></strong>:';
        $stats .= $totalSeniors.'&nbsp;&nbsp;&nbsp;&nbsp;<br>';

        $stats .= '<strong><u>Average Children (0 - 17)</u></strong>:'; 
        $stats .= round($totalKids/$totalPeople, 2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $stats .= '<strong><u>Average Adults (18 - 64)</u></strong>:'; 
        $stats .= round($totalAdults/$totalPeople, 2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $stats .= '<strong><u>Average Seniors (65 +)</u></strong>:'; 
        $stats .= round($totalSeniors/$totalPeople, 2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $stats .= '<br>* Average is per a registered household';
        $stats .= '</p>';

        if(strlen($data) < 2) return '<p> No data to display at the moment </p>';
        else return $table_begin.$data.$table_end.$stats;
    }


    // ======================================================== //
    // -------------- INVENTORY PAGE FUNCTIONS -----------------//
    // ======================================================== //
    function displayAddInventoryForm($date) {
        return 
        '<h4><u> ADD TO INVENTORY </u></h4>
        <br>
        <form action = "adminFuncs.php" method = "post">
            <input type = "text" name = "item_name" class = "add-inventory-input w80" placeholder = " Item Name" autocomplete = "off"><br><br>
            <input type = "number" name = "item_number" class = "add-inventory-input w80" placeholder = " Quantity" autocomplete = "off"><br><br>
            <input type = "hidden" name = "message" value = "insertItem">
            <input type = "hidden" name = "date" value = "'.$date.'">
            <button class = "add-inventory-btn"> ADD ITEM </button>
        </form>';
    }

    function displayInventory($date) {
        $pre_table = 
        '<p class = "pull-left">*  Inventories of Previous Markets</p>
        <br><br>
        <h4><u> INVENTORY </u></h4>
        <br>';
        $table_begin = 
        '<table class = "table inv_table">
            <thead>
                <tr>
                    <th scope = "col" class = "inv_label"> ITEM NAME </th>
                    <th scope = "col" class = "inv_label"> QUANTITY </th>
                    <th scope = "col" class = "inv_edit_btn-label"> ~ EDIT ~ </th>
                </tr>
            </thead>
            <tbody>';
        $table_end = 
            '</tbody>
        </table>';
        return $pre_table.$table_begin.populateItemTable($date).$table_end;
    }

    function insertItem($c, $n, $a, $d) //insert item to the database
    {
        $sql = "SELECT Name FROM Items WHERE Name = '".$n."' AND Markets_idByDate = '".$d."';";
        $s = $c -> prepare($sql); 
        $s -> execute(); 
        if($s -> fetch(PDO::FETCH_ASSOC))
        {
            echo '<script>alert("This item is already found in the database for this market. Please edit its amount by click the View Inventory button");</script>';
            return;
        }
        $sqlb = "INSERT INTO Items (Name, Amount, Markets_idByDate) VALUES ('".$n."',".$a.", '".$d."');"; 
        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c->exec($sqlb); 
        return;
    }

    function populateItemTable($date) //insert items to inventory html in table format
    {
        $c = connDB();
        $tableItemData = ""; 
        $sql = "SELECT DISTINCT Name FROM Items WHERE Markets_idByDate <= '".$date."';";
        $s_ec = $c -> prepare($sql); 
        $s_ec -> execute();
        $r_ec = $s_ec -> fetch(PDO::FETCH_ASSOC);
        if(count($r_ec) == 0)  return '<p> NO ITEMS TO DISPLAY AT THE MOMENT </p>';

        $s = $c -> prepare($sql); 
        $s -> execute(); 
        $collapseCounter = 0;
        while($r = $s -> fetch(PDO::FETCH_ASSOC))
        { 
            //select product's amount from previous markets
            $total = 0;
            $sql_total = "SELECT Amount FROM Items WHERE Name = '".$r['Name']."' AND Markets_idByDate < '".$date."';";
            $s_total = $c -> prepare($sql_total);
            $s_total -> execute();
            while($r_total = $s_total -> fetch(PDO::FETCH_ASSOC))
            {
                $total += $r_total['Amount'];
            }

            $sql_two = "SELECT Amount FROM Items WHERE Markets_idByDate = '".$date."' AND Name = '".$r['Name']."';";
            $s_two = $c -> prepare($sql_two);
            $s_two -> execute();
            $r_two = $s_two -> fetch(PDO::FETCH_ASSOC);


            $counter++; //to modify and create unique ID's reflexibly
            $buttonInsert = "<button class = 'btn btn-warning inv_edit_btn collapsed' id = 'editbtn' data-toggle='collapse' data-target='#formToEditItem".strval($counter)."' aria-expanded='false'><i class='fa fa-pencil' aria-hidden='true'></i></button>";
            //add option to edit an item
            $editForm = '<form action = "adminFuncs.php" method = "post">';
            $editForm .= '<td><input type = "text" class = "inv_input inline" name = "editItemName" placeholder = "'.$r['Name'].'" value = "'.$r['Name'].'" style = "width: 60% !important;"></td>';
            $editForm .= '<td><input type = "number" class = "inv_input inline" name = "editItemAmount" min = "0" placeholder = "'.($r_two['Amount']+$total).'" value = "'.($r_two['Amount']+$total).'"></td>';
            $editForm .= '<td><input type = "hidden" class = "inline" name = "message" value = "editThatItem">';
            $editForm .= '<button class = "btn btn-success inv_input_btn inline"> SUBMIT </button></td>';
            $editForm .= '</form>';
            // ============================================================== //
            $tableItemData .= "<tr>";
                $tableItemData .= "<td>".$r['Name']."</td>";
                if($r_two != 0) {$tableItemData .= "<td><strong>".($r_two['Amount'] + $total)."</strong>\t[ ".$r_two['Amount']." + ".$total." * ]</td>";}
                else {$tableItemData .= "<td><strong>".($total)."</strong>\t*</td>";}
                $tableItemData .= "<td>".$buttonInsert."</td>";
            $tableItemData .= "</tr>";
            
            $tableItemData .= "<tr class = 'collapse whiteOut' id = 'formToEditItem".strval($counter)."'>".$editForm."</tr>";
        }
        $c = null; //close connection pretty much 
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
        $total = 0;
        $sql_total = "SELECT Amount FROM Items WHERE Name = '".$n."' AND Markets_idByDate < (SELECT idByDate FROM Markets WHERE inventory = 1);";
        $s_total = $c -> prepare($sql_total);
        $s_total -> execute();
        while($r_total = $s_total -> fetch(PDO::FETCH_ASSOC))
        {
            $total += $r_total['Amount'];
        }

        $sql_amount = "SELECT Amount FROM Items WHERE Name = '".$n."' AND Markets_idByDate = (SELECT idByDate FROM Markets WHERE inventory = 1);";
        $s_amount = $c -> prepare($sql_amount);
        $s_amount -> execute();
        $r = $s_amount -> fetch(PDO::FETCH_ASSOC);
        $amountTodate = $r['Amount'];

        //set sql query appropriately to data that needs to be updated
        $sql = ""; //query line to add updates (in concatination)
        if(intval($a) > ($total+$amountTodate))
        {
            //if exists primary key: update; else: insert
            $sql_ec = "SELECT Amount FROM Items WHERE Name = '".$n."' AND Markets_idByDate = (SELECT idByDate FROM Markets WHERE inventory = 1);";
            $s_ec = $c -> prepare($sql_ec);
            $s_ec -> execute();
            
            if($s_ec -> fetch(PDO::FETCH_ASSOC)) $sql = "UPDATE Items SET Amount = ".intval($a-$total)." WHERE Name = '".$n."' AND Markets_idByDate = (SELECT idByDate FROM Markets WHERE inventory = 1)";
            else insertItem($c, $n, $a-$total);
        }
        elseif (intval($a) < $amountTodate)
        {
            $sql = "UPDATE Items SET Amount = 0 WHERE Name = '".$n."' AND Markets_idByDate < (SELECT idByDate FROM Markets WHERE inventory = 1);";
            $sql .= "UPDATE Items SET Amount = ".intval($a)." WHERE Name = '".$n."' AND Markets_idByDate = (SELECT idByDate FROM Markets WHERE inventory = 1);";
        }
        elseif(intval($a) > $amountTodate && intval($a) < ($total+$amountTodate)) //or perhaps JUST else?
        {
            $a_substract = $amountTodate + $total - $a;
            //get array of all date so far, reduce the max amount from each market one by one
            $previousMarketDates = array();
            $sql_getDates = "SELECT Markets_idByDate FROM Items WHERE Markets_idByDate < (SELECT idByDate FROM Markets WHERE inventory = 1) AND Name = '".$n."';";
            $s_getDates = $c -> prepare($sql_getDates);
            $s_getDates -> execute();
            while($r_getDates = $s_getDates -> fetch(PDO::FETCH_ASSOC))
            {
                array_push($previousMarketDates, $r_getDates['Markets_idByDate']); //early markets come first (0,1,2,3...)
            }
            //now for each one of the previous markets:
            foreach ($previousMarketDates as &$date)
            {
                $sql_minor = "SELECT Amount FROM Items WHERE Name = '".$n."' AND Markets_idByDate = ".$date.";";
                $s_minor = $c -> prepare($sql_minor);
                $s_minor -> execute();
                $r_minor = $s_minor -> fetch(PDO::FETCH_ASSOC);
                $amount_minor = $r_minor['Amount'];
                if($a_substract == $amount_minor) $sql .= "UPDATE Items SET Amount = 0 WHERE Markets_idByDate = ".$date." AND Name = '".$n."';";
                else if($a_substract > $amount_minor) 
                {
                    $a_substract = $a_substract-$amount_minor;
                    $sql .= "UPDATE Items SET Amount = 0 WHERE Markets_idByDate = ".$date." AND Name = '".$n."';";
                }
                elseif($a_substract < $amount_minor) $sql .= "UPDATE Items SET Amount = ".intval($amount_minor-$a_substract)." WHERE Markets_idByDate = ".$date." AND Name = '".$n."';";
            }
        }
        //push updates
        $c -> prepare($sql) -> execute();
        return;
    }

    // ======================================================== //
    // -------------- VOLUNTEER PAGE FUNCTIONS -----------------//
    // ======================================================== //

    function addVolunteer($f, $l, $e) {
        $c = connDB();
        $sql = "INSERT INTO Volunteers VALUES ('".$f."', '".$l."', '".$e."', NOW(), 1, NULL);";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
        $c = null;
        return;
    }

    function displayAllVolunteers() {
        $data = "";
        $table_begin = 
            '<table class = "table">
                <thead>
                    <tr>
                        <th> Name </th>
                        <th> Email </th>
                        <th> Add Date </th>
                        <th> Deactivate </th>
                    </tr>
                </thead>
            <tbody>';
        $table_end = '</tbody></table>';
        $c = connDB();
        $sql = "SELECT Email, First_Name, Last_Name, Start_Date FROM Volunteers WHERE Active = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= '<tr><form action ="funcs.php", method = "POST">';
            $data .= '<td><input type = "hidden" value = "'.$r['Email'].'" name = "id">'.$r['First_Name'].' '.$r['Last_Name'].'</td>';
            $data .= '<td>'.$r['Email'].'</td>';
            $data .= '<td>'.$r['Start_Date'].'</td>';
            $data .= '<td><input type = "hidden" name = "message" value = "deactivateVolunteer"><button class = "btn btn-warning">Deactivate</button></td>';
            $data .= '</form></tr>';
        }
        $c = null;
        if(strlen($data) < 2) return '<p style = "float: left !important; margin-left: 20% !important;"> Sorry, No volunteers are detected in the database</p><br><br>';
        else return $table_begin.$data.$table_end;
    }

    function deactivateVolunteer($id) {
        $c = connDB();
        $sql = "UPDATE Volunteers SET Active = 0, Deactivation_Date = NOW() WHERE Email = '".$id."';";
        $c -> prepare($sql) -> execute();
        $c = null;
        return;
    }

    function displayDeactivatedVolunteers() {
        $c = connDB();
        $sql = "SELECT Email, First_Name, Last_Name, Deactivation_Date FROM Volunteers WHERE Active = 0;";
        $s = $c -> prepare($sql);
        $s -> execute();
        $data = "";
        $table_begin = '<table class = "table"><thead><tr><th> Name </th><th> Email </th><th> Deactivation Date </th><th> Activate </th><th> Delete </th></tr></thead><tbody>';
        $table_end = '</tbody></table>';
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= '<tr><form action ="funcs.php", method = "POST">';
            $data .= '<td><input type = "hidden" value = "'.$r['Email'].'" name = "id">'.$r['First_Name'].' '.$r['Last_Name'].'</td>';
            $data .= '<td>'.$r['Email'].'</td>';
            $data .= '<td>'.$r['Deactivation_Date'].'</td>';
            $data .= '<td><input type = "hidden" name = "message" value = "activateVolunteer"><button class = "btn btn-success" name = "activate">Activate</button></td>';
            $data .= '<td><button class = "btn btn-danger" name = "delete">Delete</button></td>';
            $data .= '</form></tr>';
        }
        $c = null;
        if(strlen($data) < 2) return '<p style = "float: left !important; margin-left: 20% !important;"> Sorry, No deactivated volunteers are detected in the database</p><br><br>';
        else return $table_begin.$data.$table_end;
    }

    function activateVolunteer($id) {
        $c = connDB();
        $sql = "UPDATE Volunteers SET Active = 1, Deactivation_Date = Null, Start_Date = NOW() WHERE Email = '".$id."';";
        $c -> prepare($sql) -> execute();
        $c = null; //colse connection
        return;
    }

    function deleteVolunteer($id) {
        $c = connDB();
        $sql = "DELETE FROM Volunteers WHERE Email = '".$id."';";
        $c -> prepare($sql) -> execute();
        $c = null; 
        return;
    }

    function displayVolunteerEmailList() {
        $c = connDB();
        $sql = "SELECT Email FROM Volunteers WHERE Active = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        $data = "";
        $table_begin = '<table class = "table">';
        $table_end = '</table> <br>';
        $counter = 0;
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            if($counter % 3 == 0) $data .= '<tr>';
            $data .= '<td>'.$r['Email'].'</td>';
            if($counter % 3 == 2) $data .= '</tr>';
            $counter++;
        }
        $c = null;
        if(strlen($data) < 2) return '<p style = "float: left !important; margin-left: 20% !important;"> Sorry, No volunteers are detected in the database</p><br><br>';
        else return $table_begin.$data.$table_end;
    }

    function volunteerEmailList() {
        $c = connDB();
        $sql = "SELECT Email FROM Volunteers WHERE Active = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        $data = "";
        if($r = $s -> fetch(PDO::FETCH_ASSOC)) $data = $r['Email'];
        else echo '<script>alert("Sorry, you do not have any volunteers to email");</script>';
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= ",".$r['Email'];
        }
        $c = null;
        return $data;
    }
        
    ?>