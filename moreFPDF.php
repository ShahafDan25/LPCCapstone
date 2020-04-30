<?php include "connDB.php"; ?>

<?php
require "otherFiles/fpdf_lib/fpdf.php";
    class myFPDFClass extends FPDF //extend all the features from the FPDF class, but more functions
    {
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
            return;      
        }
    }
?>