<?php include "adminFuncs.php"; ?>
<?php
    //password expiration check
    date_default_timezone_set("America/Los_Angeles");
    $today = intval(date("Y").date("m").date("d"));
    $sql = "SELECT changeDate FROM AdminPW WHERE current = 1";
    $c = connDB();
    $s = $c -> prepare($sql);
    $s -> execute();
    $r = $s -> fetch(PDO::FETCH_ASSOC);
    $d = intval(substr($r['changeDate'],0,4).substr($r['changeDate'],5,2).substr($r['changeDate'],8,2));
    if($today < $date && $today > $date - 12) 
    {
        echo '<script>alert("Your password will expire on '.$date.'. Make sure to change it beforehand!");</script>';
    }
    elseif($today > $date) echo '<script> Your password is expired...</script>';
?>
<!DOCTYPE html>
<html>
        <title> Market - Admin </title>

                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css?version=1' rel='stylesheet'></link>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="./otherFiles/bootstrap.min.css">


        <!-- Bootstrap for JQuery -->
        <script src="./otherFiles/jquery.min.js"></script>

        <!-- Bootstrap for JavaScript -->
        <script src="./otherFiles/bootstrap.min.js"></script>

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="captsone.js"></script>

        <!-- MORRIS.JS (for graphing utilities from PHP data) LINKS -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    </head>

    <body class = "bodyRed">
        <div class = "header">
            <button id = "goToMarket" class = "btn btn-primary sideBtn pull-left" onclick = "location.replace('index.php')"> Market </button>
            <button id = "changePW" class = "btn btn-primary sideBtn pull-left" data-toggle = "collapse" data-target = "#changePWDiv" aria-expanded="false"> Change Password </button>
                <h1 class = "pull-left headerTitle"><strong> The Market  -  LPCSG </strong></h1>
                <img src = "otherFiles/pics/lpcLogo.png" class = "lpcLogo pull-right inline"> &nbsp; &nbsp;
                <img src = "otherFiles/pics/lpcsgLogo.jpg" class = "lpcsgLogo pull-right inline">
        </div>
        <div id = "changePWDiv" class = "collapse">
            <form method = "post" action = "adminFuncs.php">
                <h4> Change you Password </h4>
                <input type = "password" placeholder = "Old Password" class = "btn" name = "oldPW"> &nbsp; &nbsp;
                <input type = "password" placeholder = "New Password" class = "btn" name = "newPW1"> &nbsp; &nbsp;
                <input type = "password" placeholder = "Verify New Password" class = "btn" name = "newPW2"> <br><br> 
                <input type = "hidden" value = "changePW" name = "message"> <!-- USE THIS TO SEND THE MESSAGE TO THE PHP PAGE -->
                <button class = "btn btn-success" id = "submit">  Change Password </button>
            </form>
        </div>
        <div class = "upper_portion_admin">
            <h1> Admin and Management Page</h1> <br>
            <!-- Page Instructions: -->
            <h3 class = "pull-left instructions"> <u> Instructions </u> </h3> <br>
            <ul class = "pull-left instructions">
                <li class = "pull-left"> 1.  To Create a new Market: Click the First Button </li><br>
                <li class = "pull-left"> 2.  To Choose a Market Action: Click the Second Button </li><br>
                <li class = "pull-left"> 3.  Choose From the Shown Options </li><br>
                <li class = "pull-left"> 4.  Click the submit button! </li>
            </ul>
        </div>
        <br>
        <div class = "lower_portion">
            <!-- Create New Market: -->
            <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#new_market" aria-expanded="false"> Create New Market </button>
            <div id = "new_market" class = "collapse">
                <form method = "post" action = "adminFuncs.php">
                    <h3> Choose A Date </h3>
                    <input type = "date" placeholder = "Choose a Month" class  = "btn" name = "new_market_date">
                    <input type="hidden" value = "submitNewMarket" name = "message">
                    <button class = "btn btn-success"> Submit </button>

                </form>
            </div>
            <br> <br> 
                <!-- Choose a market and action: -->
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
                    </div> 
                    <br><br>
                    <!-- Market Actions: -->
                    <p class = "inline"> 
                    <label class = "pull-left radioBtn ">
                        <input class = "inline" id = "invokeRadio" name="adminOption" value = "invoke" type="radio" checked />
                        &nbsp;<span class = "inline"> Activate</span>
                    </label>
                    </p>
                    <p class = "inline">
                    <label class = "pull-left radioBtn">
                        <input class = "inline" id = "reportRadio" name="adminOption" value = "terminate" type="radio" />
                        &nbsp;<span class = "inline"> Terminate</span>
                    </label>    
                    </p>
                    <p class = "inline">
                    <label class = "pull-left radioBtn">
                        <input class = "inline" id = "reportRadio" name="adminOption" value = "report" type="radio" />
                        &nbsp;<span class = "inline"> Report</span>
                    </label>
                    </p>
                    <p class = "inline">
                    <label class = "pull-left radioBtn">
                        <input class = "inline" id = "reportRadio" name="adminOption" value = "inventory" type="radio" />
                        &nbsp;<span class = "inline"> Inventory</span>
                    </label>
                    </p>
                    <p class = "inline">
                    <label class = "pull-left radioBtn"> 
                        <input class = "inline" id = "reportRadio" name="adminOption" value = "deleteMarket" type="radio" />
                        &nbsp;<span class = "inline"> Delete</span>
                    </label>
                    </p>
                    <br><br>
                    <input id = "hiddenMessage" type="hidden" value = "adminOption" name = "message">
                    <button class = "btn btn-success" id = "submit"> SUBMIT </button>
                </form>                     
            </div>
           
        </div>
        
    </body>
    <footer class = "footer">
        <h5> Powered by Shahaf Dan - Capstone Project </h5>
        <br>
        <p>Las Positas College | May 2020</p>
    </footer>



</html>
