<?php
    include "adminFuncs.php";
    $conn = connDB(); 
?>
<html !DOCTYPE>
    <head>
        <title> Market - Report </title>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="./The Market_files/bootstrap.min.css">
        
        <!-- CSS HARDCODE FILE LINK -->
        <link rel="stylesheet" type="text/css" href="capstone.css">

        <!-- Bootstrap for JQuery -->
        <script src="./The Market_files/jquery.min.js"></script>

        <!-- Bootstrap for JavaScript -->
        <script src="./The Market_files/bootstrap.min.js"></script>

        <!-- Bootstrap for CSS Icon -->
        <script src="./The Market_files/a076d05399.js"></script><link rel="stylesheet" href="./The Market_files/free.min.css" media="all">

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="./The Market_files/captsone.js"></script>

        <!-- MORRIS.JS (for graphing utilities from PHP data) LINKS -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
 

        <style>
            .inline{display: inline-block !important;}
            .w25{width: 30% !important;}
            .w55{width: 60% !important;}
        </style>
    </head>

    <!-- ---------------------------------------------------------------- -->
    <body class = "body_report">
        <button id = "goToAdmin" class = "inline btn btn-primary admin pull-left" onclick = "location.replace('admin.php')"> Admin Page </button>
        <button id = "goToMarket" class = "inline btn btn-primary admin pull-left" onclick = "location.replace('index.php')"> The Market </button>
        <form action = "adminFuncs.php" method = "post">
            <input type = "hidden" value = "pdfreport" name = "message">

            <button  class = "inline btn btn-success admin pull-right"> Generate Report </button>
        </form>
        <h1> MARKET REPORT </h1>
        <h4>
        <?php

            $sql = "SELECT idByDate FROM Markets WHERE reported = 1"; 
            $stmt = $conn -> prepare($sql); 
            $stmt -> execute(); 
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            echo substr($row['idByDate'], 4, 2)." - ".substr($row['idByDate'], 6, 2)." - ".substr($row['idByDate'], 0, 4);
            $d = $row['idByDate'];
            $promGraphData = promGraphData(connDB(), $d);
            $attGraphData = getAttData(connDB(), $d);
            $retvsnew = getRetVSNew(connDB(), $d);
        ?>
        </h4>
    

        <br><br>
        
        <div class = "report_box_class" id = "repot_box_id">
            <table class = "table">
                <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">First Name</th>
                      <th scope="col">Last Name</th>
                      <th scope="col">Student?</th>
                      <th scope="col"># Kids</th>
                      <th scope="col"># Adults</th>
                      <th scope="col"># Seniors</th>
                      <th scope="col">Email</th>
                      <th scope="col">Phone #</th>
                      <th scope="col">Promotion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $addline = ""; 
                        $sql_a = "SELECT Patrons_patID FROM MarketLogins WHERE Markets_idByDate = (SELECT idByDate FROM Markets WHERE reported = 1)";
                        $stmt_a = $conn -> prepare($sql_a);
                        $stmt_a -> execute(); 
                        $totalPeople = 0;
                        $totalKids = 0;
                        $totalAdults = 0;
                        $totalSeniors = 0;
                        while($row_a = $stmt_a -> fetch(PDO::FETCH_ASSOC))
                        { 
                            $sql_b = "SELECT * FROM Patrons WHERE patID = ".$row_a['Patrons_patID'];
                            $stmt_b = $conn -> prepare($sql_b);
                            $stmt_b -> execute();
                            while($row_b = $stmt_b -> fetch(PDO::FETCH_ASSOC)) 
                            {
                                $addline = "<tr><td scope='row'>";
                                $totalPeople++;
                                $totalKids += $row_b['ChildrenAmount'];
                                $totalAdults += $row_b['AdultsAmount'];
                                $totalSeniors += $row_b['SeniorsAmount'];
                                $addline .= $row_b['patID']."</td>";
                                $addline .= "<th>".$row_b['FirstName']."</th>";
                                $addline .= "<th>".$row_b['LastName']."</th>";

                                if($row_b['StudentStatus'] == 1) $addline .= "<td><div style = 'background-color:  #99ffcc; padding-right: 5% !important; text-align: center; border-radius: 150px'>  ✓  </div></td>";
                                else $addline .= "<td>    </td>";


                                $addline .= "<td>".$row_b['ChildrenAmount']."</td>";
                                $addline .= "<td>".$row_b['AdultsAmount']."</td>";
                                $addline .= "<td>".$row_b['SeniorsAmount']."</td>";
                                $addline .= "<td>".$row_b['EmailAdd']."</td>";
                                $addline .= "<td>".$row_b['PhoneNumber']."</td>";
                                $addline .= "<td>".$row_b['PromotionMethod']."</td></tr>";
                                echo $addline;
                            }
                        }                        
                    ?>
                </tbody>
            </table>
            
            <p class = "totalInfo"> 
                        <strong><u> Total Attendees</u></strong>: 
                        <?php echo $totalPeople; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;  
                        <strong><u> Total Children (0 - 17)</u></strong>: 
                        <?php echo $totalKids; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <strong><u> Total Adults (18 - 64)</u></strong>: 
                        <?php echo $totalAdults; ?>
                        &nbsp; &nbsp;&nbsp;&nbsp;
                        <strong><u> Total Sernios (65 +)</u></strong>: 
                        <?php echo $totalSeniors; ?>
                        <br>
                        <strong><u> Average Children (0 - 17)</u></strong>: 
                        <?php echo round($totalKids/$totalPeople, 2); ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong><u>  Average Adults (18 - 64)</u></strong>: 
                        <?php echo round($totalAdults/$totalPeople, 2); ?>
                        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong><u>  Average Sernios (65 +)</u></strong>: 
                        <?php echo round($totalSeniors/$totalPeople, 2); ?>
                        <br>
                        * Avergae is per attendee

            </p>
            <br>
           
            
        </div>
        <br><br>
        <h3> Attendance Graph </h3>
        <div class = "report_box_class">
            <div id = "chart"></div>
        </div>
        <br><br>
        <span>
            <div class = "inline w55">
                <h3> Advertisement and Promotions </h3>
                <div class = "report_box_class">
                    <div id = "promGraph"></div>
                </div>
            </div>
            
            <div class = "inline w25">
                <h3> New VS. Returning Patrons </h3>
                <div class = "report_box_class">
                    <div id = "retvsnew"></div>
                </div>
            </div>
        </span>
        <br><br>
        <br><br>
    </body>

    <!-- ---------------------------------------------------------------- -->
    <script>
        Morris.Line({
            element : 'chart', 
            data:[<?php echo $attGraphData; ?>], ]
            xkey:'TIME',
            ykeys:['AMOUNT'],
            labels:['Attendance'],
            hideHover:'auto',
            stacked:true
        });

        Morris.Bar({
            element: 'promGraph', 
            data:[<?php echo $promGraphData;?>], 
            xkey:'METHOD',
            ykeys:['AMOUNT'],
            labels:['Impact'],
            hideHover:'auto',
            stacked:true,
            barColors: ['#4DA74D'],
            barSizeRatio:0.40,
            resize:false
        });

        Morris.Donut({
            element: 'retvsnew',
            data: [<?php echo $retvsnew; ?>],
            colors:['#994d00','#ffa64d']
        })
    </script>
</html>