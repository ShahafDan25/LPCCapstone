<?php session_start(); ?>
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
        $n = $_POST['name'];
        $a = $_POST['amount'];
        $d = $_POST['date'];
        if (insertItem($n, $a, $d) == 0) echo displayInventory($_POST['date']);
        else echo "Item already recorded".displayInventory($_POST['date']);
    }
    
    if($_POST['message'] == "changePW") //change admin password
    {
        if(!verifyOld($_POST['oldPW'])) echo "false";
        else if(verifyPastPasswords($_POST['newPW1'])) echo "passeduse";
        else echo updatePW($_POST['oldPW'], $_POST['newPW1']);
    }

    if($_POST['message'] == 'submitNewMarket') //create new market
    {
        newMarket(substr($_POST['new_market_date'],0,4).substr($_POST['new_market_date'],5,2).substr($_POST['new_market_date'],8,2), intval(substr($_POST['new_market_start_time'],0,2).substr($_POST['new_market_start_time'],3,2)), intval(substr($_POST['new_market_end_time'],0,2).substr($_POST['new_market_end_time'],3,2)));
        echo '<script> location.replace("admin.php") </script>'; 
    }

    if($_POST['message'] == 'adminOption') //choose an action option per market
    {
        if($_POST['marketDate'] == "none") echo '<script>alert("Please choose a date");location.replace("admin.php");</script>';
        else
        {
            if($_POST['adminOption'] == "invoke") activateMarket($_POST['marketid']);
            elseif($_POST['adminOption'] == "terminate") terminateActiveMarket($_POST['marketid']);
            elseif($_POST['adminOption'] == "delete") deleteMarket($_POST['marketid']);
        }
        echo '<script> location.replace("admin.php") </script>'; 
        return;
    }

    if($_POST['message'] == "update-inventory-item"){
        updateInventoryItem($_POST['name'], $_POST['amount'], $_POST['date'], $_POST['namechange']);
        echo displayInventory($_POST['date']);
    }

    if($_POST['message'] == 'generate-pdf-report') { //generate pdf report
        $c = connDB(); //create connection;
        $sql = "SELECT active FROM Markets WHERE idByDate = ".$_POST['date'].";";
        $c -> prepare($sql);
        $s = $c -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $c = null; //close connection
        if($r['active'] == 2) {
            pdf_report($_POST['date']);
            echo "true";
        }
        else echo "false";
    }

    if($_POST['message'] == 'verifyPassword') { //verify password to admin page
        if(md5($_POST['inputAdminPW']) == getPassword()) echo "true";
        else echo "false";
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
        echo addVolunteer($_POST['firstname'], $_POST['lastname'], $_POST['email']);
    }

    if($_POST['message'] == "deactivateVolunteer") {
        deactivateVolunteer($_POST['id']);
        echo '<script>location.replace("volunteers.php");</script>';
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

    if($_POST['message'] == "get-email-list") {
        echo volunteerEmailList();
    }

    if($_POST['message'] == "volunteer-login") {
        if(verifyVolunteer($_POST['volunteer-email'])) {
            $_SESSION['volunteer-id'] = $_POST['volunteer-email'];
            echo '<script>location.replace("signups.php");</script>'; 
        }
        else echo '<script>alert("You are not registered as an active volunteer \r\n please contact the admin");</script>';
    }

    if($_POST['message'] == "volunteer-request") {
        if(requestVolunteer($_POST['volunteer-email'], $_POST['first'], $_POST['last'])) echo '<script>alert("Request Submitted!"); location.replace("index.php");</script>';
        echo '<script>alert("You are already in the system!"); location.replace("index.php");</script>';
    }

    if($_POST['message'] == "display-signup-sheet") {
        $_SESSION['volunteer-signup-marketid'] = $_POST['date'];
        echo displaySignupSheets($_POST['date']);
    }

    if($_POST['message'] == "commit-signup") {
        commitSignUp($_SESSION['volunteer-id'], $_SESSION['volunteer-signup-marketid'], $_POST['starttime'], $_POST['endtime']);
        echo '<script>location.replace("signups.php");</script>';
    }

    if($_POST['message'] == "display-volunteer-signup-commits") {
        echo displayVolunteerCommits($_SESSION['volunteer-id'], $_POST['date']);
    }

    if($_POST['message'] == "remove-signup-commit") {
        removeSignUpCommit($_SESSION['volunteer-id'], $_SESSION['volunteer-signup-marketid'], $_POST['starttime'], $_POST['endtime']);
        echo '<script>alert(" Your Sign Up Commit was succesfully removed!"); location.replace("signups.php");</script>';
    }

    if($_POST['message'] == "no-active-market-message") {
        echo checkForActiveMarkets();
    }

    if($_POST['message'] == "approve-pending-vol-request") {
        approvePendingVolunteer($_POST['vol_email']);
        echo displayVolunteersAwaitingActivation();
    }

    if($_POST['message'] == "populate-pending-volunteers") {
        echo displayVolunteersAwaitingActivation();
    }

    if($_POST['message'] == "reactivate-volunteer") {
        reactivateVolunteer($_POST['vol_email']);
        echo displayDeactivatedVolunteers();
    }

    if($_POST['message'] == "remove-volunteer") {
        removeVolunteer($_POST['vol_email']);
        echo displayDeactivatedVolunteers();
    }

    if($_POST['message'] == "display-deactivated-volunteers") {
        echo displayDeactivatedVolunteers();
    }

    if($_POST['message'] == "populate-add-volunteer-form") {
        echo populateAddVolunteerForm();
    }

    if($_POST['message'] == "check-for-active-markets") {
        echo checkForActiveMarkets();
    }

    if($_POST['message'] == "remove-item") {
        removeInventoryItem($_POST['name']);
        echo displayInventory($_POST['date']);
    }
    // ======================================================== //
    // ------------------- GENERAL FUNCTIONS -------------------//
    // ======================================================== //

    function reformatidByDate($idByDate) {
        return substr($idByDate, 4,2)."\t|\t".substr($idByDate,6,2)."\t|\t".substr($idByDate,0,4);
    }

    function checkForActiveMarkets() {
        $c = connDB(); //create connection;
        $sql = "SELECT idByDate FROM Markets WHERE active = 1;";
        $s = $c -> prepare($sql);
        $s -> execute();
        if($s -> fetch(PDO::FETCH_ASSOC)) {
            $c = null; 
            return "true";
        }
        $c = null; //close connection
        return "false";
    }

    function connDB()
    {
        $username = "root";
        $password = "Sdan3189";
        // $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306;socket=/tmp/mysql.sock';  //connection link
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306socket=/tmp/mysql.sock';
        try {$conn = new PDO($dsn, $username, $password);}
        catch (PDOException $e) {echo 'Connection Failed: ' . $e -> getMessage();}
        return $conn;
    }

    // ======================================================== //
    // ------------- REGISTRATION PAGE FUNCTIONS ---------------//
    // ======================================================== //

    function insertPat($c, $f, $l, $ss, $ca, $aa, $sa, $ea, $pn, $pm, $id) //new patrons to DB
    {
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
        '".$email_address."', '".$phone_number."', '".$promotion_method."', ".$id.", (SELECT idByDate FROM Markets WHERE active = 1));";


        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c->exec($sql); 
        echo '<script>location.reaplec("index.php");</script>'; 
    }

    function getPassword() {
        $c = connDB(); //set connection
        $sql = "SELECT passwords FROM AdminPW WHERE current = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $c = null; //close connection
        return $r['passwords'];;
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
        $s = $c -> prepare($sql);
        $s -> execute(); 
        if(!$r = $s -> fetch(PDO::FETCH_ASSOC)) $final_date = "";
        else
        {
            $months = ["January", "February", "March", "April", "May", " June", "July", "August", "September", "October", "November", "December"];
            $final_date = $months[intval(substr($r['idByDate'], 4, 2)) - 1]." / ".substr($r['idByDate'],0, 4);
        }
        $c = null; //close connection;
        return $final_date;
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

    function verifyPastPasswords($new) //verify old password when chaing the password
    {
        $c = connDB();
        $sql = "SELECT passwords FROM AdminPW";
        $s = $c -> prepare($sql);
        $s -> execute();
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            if($new == $r['passwords']) return true; //meaning the password has already been in use
        }
        $c = null; //close connection
        return false;
    }
    
    function newMarket($d, $st, $et) //create new market with the $d date, add to DB
    {
        $c = connDB();
        $sql_existence = "SELECT * FROM Markets WHERE idByDate = ".$date;
        $s = $c -> prepare($sql_existence); 
        $s -> execute(); 
        if($s -> fetch(PDO::FETCH_ASSOC))
        {
            echo '<script> alert("Sorry, This market already exists in the database. Only one market per day."); </script>';
            echo '<script> location.replace("admin.php") </script>';
            return; 
        }
        $sql = "INSERT INTO Markets (idByDate, active, starttime, closetime) VALUES (".$d.", 0, '".$st."', '".$et."');"; //0 = not active, 1 = active (tiny int sserving as boolean)
        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c->exec($sql);
        $c = null; //close connection 
        return;
    }

    function verifyOld($oldPW) //make sure the old password is currect when trying to change a password
    {
        $c = connDB();
        $sql = "SELECT passwords FROM AdminPW WHERE current = 1";
        $s = $c -> prepare($sql); 
        $s -> execute(); 
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $oldPWfromDB = $r['passwords'];
        $c = null; //close connection
        if (md5($oldPW) == $oldPWfromDB) return true;
        else return false;
    }

    function updatePW($oldPW, $newPW) //update the old password to be no longer relevant when changing the password to the admin page
    {
        $c = connDB(); // set connection
        date_default_timezone_set("America/Los_Angeles");
        $today = date("Y-m-d");
        $sql = "UPDATE AdminPW SET current = 0, changeDate = '".$today."' WHERE passwords = '".md5($oldPW)."';";
        $c -> prepare($sql) -> execute();
        //update new password
        $monthtouse = date("m") + 3;
        if(date("m") > 10) $monthtouse = date("m") - 9; //recycle to the front
        $changeDate = date("Y")."-".$monthtouse."-".date("d");
        $sql = "INSERT INTO AdminPW VALUES ('".md5($newPW)."', '".$changeDate."', 1);";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
        $c = null; //close connection
        return "true";
    }

    function activateMarket($date) //from the existing market, activate a market.
    {
        $c = connDB(); //set connection
        date_default_timezone_set("America/Los_Angeles"); 
        $activationtime = date("H:i"); 
        $activation_time_format = substr($starttime, 0, 2).substr($starttime, 3, 2);
        $sql = "SELECT active FROM Markets WHERE idByDate = ".$date.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        if($r['active'] == 2) echo '<script>alert("This market is terminated.\r\n It cannot be activated again");</script>';
        else if ($r['active'] == 1) echo '<script>alert("This market is already active ! ");</script>';
        else {
            $sql = "UPDATE Markets SET active = 1, activationtime = '".$activation_time_format."' WHERE idByDate = ".$date.";";
            $c -> prepare($sql) -> execute();
        }
        $c = null; //close connection
        return;
    }

    function terminateActiveMarket($date) //terminate a market with a status active = 2 (meaning it can no longer be activated again)
    {
        $c = connDB(); //set connection
        date_default_timezone_set("America/Los_Angeles"); 
        $terminationtime = date("H:i"); 
        $termination_time_format = substr($starttime, 0, 2).substr($starttime, 3, 2);
        $sql = "SELECT active FROM Markets WHERE idByDate = ".$date.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        if($r['active'] == 0) echo '<script>alert("This market is not active.\r\n It cannot be terminated before it was activated");</script>';
        else if ($r['active'] == 2) echo '<script>alert("This market has already been terminated ! ");</script>';
        else {
            $sql = "UPDATE Markets SET active = 2, terminationtime = '".$termination_time_format."' WHERE idByDate = ".$date.";";
            $c -> prepare($sql) -> execute();
        }
        $c = null; //close connection
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
        $sql .= "DELETE FROM SignUps WHERE Market = ".$date.";";
        $c -> prepare($sql)-> execute();
        $c = null; //close connection
        return;
    }

    // ======================================================== //
    // -------------- REPORT PAGE FUNCTIONS --------------------//
    // ======================================================== //

    require "otherFiles/fpdf_lib/fpdf.php";
    class myFPDFClass extends FPDF //extend all the features from the FPDF class, but more functions
    {
        function Heads($c)
        {
            $sql = "SELECT idByDate FROM Markets WHERE reported = 1";
            $s = $c -> prepare ($sql);
            $s -> execute();
            $r = $s -> fetch(PDO::FETCH_ASSOC);
            $d = $r['idByDate'];

            $this -> SetFont('Arial', 'B', 20); 
            $this -> Cell(40,12,'The Market   |   LPCSG ', 'C');
            
            $this->Cell( 40, 10, $this->Image("otherFiles/pics/lpcsgLogo.jpg", 120, 5, 35), 0, 0, 'L', false );
            $this->Cell( 40, 10, $this->Image("otherFiles/pics/lpcLogo2.png", 160, 5, 35), 0, 0, 'L', false );

            $this -> Ln();
            $this -> SetFont('Arial', 'B', 12); 
            $this -> Cell (40, 10, 'Report '.substr($d,4,2)." / ".substr($d,6,2)." / ".substr($d,0,4),'C');
            $this -> Ln();
            $this -> Ln();
            return;
        }

        public $totalAdults = 0;
        public $totalKids = 0;
        public $totalPeople = 0;
        public $totalSeniors = 0;
        function tableHead() 
        {
            $this -> SetFont('Arial', 'B', 14); 
            $this -> Cell(60, 10, 'Name', 1, 0, 'C'); 
            $this -> Cell(25, 10, 'Student ?', 1, 0, 'C');
            $this -> Cell(90, 10, 'People in Household', 1, 0, 'C');
            $this -> Ln(); 
            $this -> SetFont('Arial', 'B', 12); 
            $this -> Cell(60, 8, '   -   ', 1, 0, 'C');
            $this -> Cell(25, 8, '   -   ', 1, 0, 'C');
            $this -> Cell(30, 8, 'Kids', 1, 0, 'C');
            $this -> Cell(30, 8, 'Adults', 1, 0, 'C');
            $this -> Cell(30, 8, 'Seniors', 1, 0, 'C');
            $this -> Ln(); 
            return;
        }

        //table body: insert only necessary information from the report page
        function tableBody($c)
        {
            $this -> SetFont('Arial', 'B', 10); 
            $sql_a = "SELECT Patrons_patID FROM MarketLogins WHERE Markets_idByDate = (SELECT idByDate FROM Markets WHERE reported = 1)";
            $s_a = $c -> prepare($sql_a); 
            $s_a -> execute(); 
            $totalPeople = 0;
            $totalKids = 0;
            $totalAdults = 0;
            $totalSeniors = 0;
            while($r_a = $s_a -> fetch(PDO::FETCH_ASSOC))
            { 
                $sql_b = "SELECT FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount FROM Patrons WHERE patID = ".$r_a['Patrons_patID'];
                $s_b = $c -> prepare($sql_b);
                $s_b -> execute();
                while($r_b = $s_b -> fetch(PDO::FETCH_ASSOC)) 
                {
                    $this -> Cell(60, 7, $r_b['FirstName']."  ".$r_b['LastName'], 1, 0, 'C');
                    
                    if($r_b['StudentStatus'] == 1) $this -> Cell(25, 7, "  YES   ", 1, 0, 'C');
                    else $this -> Cell(25, 7, " ", 1, 0, 'C');                    
                    
                    $this -> Cell(30, 7, $r_b['ChildrenAmount'], 1, 0, 'C');
                    $this -> Cell(30, 7, $r_b['AdultsAmount'], 1, 0, 'C');
                    $this -> Cell(30, 7, $r_b['SeniorsAmount'], 1, 0, 'C');
                    $this -> Ln(); 

                    $totalPeople++;
                    $totalKids += $r_b['ChildrenAmount'];
                    $totalAdults += $r_b['AdultsAmount'];
                    $totalSeniors += $r_b['SeniorsAmount']; 
                }
            }   
            // ------------------ averages and statistics ---------------------//
            $this -> Ln();
            $this -> SetFont('Arial', 'B', 14); 
            $this -> Cell(30, 10, 'Statistics: ');
            $this -> Ln();
            $this -> SetFont('Arial','B', 10); 
            $this -> Cell(20, 6, 'Total Patrons: '.$totalPeople.'.  Total People Reported: '.strval($totalAdults+$totalKids+$totalSeniors));
            $this -> Ln();
            $this -> Cell(20, 6, 'Total Kids Reported: '.$totalKids.'.  Average Kids Per Household: '.strval(round($totalKids/$totalPeople, 2)));
            $this -> Ln();
            $this -> Cell(20, 6, 'Total Adults Reported: '.$totalAdults.'.  Average Adults Per Household: '.strval(round($totalAdults/$totalPeople, 2)));
            $this -> Ln();
            $this -> Cell(20, 6, 'Total Seniors Reported: '.$totalSeniors.'.  Average Seniors Per Household: '.strval(round($totalSeniors/$totalPeople, 2)));
            $this -> Ln();
            $this -> Ln();
            return;      
        }

        function signature()
        {
            $this -> SetFont('Arial', 'B', 14); 
            $this -> Cell(30, 10, 'Signatures: ');
            $this -> Ln();
            $this -> Ln();
            $this -> SetFont('Arial'); 
            $this -> Cell(40, 6, '_____________________');
            $this -> Cell(40, 6, '                     ');
            $this -> Cell(40, 6, '_____________________');
            $this -> SetFont('Arial','B', 07); 
            $this -> Ln();
            $this -> Cell(40, 6, 'Student Life Advisor and Coordinator');
            $this -> Cell(40, 6, '                     ');
            $this -> Cell(40, 6, 'Director of Programs and Services');
            return;
        }
    }

    function pdf_report($date) {
        $c = connDB(); //create connection
        //--------------- report code ---------------------//
        $pdf = new myFPDFClass(); 
        $pdf -> AddPage();
        $pdf -> Heads(connDB());
        $pdf -> tableHead();
        $pdf -> tableBody(connDB());
        $pdf -> signature();

        $reportFile = fopen('report_'.strval($date).'.pdf', 'w+');
        fclose($reportFile);
        $pdf -> Output('report_'.$date.'.pdf', 'F');
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

    function getAttData($d){
        $c = connDB();
        $dformat = substr($d,0,4)."-".substr($d,4,2)."-".substr($d,6,2)." ";
        $sql_times = "SELECT activationtime, terminationtime, active FROM Markets WHERE idByDate = ".$d;
        $stmt_times = $c -> prepare($sql_times);
        $stmt_times -> execute();
        $t = $stmt_times -> fetch(PDO::FETCH_ASSOC);
        $st = $t['activationtime']; 
        $ct = $t['terminationtime']; 

        //if market is currently active, we want a live report, so we make the closing time for the current graph the current time:
        if($t['active'] == 1) 
        {
            date_default_timezone_set("America/Los_Angeles"); 
            $ct = substr(date("H:i"), 0, 2).substr(date("H:i"), 3, 2); 
        }
        else if($t['active'] == 0) return "";

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
        $first_person = false;
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
            if($first_person) $chart_data .= ", {'TIME':'".$dformat.$intervalte."','AMOUNT':'".$a."'}"; 
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

    function promGraphData($d) {
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

    function getRetVSNew($d) {
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
        if($totalPeople > 0) {
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
        }

        if(strlen($totalPeople) < 2) return '<br><p> No data to display at the moment </p>';
        else return $table_begin.$data.$table_end.$stats;
    }

    // ======================================================== //
    // -------------- INVENTORY PAGE FUNCTIONS -----------------//
    // ======================================================== //

    function removeInventoryItem($name) {
        $c = connDB(); //set connection
        $sql = "DELETE FROM Items WHERE Name = '".$name."';";
        $c -> prepare($sql) -> execute();
        $c = null; //close connection;
        return;
    }

    function displayInventory($date) {
        $pre_table = 
        '<p class = "pull-left">*  Inventories of Previous Markets</p><br><br>
        <input type = "text" id = "item_name" class = "add-inventory-input half inline" placeholder = " Item Name" autocomplete = "off" required>
        <input type = "number" id = "item_number" class = "add-inventory-input half inline" placeholder = " Quantity" autocomplete = "off" required>
        <button class = "btn add-to-inventory op4 inline" onclick = "insertInventoryItem()";><i class="fa fa-plus" aria-hidden="true"></i></button>
        <br><br>';
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
        if(populateItemTable($date) == "") return $pre_table.'<br><br><p> No item in the inventory at the moment </p>';
        else return $pre_table.$table_begin.populateItemTable($date).$table_end;
    }

    function insertItem($n, $a, $d) //insert item to the database
    {
        $c = connDB(); //set connection
        $sql = "SELECT Name FROM Items WHERE Name = '".$n."' AND Markets_idByDate = ".$d.";";
        $s = $c -> prepare($sql); 
        $s -> execute(); 
        if($s -> fetch(PDO::FETCH_ASSOC)) return 1; // found
 
        $sqlb = "INSERT INTO Items (Name, Amount, Markets_idByDate) VALUES ('".$n."',".$a.", ".$d.");"; 
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sqlb);
        $c = null; //close connection 
        return 0; //no such item in the database
    }

    function populateItemTable($date) //insert items to inventory html in table format
    {
        $c = connDB();
        $tableItemData = ""; 
        $sql = "SELECT DISTINCT Name FROM Items WHERE Markets_idByDate <= '".$date."';";

        $s = $c -> prepare($sql); 
        $s -> execute(); 
        $counter = 0;
        while($r = $s -> fetch(PDO::FETCH_ASSOC))
        { 
            $editForm = "";
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
            $buttonInsert = "<button class = 'btn inv_edit_btn op6 inline' onclick = 'removeItem(".$counter.")' style = 'margin-right: 2% !important'><i class='fa fa-trash-o'></i></button>
                &nbsp; &nbsp;
            <button class = 'btn btn-warning inv_edit_btn inline collapsed' id = 'editbtn' data-toggle='collapse' data-target='#formToEditItem".strval($counter)."' aria-expanded='false' onclick = 'editInventoryItem(".$counter.")'><i class='fa fa-pencil' aria-hidden='true'></i></button>";
            //add option to edit an item
            $editForm .= '<td><input type = "text" class = "inv-edit-input half inline" id = "edit-name-'.$counter.'" placeholder = "'.$r['Name'].'" value = "'.$r['Name'].'" style = "width: 60% !important;"></td>';
            $editForm .= '<td><input type = "number" class = "inv-edit-input half inline" id = "edit-amount-'.$counter.'" min = "0" placeholder = "'.($r_two['Amount']+$total).'" value = "'.($r_two['Amount']+$total).'"></td>';
            $editForm .= '<td><button class = "btn btn add-to-inventory op4 inline" onclick = "updateInventoryItem('.$counter.')":><i class="fa fa-check" aria-hidden="true"></i></button></td>';

            $tableItemData .= "<tr id = 'tr-".$counter."'>";
                $tableItemData .= "<td><input type = 'hidden' value = '".$r['Name']."' id = 'og-name-".$counter."'>".$r['Name']."</td>";
                if($r_two != 0) {$tableItemData .= "<td><strong>".($r_two['Amount'] + $total)."</strong>\t[ ".$r_two['Amount']." + ".$total." * ]</td>";}
                else {$tableItemData .= "<td><strong>".($total)."</strong>\t*</td>";}
                $tableItemData .= "<td style 'text-align: right !important;'>".$buttonInsert."</td>";
            $tableItemData .= "</tr>";
            
            $tableItemData .= "<tr class = 'collapse whiteOut' id = 'formToEditItem".strval($counter)."'>".$editForm."</tr>";
        }
        $c = null; //close connection pretty much 
        return $tableItemData;
    }

    function updateInventoryItem($n, $a, $marketdate, $namechange) //update an inventory item
    {
        $c = connDB();
        
        $total = 0;
        $sql_total = "SELECT Amount FROM Items WHERE Name = '".$n."' AND Markets_idByDate < ".$marketdate.";";
        $s_total = $c -> prepare($sql_total);
        $s_total -> execute();
        while($r_total = $s_total -> fetch(PDO::FETCH_ASSOC)) {
            $total += $r_total['Amount'];
        }

        $sql_amount = "SELECT Amount FROM Items WHERE Name = '".$n."' AND Markets_idByDate = ".$marketdate.";";
        $s_amount = $c -> prepare($sql_amount);
        $s_amount -> execute();
        $r = $s_amount -> fetch(PDO::FETCH_ASSOC);
        $amountTodate = $r['Amount'];

        //set sql query appropriately to data that needs to be updated
        $sql = ""; //query line to add updates (in concatination)
        if(intval($a) > ($total+$amountTodate)) {
            //if exists primary key: update; else: insert
            $sql_ec = "SELECT Amount FROM Items WHERE Name = '".$n."' AND Markets_idByDate = ".$marketdate.";";
            $s_ec = $c -> prepare($sql_ec);
            $s_ec -> execute();
            
            if($s_ec -> fetch(PDO::FETCH_ASSOC)) $sql = "UPDATE Items SET Amount = ".intval($a-$total)." WHERE Name = '".$n."' AND Markets_idByDate = ".$marketdate."";
            else insertItem($c, $n, $a-$total);
        }
        elseif (intval($a) < $amountTodate) {
            $sql = "UPDATE Items SET Amount = 0 WHERE Name = '".$n."' AND Markets_idByDate < ".$marketdate.";";
            $sql .= "UPDATE Items SET Amount = ".intval($a)." WHERE Name = '".$n."' AND Markets_idByDate = ".$date.";";
        }
        elseif(intval($a) > $amountTodate && intval($a) < ($total+$amountTodate)) {
            $a_substract = $amountTodate + $total - $a;
            //get array of all date so far, reduce the max amount from each market one by one
            $previousMarketDates = array();
            $sql_getDates = "SELECT Markets_idByDate FROM Items WHERE Markets_idByDate < ".$marketdate." AND Name = '".$n."';";
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
                else if($a_substract > $amount_minor) {
                    $a_substract = $a_substract-$amount_minor;
                    $sql .= "UPDATE Items SET Amount = 0 WHERE Markets_idByDate = ".$date." AND Name = '".$n."';";
                }
                elseif($a_substract < $amount_minor) $sql .= "UPDATE Items SET Amount = ".intval($amount_minor-$a_substract)." WHERE Markets_idByDate = ".$date." AND Name = '".$n."';";
            }
        }
        //push updates
        $c -> prepare($sql) -> execute();

        //now to see if the name needs to be updated too 
        $sql = "SELECT * FROM Items WHERE Name = '".$namechange."';"; //if does not exist one alreadt
        $s = $c -> prepare($sql);
        $s -> execute();
        if(!$s -> fetch(PDO::FETCH_ASSOC)) {
            $sql = "UPDATE Items SET Name = '".$namechange."' WHERE Name = '".$n."';";
            $c -> prepare($sql) -> execute();
        }
        $c = null; //close connection
        return;
    }

    // ======================================================== //
    // -------------- VOLUNTEER PAGE [S] FUNCTIONS -------------//
    // ======================================================== //

    function addVolunteer($f, $l, $e) {
        $c = connDB();
        if(verifyVolunteer($e) == true) return '<script>alert("This email is already in use by someone");</script>'.populateAddVolunteerForm();
        $sql = "INSERT INTO Volunteers VALUES ('".$f."', '".$l."', '".$e."', NOW(), 1, NULL, NULL);";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
        $c = null;
        return populateAddVolunteerForm();
    }

    function populateAddVolunteerForm() {
        $data =
        '<button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>
        <h4 class = "inline volunteer-section-title"><u>Add a Volunteer</u></h4>
        <br><br>
        <input type = "text" class = "add-volunteer-input full" id = "firstname" placeholder = " First Name" autocomplete = "off"> <br><br>
        <input type = "text" class = "add-volunteer-input full" id = "lastname" placeholder = " Last Name" autocomplete = "off"><br><br>
        <input type = "text" class = "add-volunteer-input full" id = "email" placeholder = " Email Address" autocomplete = "off"><br><br>
        <button class = "btn add-volunteer-btn" onclick = "addVolunteer();"> Submit </button>';
        return $data;
    }

    function displayAllVolunteers() {
        $months = ["January", "February", "March", "April", "May", " June", "July", "August", "September", "October", "November", "December"];
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
            $data .= '<tr><form action = "funcs.php", method = "POST">';
            $data .= '<td><input type = "hidden" value = "'.$r['Email'].'" name = "id">'.$r['First_Name'].' '.$r['Last_Name'].'</td>';
            $data .= '<td>'.$r['Email'].'</td>';
            $data .= '<td>'.$months[intval(substr($r['Start_Date'],5,2)) - 1].' '.substr($r['Start_Date'],8,2).', '.substr($r['Start_Date'],0,4).'</td>';
            $data .= '<td><input type = "hidden" name = "message" value = "deactivateVolunteer"><button class = "btn btn-warning" style = "border-radius: 150px !important;"><i class="fa fa-power-off" aria-hidden="true"></i></button></td>';
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
        $months = ["January", "February", "March", "April", "May", " June", "July", "August", "September", "October", "November", "December"];
        $c = connDB();
        $sql = "SELECT Email, First_Name, Last_Name, Deactivation_Date FROM Volunteers WHERE Active = 0;";
        $s = $c -> prepare($sql);
        $s -> execute();
        $data = "";
        $div_begin = '<button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>
        <h4 class = "inline volunteer-section-title"><u>Deactivated Volunteers</u></h4>
        <br><br><hr class = "spacebar-dark"><br>
        <div id = "deactivate-volunteer-table">';
        $table_begin = '<table class = "table"><thead><tr><th> Name </th><th> Email </th><th> Deactivation Date </th><th> Activate </th><th> Delete </th></tr></thead><tbody>';
        $table_end = '</tbody></table></div>';
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= '<tr>';
            $data .= '<td><input type = "hidden" value = "'.$r['Email'].'" name = "id">'.$r['First_Name'].' '.$r['Last_Name'].'</td>';
            $data .= '<td>'.$r['Email'].'</td>';
            $data .= '<td style = "text-align: center !important;">'.$months[intval(substr($r['Deactivation_Date'],5,2)) - 1].' '.substr($r['Deactivation_Date'],8,2).', '.substr($r['Deactivation_Date'],0,4).'</td>';
            $data .= '<td><button class = "btn btn-activate-volunteer" id = "'.$r['Email'].'" onclick = "reactivateVolunteer(this.id)"><i class="fa fa-plus" aria-hidden="true"></i></button></td>';
            $data .= '<td><button class = "btn btn-remove-deactivated-volunteer" id = "'.$r['Email'].'" onclick = "removeVolunteer(this.id)"><i class="fa fa-minus" aria-hidden="true"></i></button></td>';
            $data .= '</tr>';
        }
        $c = null;
        if(strlen($data) < 2) return $div_begin.'<p> No Deactivated Volunteers To Display At The Moment</p><br></div><br>';
        else return $div_begin.$table_begin.$data.$table_end;
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
        if(strlen($data) < 2) return '<p style = "margin-left: 20% !important;"> Sorry, No volunteers are detected in the database</p><br><br>';
        else return $table_begin.$data.$table_end;
    }

    function volunteerEmailList() {
        $c = connDB();
        $sql = "SELECT Email FROM Volunteers WHERE Active = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        $data = "";
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= ",".$r['Email'];
        }
        $c = null;
        return $data;
    }
        
    function verifyVolunteer($email) {
        $return = true;
        $c = connDB();
        $sql = "SELECT * FROM Volunteers WHERE Email = '".$email."';";
        $s = $c -> prepare($sql);
        $s -> execute();
        
        $c = null; //close connection
        if($s -> fetch(PDO::FETCH_ASSOC)) return true; // which means it is found
        else return false; // not found
    }

    function requestVolunteer($email, $first, $last) {
        if(verifyVolunteer($email)) return false; //do not insert
        $c = connDB();
        $sql = "INSERT INTO Volunteers VALUES('".$first."', '".$last."', '".$email."', NULL, 2, NULL, NULL);";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
        $c = null; //close connection
        return true;
    }

    function displayVolunteersAwaitingActivation() {
        $c = connDB();
        $div_begin =  '
        <button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>
                <h4 class = "inline volunteer-section-title"><u>Pending Volunteers</u></h4>
                <br><br><br><hr class = "spacebar-dark"><br>
                <div id = "pending-volunteers-div">';
        $table_begin = 
        '<table class = "table">
            <thead>
                <tr>
                    <th> Name </th>
                    <th> Email </th>
                    <th> Activate </th>
                </tr>
            </thead>
            <tbody>';
        $table_end_div_end = 
            '</tbody>
        </table></div>';
        $data = "";
        $sql = "SELECT First_Name, Last_Name, Active, Email FROM Volunteers WHERE Active = 2";
        $s = $c -> prepare($sql);
        $s -> execute();
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= "<tr>";
                $data .= "<td>".$r['First_Name']." ".$r['Last_Name']."</td>";
                $data .= "<td>".$r['Email']."</td>";
                $data .= 
                "<td style = 'text-align: center !important;'>
                    <button class = 'btn actiate-volunteer-option op4 inline' id = 'vol-request-".$r['Email']."' onclick = 'approveRequest(this.id);'>
                        <i class = 'fa fa-plus' aria-hidden = 'true'></i>
                    </button>
                </td>";
            $data .= "</tr>";
        }
        $c = null; //close connection
        if(strlen($data) < 2) return $div_begin."<p> No Volunteers Are Pending Activation </p></div>";
        else return $div_begin.$table_begin.$data.$table_end_div_end;
    }

    function approvePendingVolunteer($email) {
        $c = connDB();
        $sql = "UPDATE Volunteers SET Active = 1, Start_Date = NOW() WHERE Email = '".$email."';";
        $c -> prepare($sql) -> execute();
        $c = null; //close connection;
        return;
    }

    function reactivateVolunteer($email){
        $c = connDB();
        $sql = "UPDATE Volunteers SET Active = 1 WHERE Email = '".$email."';";
        $c -> prepare($sql) -> execute();
        return;
    }

    function removeVolunteer($email) {
        $c = connDB();
        $sql = "DELETE FROM Volunteers WHERE Email = '".$email."';";
        $c -> prepare($sql) -> execute();
        $c = null; //close connection
        return;
    }

    // ======================================================== //
    // --------------- SIGN UP PAGE [S] FUNCTIONS ------------- //
    // ======================================================== //
    
    function volunteer_name_from_email($email) {
        $c = connDB();
        $sql = "SELECT First_Name, Last_Name FROM Volunteers WHERE Email = '".$email."';";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $c = null; //close connection;
        return $r['First_Name']." ".$r['Last_Name'];
    }

    function populateNonTerminatedMarketsDropDown() {
        $c = connDB();
        $sql = "SELECT idByDate, Active FROM Markets WHERE Active = 1 OR Active = 0;";
        $s = $c -> prepare($sql);
        $s -> execute();
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            if($r['Active'] == 1) $data .= '<option class = "market-date-option" value = '.$r['idByDate'].'>'.reformatidByDate($r['idByDate']).': Active! </option>';
            else $data .= '<option class = "market-date-option" value = '.$r['idByDate'].'>'.reformatidByDate($r['idByDate']).'</option>';
        }
        $c = null; //close connection
        if(strlen($data) < 2) return '<p> Sorry, No Markets detected in the database </p>';
        else return $data;
    }

    function displaySignupSheets($marketDate) {
        $dataFound = false;
        $colors = ["#343A40", "#DC3545", "#20C997", "#17A2B8", "#FFC107", "#6610F2", "#E83E8C", "#6C757D", "#007BFF"];
        $textcolors = ["White", "Black", "Black", "Black", "Black", "White", "Black", "White", "Black"];
        $c = connDB();
        $sql = "SELECT starttime, closetime FROM Markets WHERE idByDate = '".$marketDate."';";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $st = $r['starttime'];
        $et = $r['closetime'];
        $data = "<h6><strong><u>Volunteer Schedule</strong></u>  ".substr($st,0,2).":".substr($st,2,2)."<i class = 'fa fa-arrow-right' aria-hidden = 'true' style = 'margin-right: 1% !important; margin-left: 1% !important;'></i>".substr($et,0,2).":".substr($et,2,2)."</h6><br>";
        $diffHours = intval(substr($et, 0, 2)) - intval(substr($st, 0, 2)) - 1;
        $begDiffMin = 6 - intval(substr($st, 2, 2))/10;
        $finDiffMin = intval(substr($et, 2, 2))/10 + 1;
        $totalTensMins = $diffHours*6 + $begDiffMin + $finDiffMin;
        $sql = "SELECT v.First_Name, v.Last_Name, v.Profile_Picture, su.Start_Time, su.End_Time, v.Email FROM Volunteers v JOIN SignUps su ON su.Email = v.Email WHERE su.Market = '".$marketDate."' ORDER BY su.Start_Time;";
        $s = $c -> prepare($sql);
        $s -> execute();
        $counter = -1;
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $dataFound = true;
            $personDiffHours = intval(substr($r['End_Time'], 0, 2)) - intval(substr($r['Start_Time'], 0, 2)) - 1;
            $personBegDiffMin = 6 - intval(substr($r['Start_Time'], 3, 2))/10;
            $personFinDiffMin = intval(substr($r['End_Time'], 3, 2))/10;
            $personName = $r['First_Name']." ".$r['Last_Name'];
            if($counter == count($colors)) $counter = 0;
            else $counter ++; //this puts $counter at $counter = 0 for this first person in the list
            $personTensMins = $personDiffHours*6 + $personBegDiffMin + $personFinDiffMin;
            $fraction = number_format((number_format($personTensMins,3,'.','')/number_format($totalTensMins,3,'.','')), 3, '.', '');
            // --------- CALCULATE MARGIN: -------------
            $afbg = intval(substr($r['Start_Time'], 0, 2)) - intval(substr($st, 0, 2)) - 1;
            $bfbg = 6 - intval(substr($st, 2, 2))/10;
            $cfbg = intval(substr($r['Start_Time'], 3, 2))/10;
            $tensFromBeg = $afbg*6 + $bfbg + $cfbg;
            $marginleft = number_format((number_format($tensFromBeg,3,'.','')/number_format($totalTensMins,3,'.','')), 3, '.', '');
            $afbg = intval(substr($et, 0, 2)) - intval(substr($r['End_Time'], 0, 2)) - 1;
            $bfbg = 6 - intval(substr($r['Start_Time'], 2, 2))/10;
            $cfbg = intval(substr($et, 3, 2))/10;
            $tensFromBeg = $afbg*6 + $bfbg + $cfbg;
            $marginright = number_format((number_format($tensFromBeg,3,'.','')/number_format($totalTensMins,3,'.','')), 3, '.', '');
            $data .= 
            '<div style = "width: 100% !important; !important;">
                <div style = "width = '.($fraction*100).'% !important; margin-left: '.($marginleft*100).'%!important; background-color: '.$colors[$counter].' !important; margin-right: '.($marginright*100).'% !important; color: '.$textcolors[$counter].' !important; border-radius: 150px !important; height: auto !important; font-weight: bolder !important; font-size: 85% !important; font-family: Helvetica, Arial, sans-serif !important; padding: 0.5% 0 0.5% 0 !important;">';
            if($_SESSION['volunteer-id'] == $r['Email']) $data .= "Me";
            else $data .= $personName;
            $data .= '<br>';
            $data .= substr($r['Start_Time'],0,5)." <i class = 'fa fa-arrow-right' aria-hidden = 'true' style = 'margin-right: 1% !important; margin-left: 1% !important;'></i> ".substr($r['End_Time'],0,5);
            $data .= '</div>
            </div>
            ';
        }
        $c = null; //close connection
        if(!$dataFound) return '<h6><strong><u>No Volunteers Are Registered for this Market</strong></u></h6>';
        return $data;
    }

    function commitSignUp($vol, $mar, $start, $end) {
        $c = connDB();
        $sql = "INSERT INTO SignUps VALUES ('".$vol."', ".$mar.", '".$start.":00', '".$end.":00');";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
        $c = null; //close connection
        return;
    }

    function displayVolunteerCommits($vol, $mar) {
        $c = connDB();
        $table_begin = 
        '<br><h6><strong><u> Your Sign Up Commits For This Market</u>:</strong></h6>
        <table class = "table">
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>';
        $table_end =
            '</tbody>
        <table>';
        $data = "";
        $sql = "SELECT Start_Time, End_Time FROM SignUps WHERE Email = '".$vol."' AND Market = ".$mar.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= '<tr>
                <td>'.substr($r['Start_Time'],0,5).'</td>
                <td>'.substr($r['End_Time'],0,5).'</td>
                <td>
                    <form action = "funcs.php" method = "POST">
                    <input type = "hidden" name = "starttime" value = "'.substr($r['Start_Time'],0,5).'">
                    <input type = "hidden" name = "endtime" value = "'.substr($r['End_Time'],0,5).'">
                    <input type = "hidden" name = "message" value = "remove-signup-commit">
                    <button class = "btn remove-signup-commit">
                        <i class = "fa fa-times" aria-hidden = "true"></i>
                    </button>
                </td>
            </tr></form>';
        }
        $c = null; //close connection
        if(strlen($data) < 2) return "<br>";
        else return $table_begin.$data.$table_end;
    }

    function removeSignUpCommit($vol, $mar, $start, $end) {
        $c = connDB();
        $sql = "DELETE FROM SignUps WHERE Email = '".$vol."' AND Start_Time = '".$start."' AND End_Time = '".$end."' AND Market = ".$mar.";";
        $c -> prepare($sql) -> execute();
        $c = null; // close connection
        return;
    }
?>