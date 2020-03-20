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
    </head>

    <!-- ---------------------------------------------------------------- -->
    <body class = "body">
        <h1> MARKET REPORT </h1> <!-- PHP: ADD DATE LATER -->
        <h4>
        <?php
            $sql = "SELECT idByDate FROM Markets WHERE active = 1"; //add the date pf the marlet of which we generate the report
            $stmt = $conn -> prepare($sql); //create the statment
            $stmt -> execute(); //execute the statement
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            echo substr($row['idByDate'], 4, 2)." - ".substr($row['idByDate'], 6, 2)." - ".substr($row['idByDate'], 0, 4);
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
                        $sql_a = "SELECT Patrons_patID FROM Markets_has_Patrons WHERE Markets_idByDate = (SELECT idByDate FROM Markets WHERE active = 1)";
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
                                $totalAdultls += $row_b['AdultsAmount'];
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
        </div>
    </body>

    <!-- ---------------------------------------------------------------- -->
    <script>
        //add some javascript code here later (for angular JS specifically)
    </script>
</html>