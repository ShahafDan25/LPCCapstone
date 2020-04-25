<?php include "adminFuncs.php"; ?>
<?php
    date_default_timezone_set("America/Los_Angeles");
    $today = intval(date("Y").date("m").date("d"));
    $sql = "SELECT changeDate FROM AdminPW WHERE current = 1";
    $c = connDB();
    $s = $c -> prepare($sql);
    $s -> execute();
    $r = $s -> fetch(PDO::FETCH__ASSOC);
    $d = intval(substr($r['changeDate'],0,4).substr($r['changeDate'],5,2).substr($r['changeDate'],8,2));
    if($today < $date && $today > $date - 12) //12 days before password will expire
    {
        echo '<script>alert("Your password will expire on '.$date.'. Make sure to change it beforehand!");</script>';
    }
    elseif($today > $date) echo '<script> Your password is expired...</script>';
?>
<html !DOCTYPE>
    <head>
        <title> Market - Admin </title>

        <link rel="shortcut icon" href="./The Market_files/lpcsgLogo.jpg">

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

    <body class = "body">
        <div class = "upper_portion_admin">
            <h1> Admin and Management Page</h1> <br>
            <div>
                <button id = "goToMarket" class = "btn btn-primary admin" onclick = location.replace('index.php')> Market </button>
                &nbsp; &nbsp;
                <button id = "changePW" class = "btn btn-primary admin" data-toggle = "collapse" data-target = "#changePWDiv" aria-expanded="false"> Change Password </button>
                <div id = "changePWDiv" class = "changePW collapse">
                    <form method = "post" action = "adminFuncs.php">
                        <h4> Change you Password </h4>
                        <input type = "password" placeholder = "Old Password" class = "btn" name = "oldPW"> &nbsp; &nbsp;
                        <input type = "password" placeholder = "New Password" class = "btn" name = "newPW1"> &nbsp; &nbsp;
                        <input type = "password" placeholder = "Verify New Password" class = "btn" name = "newPW2"> <br><br> 
                        <input type = "hidden" value = "changePW" name = "message"> <!-- USE THIS TO SEND THE MESSAGE TO THE PHP PAGE -->
                        <button class = "btn btn-success" id = "submit">  Change Password </button>
                    </form>
                </div>

            </div><br>
            <h3> <u> Instructions </u> </h3>
            <ul class = "pull-left instructions">
                <li class = "pull-left"> 1.  Create a new market by choosing a date </li><br>
                <li class = "pull-left"> 2.  Choose a Market by Clicking the Second Button </li><br>
                <li class = "pull-left"> 3.  Choose either to invoke a market, or to generate a report, or terminate a market </li><br>
                <li class = "pull-left"> 4.  Note: In order to generate a report of a market, it must be active! </li><br>
                <li class = "pull-left"> 5.  Click the submit button! </li>
            </ul>
        </div>
        <br><br><br><br><br> <br> 
        <!-- SAFETY SPACING I GUESS YOU COULD CALL THIS -->
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
            <br> <br> <!-- SOME SPACING THAT MIGHT BE NEEDED-->
            <!-- COLLAPSE FOR REPOTR GENERATION -->
            
                <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#generate_report" aria-expanded="false" id = "submit"> Choose a Market </button>
                <div id = "generate_report" class = "collapse">
                <form method = "post" action = "adminFuncs.php">
                    <h3> Choose a Market</h3>
                    <div class="dropdown">
                        <select class="btn midbigger browser-default custom-select"  name = "marketDate">
                            <option> Choose a market (by date) </option>
                          <?php
                                echo populate_market_dropdown(connDB());
                          ?>
                        </select>
                    </div> <!-- END OF DROPDOWN -->
                    <br><br>
                    <p class = "inline"> <!-- RADIO BUTTONS -->
                    <label class = "pull-left radioBtn ">
                        <input class = "inline" id = "invokeRadio" name="invokeOrReport" value = "invoke" type="radio" checked />
                        &nbsp;<span class = "inline"> Activate</span>
                    </label>
                    </p>
                    <p class = "inline">
                    <label class = "pull-left radioBtn">
                        <input class = "inline" id = "reportRadio" name="invokeOrReport" value = "terminate" type="radio" />
                        &nbsp;<span class = "inline"> Terminate</span>
                    </label>    
                    </p>
                    <p class = "inline">
                    <label class = "pull-left radioBtn">
                        <input class = "inline" id = "reportRadio" name="invokeOrReport" value = "report" type="radio" />
                        &nbsp;<span class = "inline"> Report</span>
                    </label>
                    </p>
                   
                    <p class = "inline">
                    <label class = "pull-left radioBtn">
                        <input class = "inline" id = "reportRadio" name="invokeOrReport" value = "inventory" type="radio" />
                        &nbsp;<span class = "inline"> Inventory</span>
                    </label>
                    </p>
                    <p class = "inline">
                    <label class = "pull-left radioBtn"> <!-- LATER CHANGE THE NAME FROM invokeOrReport TO something more realizable -->
                        <input class = "inline" id = "reportRadio" name="invokeOrReport" value = "deleteMarket" type="radio" />
                        &nbsp;<span class = "inline"> Delete</span>
                    </label>
                    </p>
                    <!-- <p class = "inline tinyText">
                        WARNING: Deleting a market will also delete any record of the people for whom it was the first market!
                    </p> -->
                    <br><br>
                    <!-- END OF RADIO BUTTONS -->
                    <input id = "hiddenMessage" type="hidden" value = "invokeOrReport" name = "message">
                    <button class = "btn btn-success" id = "submit"> SUBMIT </button>
                </form>                     
                <!-- ADD PHP CODE -->
                </div>
           
        </div>
        
    </body>




</html>
