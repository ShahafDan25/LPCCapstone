<?php session_start(); require "otherFiles/fpdf_lib/fpdf.php";?>
<?php
    class myFPDFClass extends FPDF //extend all the features from the FPDF class, but more functions
    {
        function Heads($d)
        {
            $months = ["January", "February", "March", "April", "May", " June", "July", "August", "September", "October", "November", "December"];
            $this -> SetFont('Arial', 'B', 20); 
            $this -> Cell(40,12,'The Market   |   LPCSG ', 'C');
            
            $this->Cell( 40, 10, $this->Image("otherFiles/pics/lpcsgLogo.jpg", 120, 5, 35), 0, 0, 'L', false );
            $this->Cell( 40, 10, $this->Image("otherFiles/pics/lpcLogo2.png", 160, 5, 35), 0, 0, 'L', false );

            $this -> Ln();
            $this -> SetFont('Arial', 'B', 12); 
            $this -> Cell (40, 10, 'Report '.$months[(intval(substr($d,4,2)))]." ".substr($d,6,2).", ".substr($d,0,4),'C');
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
            $this -> SetFont('Arial', 'B', 10); 
            $this -> Cell(25, 10, 'LPC Student', 1, 0, 'C');
            $this -> SetFont('Arial', 'B', 14); 
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
        function tableBody($date)
        {
            $c = connDB(); //set connection
            $this -> SetFont('Arial', 'B', 10); 
            $sql = "SELECT p.FirstName, p.LastName, p.StudentStatus, p.ChildrenAmount, p.AdultsAmount, p.SeniorsAmount FROM Patrons p JOIN MarketLogins ml ON ml.Patrons_patID = p.patID WHERE ml.Markets_idByDate = '".$date."' ORDER BY p.FirstName, p.LastName;";
            $s = $c -> prepare($sql); 
            $s -> execute(); 
            $totalPeople = 0;
            $totalKids = 0;
            $totalAdults = 0;
            $totalSeniors = 0;
            while($r = $s -> fetch(PDO::FETCH_ASSOC))
            { 
                $this -> Cell(60, 7, $r['FirstName']."  ".$r['LastName'], 1, 0, 'C');
                
                $this -> SetFont('ZapfDingbats','', 10);
                if($r['StudentStatus'] == 1) $this -> Cell(25, 7, "  4  ", 1, 0, 'C');
                else $this -> Cell(25, 7, " ", 1, 0, 'C');                    
                
                $this -> SetFont('Arial', 'B', 10); 
                $this -> Cell(30, 7, $r['ChildrenAmount'], 1, 0, 'C');
                $this -> Cell(30, 7, $r['AdultsAmount'], 1, 0, 'C');
                $this -> Cell(30, 7, $r['SeniorsAmount'], 1, 0, 'C');
                $this -> Ln(); 

                $totalPeople++;
                $totalKids += $r['ChildrenAmount'];
                $totalAdults += $r['AdultsAmount'];
                $totalSeniors += $r['SeniorsAmount']; 
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
    // ======================================================== //
    // -------------------- POSTS MESSAGES ---------------------//
    // ======================================================== //

    if($_POST['message'] == "loadidsarray") {
        echo populateArrayWithIds();
    }

    if($_POST['message'] == "insertItem") {
        $n = $_POST['name'];
        $a = $_POST['amount'];
        $d = $_POST['date'];
        if (insertItem($n, $a, $d) == 0) echo displayInventory($_POST['date']);
        else echo "Item already recorded".displayInventory($_POST['date']);
    }
    
    if($_POST['message'] == "changePW") {
        if(!verifyOld($_POST['oldPW'])) echo "false";
        else if(verifyPastPasswords($_POST['newPW1'])) echo "passeduse";
        else echo updatePW($_POST['oldPW'], $_POST['newPW1']);
    }

    if($_POST['message'] == 'submitNewMarket') {
        echo newMarket(substr($_POST['new_market_date'],0,4).substr($_POST['new_market_date'],5,2).substr($_POST['new_market_date'],8,2), intval(substr($_POST['new_market_start_time'],0,2).substr($_POST['new_market_start_time'],3,2)), intval(substr($_POST['new_market_end_time'],0,2).substr($_POST['new_market_end_time'],3,2)));
    }

    if($_POST['message'] == 'adminOption') //choose an action option per market
    {
        if($_POST['date'] == "none") echo "nodatechosen";
        else
        {
            if($_POST['adminOption'] == "invoke") echo activateMarket($_POST['date']);
            elseif($_POST['adminOption'] == "terminate") echo terminateActiveMarket($_POST['date']);
            elseif($_POST['adminOption'] == "delete") echo deleteMarket($_POST['date']);
        }
    }

    if($_POST['message'] == "update-inventory-item"){
        updateInventoryItem($_POST['name'], $_POST['amount'], $_POST['date'], $_POST['namechange']);
        echo displayInventory($_POST['date']);
    }

    if($_POST['message'] == 'generate-pdf-report') { //generate pdf report
        $c = connDB(); //create connection;
        $sql = "SELECT active FROM Markets WHERE idByDate = ".$_POST['date'].";";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        if($r['active'] == 2) echo pdf_report($_POST['date']);
        else echo "false";
        $c = null; //close connection

    }

    if($_POST['message'] == 'verifyPassword') { //verify password to admin page
        if(md5($_POST['inputAdminPW']) == getPassword()) echo "true";
        else echo "false";
    }

    if($_POST['message'] == 'insertNewPats') //new patron visited the market, add to DB
    {
        insertPat($_POST["first_name"], $_POST["last_name"], $_POST["studentStatus"], $_POST["children_amount"], $_POST["adults_amount"], $_POST["seniors_amount"], $_POST["email_address"], $_POST["phone_number"], $_POST["promotion"],$_POST["patron_id"]);
        loginPat($_POST['patron_id']);
    }

    if($_POST['message'] == 'patronLogin') {
        echo loginPat($_POST['patronID']);
    }

    if($_POST['message'] == "add-volunteer") {
        echo addVolunteer($_POST['firstname'], $_POST['lastname'], $_POST['email']);
    }

    if($_POST['message'] == "deactivateVolunteer") {
        echo deactivateVolunteer($_POST['id']);
    }

    if($_POST['message'] == "display-inventory-table") {
        echo displayInventory($_POST['date']);
    }

    if($_POST['message'] == "get-email-list") {
        echo volunteerEmailList();
    }

    if($_POST['message'] == "volunteer-login") {
        if(verifyVolunteer($_POST['volunteerEmail'])) {
            $_SESSION['volunteer-id'] = $_POST['volunteerEmail'];
            echo "true"; 
        }
        else echo "false";
    }

    if($_POST['message'] == "volunteer-request") {
        echo requestVolunteer($_POST['volunteerEmail'], $_POST['first'], $_POST['last']); 
    }

    if($_POST['message'] == "display-signup-sheet") {
        $_SESSION['volunteer-signup-marketid'] = $_POST['date'];
        echo displaySignupSheets($_POST['date']);
    }

    if($_POST['message'] == "commit-signup") {
        echo commitSignUp($_SESSION['volunteer-id'], $_POST['date'], $_POST['starttime'], $_POST['endtime']);
    }

    if($_POST['message'] == "display-volunteer-signup-commits") {
        echo displayVolunteerCommits($_SESSION['volunteer-id'], $_POST['date']);
    }

    if($_POST['message'] == "remove-signup-commit") {
        echo removeSignUpCommit($_SESSION['volunteer-id'], $_POST['date'], $_POST['starttime'], $_POST['endtime']);
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
        echo reactivateVolunteer($_POST['vol_email']);
    }

    if($_POST['message'] == "remove-volunteer") {
        removeVolunteer($_POST['vol_email']);
        echo displayDeactivatedVolunteers();
    }

    if($_POST['message'] == "display-deactivated-volunteers") {
        echo displayDeactivatedVolunteers();
    }

    if($_POST['message'] == "check-for-active-markets") {
        echo checkForActiveMarkets();
    }

    if($_POST['message'] == "remove-item") {
        removeInventoryItem($_POST['name']);
        echo displayInventory($_POST['date']);
    }

    if($_POST['message'] == "get-current-market-date") {
        echo current_market_date();
    }

    if($_POST['message'] == "populate-like-returning-patrons") {
        echo populate_dropdown($_POST['likename']);
    }

    if($_POST['message'] == "populate-markets-dropdown") {
        echo '<select class = "select-markets" id = "marketid" onchange = "changedMarketId()">'.populateMarketsDropDown().'</select>';
    }

    if($_POST['message'] == "populate-nonterminated-markekts-dropdown") {
        echo '<select class = "select-markets" id = "marketid" onchange = "showbtns()">'.populateNonTerminatedMarketsDropDown().'</select>';
    }

    if($_POST['message'] == "populate-volunteer-name") {
        echo volunteer_name_from_email($_SESSION['volunteer-id']);
    } 

    if($_POST['message'] == "load-email-list") {
        echo displayVolunteerEmailList();
    }

    if($_POST['message'] == "load-volunteers-table") {
        echo displayAllVolunteers();
    }

    if($_POST['message'] == "display-needed-times") {
        echo displayNeededTimes($_POST['date']);
    }

    if($_POST['message'] == "display-needed-times-input") {
        echo displayNeededTimesInputs($_POST['date']);
    }

    if($_POST['message'] == "populate-att-table") {
        echo displayReportPage($_POST['date']);
    }

    if($_POST['message'] == "start-market-report-session") {
        $_SESSION['reportedmarket'] = $_POST['date'];
    }

    if($_POST['message'] == "display-att-graph") {
        echo getAttData($_POST['date']);
    }

    if($_POST['message'] == "display-prom-graph") {
        echo promGraphData($_POST['date']);
    }

    if($_POST['message'] == "display-noobies-graph") {
        echo getRetVSNew($_POST['date']);
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

    function populateMarketsDropDown() {
        $c = connDB();
        $sql = "SELECT idByDate FROM Markets";
        $s = $c -> prepare($sql);
        $s -> execute();
        $data = "";
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= '<option class = "market-date-option" value = '.$r['idByDate'].'>'.reformatidByDate($r['idByDate']).'</option>';
        }
        $c = null; //close connection
        if(strlen($data) < 2) return '<option value = "none" selected disabled> No Markets Found </option>';
        else return '<option value = "none" selected disabled hidden> Choose a Market </option>'.$data;
    }

    function connDB(){
        $username = "root";
        $password = "MMB3189@A";
        // $password = "Sdan3189";
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306socket=/tmp/mysql.sock';
        try {$conn = new PDO($dsn, $username, $password);}
        catch (PDOException $e) {
            echo 'Connection Failed: ' . $e -> getMessage();
            return connDB();
        }
        return $conn;
    }

    // ======================================================== //
    // ------------- REGISTRATION PAGE FUNCTIONS ---------------//
    // ======================================================== //

    function insertPat($f, $l, $ss, $ca, $aa, $sa, $ea, $pn, $pm, $id) //new patrons to DB
    {
        $c = connDB(); //set connection

        if($ss == "yes") $student_status = TRUE;
        else $student_status = FALSE;

        $sql  = "INSERT INTO Patrons (FirstName, LastName, StudentStatus,
        ChildrenAmount, AdultsAmount, SeniorsAmount, EmailAdd, PhoneNumber, PromotionMethod, patID, firstMarket)
        VALUES ('".$f."', '".$l."', '".($student_status?1:0)."', 
        '".((int)$ca)."', '".((int)$aa)."', '".((int)$sa)."', 
        '".$ea."', '".$pn."', '".$pm."', ".$id.", (SELECT idByDate FROM Markets WHERE active = 1));";


        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c->exec($sql); 
        return;
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

    function populateArrayWithIds() {
        $c = connDB(); //set connection
        $idsArray = "";
        $sql = "SELECT patID FROM Patrons";
        $s = $c -> prepare($sql);
        $s -> execute(); 
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $idsArrays .= '"'.$r['patID'].'"';
        while ($r = $s -> fetch(PDO::FETCH_ASSOC)){ 
            $idsArrays .= ', "'.$r['patID'].'"';
        }
        $c = null; //close connection
        return $idsArrays;
    }

    function populate_dropdown($likename) {
        $c = connDB(); //set connection
        $all_options = "";
        $sql = "SELECT DISTINCT FirstName, LastName, patID FROM Patrons WHERE REPLACE(CONCAT(FirstName, LastName), ' ', '') LIKE '".$likename."%' ORDER BY FirstName";
        $s = $c -> prepare($sql);
        $s -> execute(); 
        $counter = 0;
        while ($r = $s->fetch(PDO::FETCH_ASSOC))
        { 
            $counter++;
            if($counter <= 6) $all_options .= "<li class='list-group-item' value = '".$r['patID']."'>".$r['FirstName']." ".$r['LastName']."      -       ".$r['patID']."</li>";
            else $all_options .= "<li class='list-group-item' value = '".$r['patID']."'>".$r['FirstName']." ".$r['LastName']."      -       ".$r['patID']."</li>";
        }
        $c = null; //close connection
        return $all_options;
    }
     
    function current_market_date() {
        $c = connDB();
        $sql = "SELECT idByDate FROM Markets WHERE active = 1";
        $s = $c -> prepare($sql);
        $s -> execute(); 
        if(!$r = $s -> fetch(PDO::FETCH_ASSOC)) $final_date = "";
        else{
            $months = ["January", "February", "March", "April", "May", " June", "July", "August", "September", "October", "November", "December"];
            $final_date = $months[intval(substr($r['idByDate'], 4, 2)) - 1]." / ".substr($r['idByDate'],0, 4);
        }
        $c = null; //close connection;
        return $final_date;
    }

    function loginPat($id) {
        $c = connDB(); //set connection
        
        date_default_timezone_set("America/Los_Angeles");
        $t = date("H:i");
        
        $time_digits = substr($t, 0, 2).substr($t, 3, 2);
        
        $sql = "SELECT time_stamp FROM MarketLogins WHERE Patrons_patID = ".$id." AND Markets_idByDate = (SELECT idByDate FROM Markets WHERE active = 1);";
        $s = $c -> prepare($sql);
        $s -> execute();
        if(!$s->fetch(PDO::FETCH_ASSOC)) {
            $sql = "INSERT INTO MarketLogins (Markets_idByDate, Patrons_patID, time_stamp) VALUES ((SELECT idByDate FROM Markets WHERE active = 1), ".$id."., '".$time_digits."');";
            $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $c->exec($sql);
            $c = null; //close connection
            return "true";
        }
        else return "false";
    }

    // ======================================================== //
    // ---------------- ADMIN PAGE FUNCTIONS -------------------//
    // ======================================================== //

    function verifyPastPasswords($new){
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
    
    function newMarket($d, $st, $et) {
        $c = connDB();
        $sql_existence = "SELECT * FROM Markets WHERE idByDate = ".$date;
        $s = $c -> prepare($sql_existence); 
        $s -> execute(); 
        if($s -> fetch(PDO::FETCH_ASSOC)) return "false";

        $sql = "INSERT INTO Markets (idByDate, active, starttime, closetime) VALUES (".$d.", 0, '".$st."', '".$et."');"; //0 = not active, 1 = active (tiny int sserving as boolean)
        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c->exec($sql);
        $c = null; //close connection 
        return "true";
    }

    function verifyOld($oldPW) {
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

    function updatePW($oldPW, $newPW) {
        $c = connDB(); // set connection
        $sql = "UPDATE AdminPW SET current = 0, changeDate = CURDATE() WHERE passwords = '".md5($oldPW)."';";
        $c -> prepare($sql) -> execute();
        //update new password
        $sql = "INSERT INTO AdminPW VALUES ('".md5($newPW)."', CURDATE(), 1);";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
        $c = null; //close connection
        return "true";
    }

    function activateMarket($date) {
        $c = connDB(); //set connection
        date_default_timezone_set("America/Los_Angeles"); 
        $activationtime = date("H:i"); 
        $activation_time_format = substr($activationtime, 0, 2).substr($activationtime, 3, 2);
        $sql = "SELECT active FROM Markets WHERE idByDate = ".$date.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        if($r['active'] == 2) return "cantactivateterminated";
        else if ($r['active'] == 1) return "alreadyactive";
        else {
            $sql = "UPDATE Markets SET active = 1, activationtime = '".$activation_time_format."' WHERE idByDate = ".$date.";";
            $c -> prepare($sql) -> execute();
        }
        $c = null; //close connection
        return "activated";
    }

    function terminateActiveMarket($date) {
        $c = connDB(); //set connection
        date_default_timezone_set("America/Los_Angeles"); 
        $terminationtime = date("H:i"); 
        $termination_time_format = substr($terminationtime, 0, 2).substr($terminationtime, 3, 2);
        $sql = "SELECT active FROM Markets WHERE idByDate = ".$date.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        if($r['active'] == 0) return "notactive";
        else if ($r['active'] == 2) return "alreadyterminated";
        else {
            $sql = "UPDATE Markets SET active = 2, terminationtime = '".$termination_time_format."' WHERE idByDate = ".$date.";";
            $c -> prepare($sql) -> execute();
        }
        $c = null; //close connection
        return "terminated";
    }

    function deleteMarket($date) {
        // NOTE: consider using cacades instead!
        $c = connDB(); //set connection
        $sql = "DELETE FROM MarketLogins WHERE Markets_idByDate = ".$date.";";
        $sql .= "DELETE FROM Patrons WHERE firstMarket = ".$date.";";
        $sql .= "DELETE FROM Items WHERE Markets_idByDate = ".$date.";";
        $sql .= "DELETE FROM SignUps WHERE Market = ".$date.";";
        $sql .= "DELETE FROM Markets WHERE idByDate = ".$date.";";
        $c -> prepare($sql)-> execute();
        $c = null; //close connection
        return "deleted";
    }

    // ======================================================== //
    // -------------- REPORT PAGE FUNCTIONS --------------------//
    // ======================================================== //

   

    function pdf_report($date) {
        $c = connDB(); //create connection
        //--------------- report code ---------------------//
        $pdf = new myFPDFClass(); 
        $pdf -> AddPage();
        $pdf -> Heads($date);
        $pdf -> tableHead();
        $pdf -> tableBody($date);
        $pdf -> signature();

        $reportFile = fopen('report_'.strval($date).'.pdf', 'w+');
        fclose($reportFile);
        $pdf -> Output('report_'.$date.'.pdf', 'F');
        return "true";
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

        //modify time to be based 60 and not 100 
        $interval = intval($st) + (10 - (intval($st)%10));         
        if($interval % 100 == 60) $interval += 40;
        $first_person = false;
        while($interval < intval($ct)) 
        {
            if(!$first_person) {
                $sql_amount_a = "SELECT COUNT('Patrons_patID') FROM MarketLogins WHERE time_stamp < ".($interval)." AND Markets_idByDate = ".$d.";";
                $stmt_amount_a = $c -> query($sql_amount_a);
                $a = $stmt_amount_a -> fetchColumn(); 

                if(strlen(strval($interval)) == 3) $intervalte = substr(strval($interval), 0, 1).":".substr(strval($interval), 1, 2);
                else if(strlen(Strval($interval)) == 4) $intervalte = substr(strval($interval),0,2).":".substr(strval($interval),2,2);
                $interval_b = $interval + 10; 
                $interval = $interval_b;
            } 
            else {
                if($interval % 100 == 60) {$interval += 40;} 
                $interval_b = $interval + 10; 
    
                $sql_i = "SELECT COUNT('Patrons_patID') FROM MarketLogins WHERE time_stamp < '".$interval_b."' AND time_stamp >= '".$interval."' AND Markets_idByDate = ".$d.";";
                $stmt_i = $c -> query($sql_i);
    
                if(strlen(strval($interval)) == 3) $intervalte = substr(strval($interval), 0, 1).":".substr(strval($interval), 1, 2);
                else if(strlen(Strval($interval)) == 4) $intervalte = substr(strval($interval),0,2).":".substr(strval($interval),2,2);
    
                $a = $stmt_i -> fetchColumn();
                         
                $interval = $interval_b;
            }
            $chart_data [] = array (
                "TIME" => $dformat.$intervalte,
                "AMOUNT" => $a 
            );  
            $first_person = true;
        }
        
        $c = null; //close connection
        return json_encode($chart_data);
    }

    function promGraphData($d) {
        $c = connDB();
        //COMMUNITY
        $sql_a = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Community' AND MarketLogins.Markets_idByDate = ".$d;
        $s_a = $c -> query($sql_a);
        $comm = $s_a -> fetchColumn();
        $data [] = array (
            "METHOD" => "Community",
            "AMOUNT" => $comm
        ); 
        //FRIENDS AND FAMILY
        $sql_b = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'FriendsAndFamily' AND MarketLogins.Markets_idByDate = ".$d;
        $s_b = $c -> query($sql_b);
        $fnf = $s_b -> fetchColumn();
        $data [] = array (
            "METHOD" => "Friends / Family",
            "AMOUNT" => $fnf
        ); 
        // CLASSROOM
        $sql_c = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Classroom' AND MarketLogins.Markets_idByDate = ".$d;
        $s_c = $c -> query($sql_c);
        $class = $s_c -> fetchColumn();
        $data [] = array (
            "METHOD" => "Classroom",
            "AMOUNT" => $class
        ); 
        //OTHER
        $sql_d = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Other' AND MarketLogins.Markets_idByDate = ".$d;
        $s_d = $c -> query($sql_d);
        $other = $s_d -> fetchColumn();
        $data [] = array (
            "METHOD" => "Other",
            "AMOUNT" => $other
        ); 
        $c = null;
        return json_encode($data);
    }

    function getRetVSNew($d) {
        $c = connDB();
        $sql_newPs = "SELECT COUNT(*) FROM Patrons WHERE firstMarket = ".$d.";";
        $s_newPs = $c -> query($sql_newPs);
        $noobies = $s_newPs -> fetchColumn();
        $data [] = array(
            "value" => $noobies,
            "label" => 'New Patrons'
        );
        $sql_allPs = "SELECT COUNT(*) FROM MarketLogins WHERE Markets_idByDate = ".$d.";";
        $s_allPs = $c -> query($sql_allPs);
        $allies = $s_allPs -> fetchColumn();
        $data [] = array(
            "value" => $allies - $noobies,
            "label" => 'Returning Patrons'
        );
        $c = null;
        return json_encode($data);
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
        if(verifyVolunteer($e) == true) return "alreadyinuse";
        $sql = "INSERT INTO Volunteers VALUES ('".$f."', '".$l."', '".$e."', NOW(), 1, NULL, NULL);";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
        $c = null;
        return "true";
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
        $counter = 0;
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= '<tr>';
                $data .= '<td>'.$r['First_Name'].' '.$r['Last_Name'].'</td>';
                $data .= '<td><input type = "hidden" value = "'.$r['Email'].'" id = "emailid-'.$counter.'">'.$r['Email'].'</td>';
                $data .= '<td>'.$months[intval(substr($r['Start_Date'],5,2)) - 1].' '.substr($r['Start_Date'],8,2).', '.substr($r['Start_Date'],0,4).'</td>';
                $data .= '<td><button class = "btn btn-warning" style = "border-radius: 150px !important;" onclick = "deactivateVolunteer('.$counter.');"><i class="fa fa-power-off" aria-hidden="true"></i></button></td>';
            $data .= '</tr>';
            $counter++;
        }
        $c = null;
        if(strlen($data) < 2) return '<p style = "float: left !important; margin-left: 20% !important;"> No Volunteers Found</p><br><br>';
        else return $table_begin.$data.$table_end;
    }

    function deactivateVolunteer($id) {
        $c = connDB();
        $sql = "UPDATE Volunteers SET Active = 0, Deactivation_Date = NOW() WHERE Email = '".$id."';";
        $c -> prepare($sql) -> execute();
        $sql = "SELECT First_Name, Last_Name FROM Volunteers WHERE Email = '".$id."';";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $name = $r['First_Name']." ".$r['Last_Name'];
        $c = null;
        return $name;
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
        if(strlen($data) < 2) return '<p style = "margin-left: 20% !important;"> No Active Volunteers Found </p><br><br>';
        else return $table_begin.$data.$table_end;
    }

    function volunteerEmailList() {
        $c = connDB();
        $sql = "SELECT Email FROM Volunteers WHERE Active = 1";
        $s = $c -> prepare($sql);
        $s -> execute();
        $data = "";
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= ";".$r['Email'];
        }
        $c = null;
        if(strlen($data) < 2) return "noemails";
        else return substr($data,1,strlen($data));
    }
        
    function verifyVolunteer($email) {
        $c = connDB();
        $sql = "SELECT * FROM Volunteers WHERE Email = '".$email."';";
        $s = $c -> prepare($sql);
        $s -> execute();
        if($s -> fetch(PDO::FETCH_ASSOC)) return true; // which means it is found
        else return false; // not found
    }

    function requestVolunteer($email, $first, $last) {
        if(verifyVolunteer($email)) return "false"; //do not insert
        $c = connDB();
        $sql = "INSERT INTO Volunteers VALUES('".$first."', '".$last."', '".$email."', NULL, 2, NULL, NULL);";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
        $c = null; //close connection
        return "true";
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
                $data .= "<td><input type = 'hidden' id = 'name-for-".$r['Email']."' value = '".$r['First_Name']." ".$r['Last_Name']."'>".$r['First_Name']." ".$r['Last_Name']."</td>";
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
        $sql = "SELECT First_Name, Last_Name FROM Volunteers WHERE Email = '".$email."';";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $name = $r['First_Name']." ".$r['Last_Name'];
        $c = null;
        return $name;
    }

    function removeVolunteer($email) {
        $c = connDB();
        $sql = "DELETE FROM SignUps WHERE Email = '".$email."';";
        $sql .= "DELETE FROM Volunteers WHERE Email = '".$email."';";
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
        $sql = "SELECT idByDate, Active FROM Markets WHERE Active = 0;";
        $s = $c -> prepare($sql);
        $s -> execute();
        while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
            $data .= '<option class = "market-date-option" value = '.$r['idByDate'].'>'.reformatidByDate($r['idByDate']).'</option>';
        }
        $c = null; //close connection
        if(strlen($data) < 2) return '<option selected disabled> Sorry, No Markets detected in the database </option>';
        else return "<option value = 'none' selected disabled hidden>Choose a Market </option>".$data;
    }

    function displaySignupSheets($marketDate) {
        $dataFound = false;
        $colors = ["#343A40", "#DC3545", "#20C997", "#17A2B8", "#FFC107", "#6610F2", "#E83E8C", "#6C757D", "#007BFF"];
        $textcolors = ["White", "Black", "Black", "Black", "Black", "White", "Black", "White", "Black"];
        $c = connDB();
        $sql = "SELECT starttime, closetime FROM Markets WHERE idByDate = ".$marketDate.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $st = $r['starttime'];
        $et = $r['closetime'];
        $data = "<h6><strong><u>Volunteer Schedule</strong></u>  ".substr($st,0,strlen($st)-2).":".substr($st,strlen($st)-2,2)."<i class = 'fa fa-arrow-right' aria-hidden = 'true' style = 'margin-right: 1% !important; margin-left: 1% !important;'></i>".substr($et,0,strlen($et)-2).":".substr($et,strlen($et)-2,2)."</h6><br>";
        $diffHours = intval(substr($et, 0, strlen($et)-2)) - intval(substr($st, 0, strlen($st)-2)) - 1;
        $begDiffMin = 6 - intval(substr($st, strlen($st)-2, 2))/10;
        $finDiffMin = intval(substr($et, strlen($et)-2, 2))/10 + 1;
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
            $afbg = intval(substr($r['Start_Time'], 0, 2)) - intval(substr($st, 0, strlen($st)-2)) - 1;
            $bfbg = 6.000 - number_format(number_format(intval(substr($st, strlen($st)-2, 2)),3,'.','')/10.000,3,'.','');
            $cfbg = number_format(number_format(intval(substr($r['Start_Time'], 3, 2)),3,'.','')/10.000,3,'.','');
            $tensFromBeg = $afbg*6 + $bfbg + $cfbg;
            $marginleft = number_format((number_format($tensFromBeg,3,'.','')/number_format($totalTensMins,3,'.','')), 3, '.', '');
            //calculate margin right by difference
            $marginright = number_format(1-$marginleft-$fraction, 3, '.', '');
            //fontsize based on width:
            if($fraction*100 < 17)  {
                $fontsize = 75;
                $padding = 0.85;
            }
            else {
                $fontsize = 85;
                $padding = 0.55;
            }
            $data .= 
            '<div style = "width: 100% !important; !important;">
                <div style = "width = '.($fraction*100).'% !important; margin-left: '.($marginleft*100).'%!important; background-color: '.$colors[$counter].' !important; margin-right: '.($marginright*100).'% !important; color: '.$textcolors[$counter].' !important; border-radius: 150px !important; height: auto !important; font-weight: bolder !important; font-size: '.$fontsize.'% !important; font-family: Helvetica, Arial, sans-serif !important; padding: '.$padding.'% 0.25% '.$padding.'% 0.25% !important;">';
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
        return "committedsignup";
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
                    <input type = "hidden" id = "starttime-remove-commit" value = "'.substr($r['Start_Time'],0,5).'">
                    <input type = "hidden" id = "endtime-remove-commit" value = "'.substr($r['End_Time'],0,5).'">
                    <button class = "btn remove-signup-commit" id = "remove-signup-commit-btn">
                        <i class = "fa fa-times" aria-hidden = "true"></i>
                    </button>
                </td>
            </tr>';
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
        return "commit-removed";
    }

    function displayNeededTimes($date) {
        $c = connDB(); //set connection
        $sql = "SELECT starttime, closetime FROM Markets WHERE idByDate = ".$date.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $c = null; //close connection
        if(intval($r['starttime']) < 1200) $starttime = substr($r['starttime'],0,strlen($r['starttime'])-2).":".substr($r['starttime'],strlen($r['closetime'])-3,2)." AM";
        else if(intval($r['starttime']) < 1300 && $r['starttime'] > 1159) $starttime = substr($r['starttime'],0,2).":".substr($r['starttime'],2,2)." PM";
        else if (intval($r['starttime']) > 1259 && $r['starttime'] < 2400) $starttime = strval(intval(substr($r['starttime'],0,2))-12).":".substr($r['starttime'],2,2)." PM";

        if(intval($r['closetime']) < 1200) $closetime = substr($r['closetime'],0,strlen($r['closetime'])-2).":".substr($r['closetime'],strlen($r['closetime'])-3,2)." AM";
        else if(intval($r['closetime']) < 1300 && $r['closetime'] > 1159) $closetime = substr($r['closetime'],0,2).":".substr($r['closetime'],2,2)." PM";
        else if (intval($r['closetime']) > 1259 && $r['closetime'] < 2400) $closetime = strval(intval(substr($r['closetime'],0,2))-12).":".substr($r['closetime'],2,2)." PM";

        return 'Volunteers are needed from <strong>'.$starttime.'</strong> until <strong>'.$closetime.'</strong>.';
    }

    function displayNeededTimesInputs($date) {
        $c = connDB(); //set connection
        $sql = "SELECT starttime, closetime FROM Markets WHERE idByDate = ".$date.";";
        $s = $c -> prepare($sql);
        $s -> execute();
        $r = $s -> fetch(PDO::FETCH_ASSOC);
        $c = null; //close connection


        $starttime = substr($r['starttime'],0,strlen($r['starttime'])-2).":".substr($r['starttime'],strlen($r['starttime'])-2,2);
        $closetime = substr($r['closetime'],0,strlen($r['closetime'])-2).":".substr($r['closetime'],strlen($r['closetime'])-2,2);

        if(intval(substr($r['starttime'],strlen($r['starttime'])-2,2)) < 30) $starttime_max = strval(intval(substr($r['closetime'],0,strlen($r['closetime'])-2))-1).":".strval(intval(substr($r['closetime'],strlen($r['closetime'])-2,2)) + 30);
        else $starttime_max = substr($r['closetime'],0,strlen($r['closetime'])-2).":".strval(intval(substr($r['closetime'],strlen($r['closetime'])-2,2)) - 30);

        if(intval(substr($r['closetime'],strlen($r['closetime'])-2,2)) < 30) $closetime_min = substr($r['starttime'],0,strlen($r['starttime'])-2).":".strval(intval(substr($r['starttime'],strlen($r['starttime'])-2,2)) + 30);
        else $closetime_min = strval(intval(substr($r['starttime'],0,strlen($r['starttime'])-2)) + 1).":".strval(intval(substr($r['starttime'],strlen($r['starttime'])-3,2)) - 30);

        return 
        '<input type = "time" class = "index-registration-input half inline" id = "starttime-input" required min = "'.$starttime.'" max = "'.$starttime_max.'">
        <i class = "fa fa-arrow-right inline" aria-hidden = "true" style = "margin-right: 2% !important;"></i>
        <input type = "time" class = "index-registration-input half inline" id = "endtime-input" required min = "'.$closetime_min.'" max = "'.$closetime.'" >
        ';
    }
?>