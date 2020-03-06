<!--
<?php
    include "index.php"; ///access for everything in the index.php
    include "capstone.php"; //access to everuthing in the capstone.php file
    $conn = connDB(); //function from capstone.php
?>
-->



<html !DOCTYPE="">
    <head>
        <title> The Market </title>

        <link rel="shortcut icon" href="./The Market_files/lpcsgLogo.jpg">

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="./The Market_files/bootstrap.min.css">
        
        <!-- CSS HARDCODE FILE LINK -->
        <link rel="stylesheet" type="text/css" href="./The Market_files/capstone.css">

        <!-- Bootstrap for JQuery -->
        <script src="./The Market_files/jquery.min.js"></script>

        <!-- Bootstrap for JavaScript -->
        <script src="./The Market_files/bootstrap.min.js"></script>

        <!-- Bootstrap for CSS Icon -->
        <script src="./The Market_files/a076d05399.js"></script><link rel="stylesheet" href="./The Market_files/free.min.css" media="all">

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="./The Market_files/captsone.js"></script>
    </head>

    <body class = "body">
        <div class = "upper_portion">
            <h1> Admin and Management Page</h1>

        </div>
        <br>
        <div class = "lower_portion">
            <!-- COLLAPSE FOR NEW MARKET -->
            <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#new_market" aria-expanded="false"> Create New Market </button>
            <div id = "new_market" class = "collapse">
                <form method = "post" action = "capstone.php">
                    <h3> Choose A Date </h3>
                    <input type = "date" placeholder = "Choose a Month" class  = "btn" name = "new_market_date">
                    <button class = "btn btn-success"> Submit </button>

                </form>
            </div>
            <br> <br> <br> <!-- SOME SPACING THAT MIGHT BE NEEDED-->
            <!-- COLLAPSE FOR REPOTR GENERATION -->
            <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#generate_report" aria-expanded="false"> Generate A Report </button>
            <div id = "generate_repot" class = "collapse">
                <h3> Choose A Market </h3>
                <!-- ADD PHP CODE -->
            </div>
        </div>
        
    </body>




</html>
