<?php include "funcs.php"; ?>
<?php
    //password expiration check
    // date_default_timezone_set("America/Los_Angeles");
    // $today = intval(date("Y").date("m").date("d"));
    // $sql = "SELECT changeDate FROM AdminPW WHERE current = 1";
    // $c = connDB();
    // $s = $c -> prepare($sql);
    // $s -> execute();
    // $r = $s -> fetch(PDO::FETCH_ASSOC);
    // $d = intval(substr($r['changeDate'],0,4).substr($r['changeDate'],5,2).substr($r['changeDate'],8,2));
    // if($today < $date && $today > $date - 12) 
    // {
    //     echo '<script>alert("Your password will expire on '.$date.'. Make sure to change it beforehand!");</script>';
    // }
    // elseif($today > $date) echo '<script> Your password is expired...</script>';
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Admin - LPC Market </title>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css?version=1' rel='stylesheet'></link>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      

        <!-- Bootstrap for JQuery, AJAX, JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>


        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="captsone.js"></script>

        <!-- FONTAWESOME ICON --> 
        <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
        <script src = "https://use.fontawesome.com/9f04ec4af7.js"></script>
    </head>
    
    <body class = "admin-page-body">
    <!-- -------------- NAVIGATION BAR ------------>
        <header class = "nav-bar">
            <a href = "index.php" class = "nav-bar-option responsive">Market</a>
            <a href = "volunteers.php" class = "nav-bar-option responsive">Volunteers</a>
            <a href = "report.php" class = "nav-bar-option responsive">Report</a>
            <a href = "inventory.php" class = "nav-bar-option responsive">Inventory</a>
            <h5 class = "nav-bar-title responsive"> The Market - Admin </h5>
        </header>
        <div class = "page-container">
            <div class = "sidebar">
                <a class = "active" href = "#new-market"> New Market </a>
                <a class = "active" href = "#market-actions"> Market Actions </a>
                <a class = "active" href = "#change-password"> Change Password</a>
            </div>

            <div class="content">
            <h2> MARKET ADMIN PAGE </h2> 
                <div class = "sub-admin-page-container" id = "new-market">
                    <h4><u>Market Actions</u></h4>  
                    <form action = "funcs.php" method = "POST">
                        <input type = "date" placeholder = " Choose a Date" class = "choose-new-market-date" name = "new_market_date"><br>
                        <input type = "hidden" value = "submitNewMarket" name = "message">
                        <button class = "btn submit-new-market-date"> Submit </button>
                    </form>
                </div>
                <br>
                <div class = "sub-admin-page-container" id = "market-actions">
                    <h4><u>Market Actions</u></h4>
                    <form action = "funcs.php" method = "POST">
                        <select class = 'select-markets' name = 'marketid' id = "marketid">
                            <option value = 'none' selected disabled hidden>Choose a Market </option>
                            <?php echo populateMarketsDropDown(); ?>
                        </select>
                        <br>
                        <ul class = "admin-options-list">
                            <li class = "admin-options-list-item">
                                <input type = "radio" id = "option-1" name = "adminOption" value = "invoke" class = "admin-option">
                                <label for = "option-1"  class = "admin-option-label"> Activate </label>
                                <div class = "check"></div>
                            </li>

                            <li class = "admin-options-list-item">
                                <input type = "radio" id = "option-2" name = "adminOption" value = "terminate" class = "admin-option">
                                <label for = "option-2"  class = "admin-option-label"> Terminate </label>
                                <div class = "check"></div>
                            </li>

                            <li class = "admin-options-list-item">
                                <input type = "radio" id = "option-3" name = "adminOption" value = "deleteMarket" class = "admin-option">
                                <label for = "option-3" class = "admin-option-label"> Delete </label>
                                <div class = "check"></div>
                            </li>
                        </ul>
                        <br>
                        <input id = "hiddenMessage" type="hidden" value = "adminOption" name = "message">
                        <button class = "btn submit-admin-market-option" id = "submit"> SUBMIT </button>
                    </form>
                    
                </div>
                <br>
                <div class = "sub-admin-page-container" id = "change-password">
                    <h4><u>Change Admin's Password</u></h4> <br>
                    <form action = "funcs.php" action = "POST">
                        <input type = "password" placeholder = " Old Password" class = "change-pw-input inline" name = "oldPW" autocomplete = "off">
                        <input type = "password" placeholder = " New Password" class = "change-pw-input inline" name = "newPW1" autocomplete = "off">
                        <input type = "password" placeholder = " Verify New Password" class = "change-pw-input inline" name = "newPW2" autocomplete = "off"> <br><br> 
                        <input type = "hidden" value = "changePW" name = "message"> 
                        <button class = "btn submit-pw-change-btn" id = "submit-pw-change">  Submit </button>
                    </form>
                </div>
            </div>

        </div>
        <div id = "changePWDiv" class = "collapse">
    
        </div>
        <br>
        <div class = "lower_portion">
            <!-- Create New Market: -->
            <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#new_market" aria-expanded="false"> Create New Market </button>
            <div id = "new_market" class = "collapse">
                
            </div>
        </div>
        
    </body>
    <footer class = "footer">
        <h5> Powered by Shahaf Dan - Capstone Project </h5>
        <br>
        <p>Las Positas College | May 2020</p>
    </footer>



</html>
