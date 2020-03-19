<?php
    include "adminFuncs.php";
    $conn = connDB();
?>
<html !DOCTYPE>
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
        <div class = "upper_portion_admin">
            <h1> Admin and Management Page</h1>
            <h3> <u> Instructions </u> </h3>
            <ul>
                <li> 1.  Create a new market by choosing a date </li>
                <li> 2.  Choose a Market by Clicking the Second Button </li>
                <li> 3.  To generate a report, click "report" after selecting a Market's date" </li>
                <li> 4.  To invoke a market's registration page, click "invoke" after selecting a Market's date </li>
            </ul>
        </div>
        <br><br>
        <div class = "lower_portion">
            <!-- COLLAPSE FOR NEW MARKET -->
            <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#new_market" aria-expanded="false"> Create New Market </button>
            <div id = "new_market" class = "collapse">
                <form method = "post" action = "adminFuncs.php">
                    <h3> Choose A Date </h3>
                    <input type = "date" placeholder = "Choose a Month" class  = "btn" name = "new_market_date">
                    <input type="hidden" value = "submitNewMarket" name = "message">
                    <button class = "btn btn-success"> Submit </button>

                </form>
            </div>
            <br> <br> <br> <!-- SOME SPACING THAT MIGHT BE NEEDED-->
            <!-- COLLAPSE FOR REPOTR GENERATION -->
            
                <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#generate_report" aria-expanded="false" id = "submit"> Choose a Market </button>
                <div id = "generate_report" class = "collapse">
                    <h3> Choose a Market</h3>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Market By Date &nbsp;
                            <i class="fa fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu midbigger" aria-labelledby="dropdownMenuButton">
                          <?php
                                echo populate_market_dropdown($conn); //pass the connection
                          ?>
                        </div>
                    </div> <!-- END OF DROPDOWN -->
                    <br><br><br>
                    <button class = "btn btn-success"> REPORT </button> &nbsp;
                    <button class = "btn btn-success"> INVOKE </button>

                <!-- ADD PHP CODE -->
                </div>
           
        </div>
        
    </body>




</html>
