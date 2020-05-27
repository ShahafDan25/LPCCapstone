<?php include "connDB.php"; ?>
<?php include "fotherFiles/pdf_lib/fpdf.php"; ?> 
<?php

    $c = connDB();
    $d = 20200416;
    
    function generate_report($c, $d)
    {
        $pdf = new FPDF(); //generate a new pdf
        $pdf -> AddPage(); //add page
        $pdf ->SetFont('Arial', 'B', 16); //Font: arial. Bolden. size 16
        $pdf->Cell(40,10,'Hello World!');
        $pdf->Output("rt.pdf");
        

        //Will use FPDF to generate a PDF report (later use angular.sj is possible)


    }

    generate_report($c, $d);
?>