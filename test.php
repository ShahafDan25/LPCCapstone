<?php include "connDB.php"; ?>
<?php include "otherFiles/fpdf_lib/fpdf.php"; ?> 
<?php

    $c = connDB();
    $d = 20200714;
    
    $colors = ["#343A40", "#DC3545", "#20C997", "#17A2B8", "#FFC107", "#6610F2", "#E83E8C", "#6C757D", "#007BFF"];
    $c = connDB();
    $data = "";
    $sql = "SELECT starttime, closetime FROM Markets WHERE idByDate = '".$d."';";
    $s = $c -> prepare($sql);
    $s -> execute();
    $r = $s -> fetch(PDO::FETCH_ASSOC);
    $st = $r['starttime'];
    $et = $r['closetime'];
    $diffHours = intval(substr($et, 0, 2)) - intval(substr($st, 0, 2)) - 1;
    $begDiffMin = 6 - intval(substr($st, 2, 2))/10;
    $finDiffMin = intval(substr($et, 2, 2))/10 + 1;
    $totalTensMins = $diffHours*6 + $begDiffMin + $finDiffMin;
    $sql = "SELECT v.First_Name, v.Last_Name, v.Profile_Picture, su.Start_Time, su.End_Time FROM Volunteers v JOIN SignUps su ON su.Email = v.Email WHERE su.Market = '".$d."' ORDER BY su.Start_Time;";
    $s = $c -> prepare($sql);
    $s -> execute();
    $counter = -1;
    while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
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
        $data .= 
        '<div style = "width: 100% !important; border-bottom: 0.3px solid black !important;">
            <div style = "height: 10% !important; width = '.($fraction*100).'% !important; margin-left: '.($marginleft*100).'%!important; background-color: '.$colors[$counter].' !important;">'
                .$personName.
            '</div>
        </div>
        <br>
        ';
    }
    $c = null; //close connection
    echo $data;
?>