<?php
    include "adminFuncs.php";
    $conn = connDB(); //first and foremost, establish a database connection
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
 
    </head>

    <!-- ---------------------------------------------------------------- -->
    <body class = "body_report">
    <button id = "goToMarket" class = "btn btn-primary admin pull-left" onclick = location.replace('admin.php')> Admin Page </button>
        <h1> MARKET REPORT </h1> <!-- PHP: ADD DATE LATER -->
        <h4>
        <?php
            $sql = "SELECT idByDate FROM Markets WHERE reported = 1"; //add the date pf the marlet of which we generate the report
            $stmt = $conn -> prepare($sql); //create the statment
            $stmt -> execute(); //execute the statement
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            echo substr($row['idByDate'], 4, 2)." - ".substr($row['idByDate'], 6, 2)." - ".substr($row['idByDate'], 0, 4);
            $data_temp = getAttData(connDB(), $row['idByDate']);

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
                        $addline = ""; //just kinda declare the variable (idk if its necessary in php but bbsts)
                        //we already berify in previous pages that there exists a market that is
                        $sql_a = "SELECT Patrons_patID FROM MarketLogins WHERE Markets_idByDate = (SELECT idByDate FROM Markets WHERE reported = 1)";
                        $stmt_a = $conn -> prepare($sql_a); //create the statment
                        $stmt_a -> execute(); //execute the statement
                        $totalPeople = 0;
                        $totalKids = 0;
                        $totalAdults = 0;
                        $totalSeniors = 0;
                        while($row_a = $stmt_a -> fetch(PDO::FETCH_ASSOC))
                        { //new format: mm / dd / yyyy
                            $sql_b = "SELECT * FROM Patrons WHERE patID = ".$row_a['Patrons_patID'];
                            $stmt_b = $conn -> prepare($sql_b);
                            $stmt_b -> execute();
                            while($row_b = $stmt_b -> fetch(PDO::FETCH_ASSOC)) //nested while loop for SQL query by Date
                            {
                                $addline = "<tr><td scope='row'>";
                                $totalPeople++;
                                $totalKids += $row_b['ChildrenAmount'];
                                $totalAdults += $row_b['AdultsAmount'];
                                $totalSeniors += $row_b['SeniorsAmount'];
                                $addline .= $row_b['patID']."</td>";
                                $addline .= "<th>".$row_b['FirstName']."</th>";
                                $addline .= "<th>".$row_b['LastName']."</th>";
                                $addline .= "<td>".$row_b['StudentStatus']."</td>";
                                $addline .= "<td>".$row_b['ChildrenAmount']."</td>";
                                $addline .= "<td>".$row_b['AdultsAmount']."</td>";
                                $addline .= "<td>".$row_b['SeniorsAmount']."</td>";
                                $addline .= "<td>".$row_b['EmailAdd']."</td>";
                                $addline .= "<td>".$row_b['PhoneNumber']."</td>";
                                $addline .= "<td>".$row_b['PromotionMethod']."</td></tr>";
                                //after building the string, echo and reset when the loop start again
                                echo $addline;
                            }
                        }                        
                    ?>
                </tbody>
            </table>
            <br><br>
            <p class = "totalInfo"> 
                        <strong><u> Total Attendees</u></strong>: 
                        <?php echo $totalPeople ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;  <!--some formatting -->
                        <strong><u> Total Children (0 - 17)</u></strong>: 
                        <?php echo $totalKids ?>
                        <br>
                        <strong><u> Total Adults (18 - 64)</u></strong>: 
                        <?php echo $totalAdults ?>
                        &nbsp; &nbsp;&nbsp;&nbsp;
                        <strong><u> Total Sernios (65 +)</u></strong>: 
                        <?php echo $totalSeniors ?>
                        <br>
            </p>
            <br>
           
            
        </div>
         <!-- GRAPH WILL BE INSERTED HERE --><br><br>
         <h3> Attendance Graph </h3>
         <div class = "report_box_class">
         <div id = "chart"></div>
        </div>
        
        <br><br>
    </body>

    <!-- ---------------------------------------------------------------- -->
    <script>
        //add morris.js code right here to populate the graph inside the "att_graph" html div block
        Morris.Bar({
            element : 'chart', //referring to the graph's html div block
            data:[<?php echo $data_temp;?>], //get the variable from the adminFuncs.php file (already included)
            xkey:'TIME',
            ykeys:['AMOUNT'],
            labels:['Attendance'],
            hideHover:'auto',
            stacked:true
        });
    </script>
</html>