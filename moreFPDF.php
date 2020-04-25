<?php //include "fpdf_lib/fpdf.php"; ?> 
<?php include "connDB.php"; ?>

<?php
require "fpdf_lib/fpdf.php";
    class myFPDFClass extends FPDF
    {
        public $totalAdults = 0;
        public $totalKids = 0;
        public $totalPeople = 0;
        public $totalSeniors = 0;
        function tableHead() //used to set the header of our table in the pdf report
        {
            $this -> SetFont('Arial', 'B', 14); 
            $this -> Cell(60, 10, 'Name', 1, 0, 'C'); //'C' feature will centrize th text within the cell
            $this -> Cell(25, 10, 'Student ?', 1, 0, 'C');
            $this -> Cell(90, 10, 'People in Household', 1, 0, 'C');
            $this -> Ln(); // move to the next line in the table
            $this -> SetFont('Arial', 'B', 12); 
            $this -> Cell(60, 8, '   -   ', 1, 0, 'C');
            $this -> Cell(25, 8, '   -   ', 1, 0, 'C');
            $this -> Cell(30, 8, 'Kids', 1, 0, 'C');
            $this -> Cell(30, 8, 'Adults', 1, 0, 'C');
            $this -> Cell(30, 8, 'Seniors', 1, 0, 'C');
            $this -> Ln(); //now to the body of the table
            return;
        }

        function tableBody($c)
        {
            $this -> SetFont('Arial', 'B', 10); 
            $sql_a = "SELECT Patrons_patID FROM MarketLogins WHERE Markets_idByDate = (SELECT idByDate FROM Markets WHERE reported = 1)";
            $s_a = $c -> prepare($sql_a); //create the statment
            $s_a -> execute(); //execute the statement
            $totalPeople = 0;
            $totalKids = 0;
            $totalAdults = 0;
            $totalSeniors = 0;
            while($r_a = $s_a -> fetch(PDO::FETCH_ASSOC))
            { //new format: mm / dd / yyyy
                $sql_b = "SELECT FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount FROM Patrons WHERE patID = ".$r_a['Patrons_patID'];
                $s_b = $c -> prepare($sql_b);
                $s_b -> execute();
                while($r_b = $s_b -> fetch(PDO::FETCH_ASSOC)) //nested while loop for SQL query by Date
                {
                    $this -> Cell(60, 7, $r_b['FirstName']."  ".$r_b['LastName'], 1, 0, 'C');
                    
                    if($r_b['StudentStatus'] == 1) $this -> Cell(25, 7, "  YES   ", 1, 0, 'C');
                    else $this -> Cell(25, 7, " ", 1, 0, 'C');                    
                    
                    $this -> Cell(30, 7, $r_b['ChildrenAmount'], 1, 0, 'C');
                    $this -> Cell(30, 7, $r_b['AdultsAmount'], 1, 0, 'C');
                    $this -> Cell(30, 7, $r_b['SeniorsAmount'], 1, 0, 'C');
                    $this -> Ln(); //endl

                    $totalPeople++;
                    $totalKids += $r_b['ChildrenAmount'];
                    $totalAdults += $r_b['AdultsAmount'];
                    $totalSeniors += $r_b['SeniorsAmount'];
                    
                }
            }   
            // also pront the average statistics
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
            return;      
        }
        function pasteAttendanceGraph()
        {
            
            return;
        }
    }
?>