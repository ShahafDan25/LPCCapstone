<?php
    include "funcs.php";
    $conn = connDB(); 
?>
<!DOCTYPE html>
<html>
        <title> Market - Report </title>
        <link rel="icon" href="otherFiles/pics/lpcLogo2.png"/>

        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css?version=1' rel='stylesheet'></link>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      

        <!-- Bootstrap for JQuery, AJAX, JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="captsone.js"></script>

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
    <body class = "report-page-body">
        <header class = "nav-bar">
            <a href = "admin.php" class = "nav-bar-option responsive">Admin</a>
            <a href = "index.php" class = "nav-bar-option responsive">Market</a>
            <a href = "inventory.php" class = "nav-bar-option responsive">Inventory</a>
            <a href = "volunteers.php" class = "nav-bar-option responsive">Volunteers</a>
            <h5 class = "nav-bar-title responsive"> The Market - Report </h5>
        </header>
        <div class = "page-container">
            <form action = "funcs.php" method = "post">
                <input type = "hidden" value = "pdfreport" name = "message">
                <button  class = "inline btn btn-success sideBtn pull-right"> Generate Report [ PDF ] </button>
            </form>
            <h2> MARKET REPORT </h2>
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
        

            <br>
            
                        <!-- Table: Patrons in that specific market -->
            <div class = "report_box_class" id = "repot_box_id">
                <table class = "table">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col"> Name</th>
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
                            $sql_a = "SELECT Patrons_patID FROM MarketLogins WHERE Markets_idByDate = (SELECT idByDate FROM Markets WHERE reported = 1) ORDER BY time_stamp;";
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

                                    // if($row_b['firstMarket'] == $d) {$addline .= "<th><div style = 'border-radius: 150px; border: 1px solid orange; padding-left: 3% !important;'>".$row_b['FirstName']."  ".$row_b['LastName']."</div></th>";}
                                    // else{$addline .= "<th>".$row_b['FirstName']."  ".$row_b['LastName']."</th>";}

                                    if($row_b['firstMarket'] == $d) {$addline .= "<th>".$row_b['FirstName']."  ".$row_b['LastName']."</th>";}
                                    else{$addline .= "<td>".$row_b['FirstName']."  ".$row_b['LastName']."</td>";}
                                    //^^ if they are a returning member, then their name will be in bold text
                                    
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
                
                <!-- Statistics: bottom of graph -->
                <p> 
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
                            * Average is per attendee

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
        </div>
    </body>
    <footer class = "footer">
        <h5> Powered by Shahaf Dan - Capstone Project </h5>
        <br>
        <p>Las Positas College | May 2020</p>
    </footer>
    <!-- ------------------------ SCRIPT GRAPHS ------------------------------>
    <script>
        //attendance graph (linear) 
        Morris.Line({
            element : 'chart', 
            data:[<?php echo $attGraphData; ?>], 
            xkey:'TIME',
            ykeys:['AMOUNT'],
            labels:['Attendance'],
            hideHover:'auto',
            stacked:true
        });

        //promotion method comparison graph (bars)
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

        //return vs new patrons graph (donuts (pi chart))
        Morris.Donut({
            element: 'retvsnew',
            data: [<?php echo $retvsnew; ?>],
            colors:['#994d00','#ffa64d']
        })
    </script>
</html>