<?php include "funcs.php" ?>
<!DOCTYPE html>
<html>
    <head>
        <title> Volunteers - Market </title>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css?version=1' rel='stylesheet'></link>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      

        <!-- Bootstrap for JQuery, AJAX, JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="captsone.js"></script>

        <!-- FONTAWESOME ICON --> 
        <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
        <script src = "https://use.fontawesome.com/9f04ec4af7.js"></script>

    </head>
    
    <body class = "volunteer-page-body">
    <!-- -------------- NAVIGATION BAR ------------>
        <header class = "nav-bar">
            <a href = "admin.php" class = "nav-bar-option responsive">Admin</a>
            <a href = "index.php" class = "nav-bar-option responsive">Market</a>
            <a href = "report.php" class = "nav-bar-option responsive">Report</a>
            <a href = "inventory.php" class = "nav-bar-option responsive">Inventory</a>
            <h5 class = "nav-bar-title responsive"> The Market - Volunteers </h5>
        </header>
        <div class = "page-container">
            <br>
            <h2> The Market - Volunteers </h2>
            <br>
            <div class = "page-sub-container" id = "general-div-with-active-volunteers-table-div">
                <h4 class = "inline volunteer-section-title"><u>Volunteers</u></h4>
                <button class = "btn volunteer-option op1 inline" id = "send-volunteers-email" onclick = "sendEmailToActiveVolunteers();"><i class="fa fa-share" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op2 inline" id = "email-volunteer-list" onclick = "showMe(this.id);"><i class="fa fa-envelope" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op3 inline" id = "volunteers-schedule-per-market" onclick = "showMe(this.id);"><i class="fa fa-calendar" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op4 inline" id = "add-volunteer-option" onclick = "showMe(this.id);"><i class="fa fa-plus" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op5 inline" id = "activation-waiting-volunteers" onclick = "showMe(this.id);"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op6 inline" id = "deactivated-volunteers" onclick = "showMe(this.id);"><i class="fa fa-minus" aria-hidden="true"></i></button>
                <br><br><br><?php echo displayAllVolunteers(); ?>
            </div>
            <div class = "page-sub-container-volunteer" id = "email-volunteer-list-div" style = "display: none;">
                <button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>
                <h4 class = "inline volunteer-section-title inline"><u>Volunteers' Email List</u></h4> <br>
                <br><br><br><hr class = "spacebar-dark"><br>
                <?php echo displayVolunteerEmailList(); ?>
            </div>
            <div class = "page-sub-container-volunteer" id = "volunteers-schedule-per-market-div" style = "display: none">
                <button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>
                <h4 class = "volunteer-section-title inline"><u>Volunteers Schedule</u></h4>
                <select class = 'select-markets inline' name = 'marketid' id = "marketid" style = "float: right !important; margin-right: 4% !important;" onchange = "chosenMarketDateChanged();">
                    <option value = 'none' selected disabled hidden>Choose a Market </option>
                    <?php echo populateMarketsDropDown(); ?>
                </select>
                <br><br><br><hr class = "spacebar-dark"><br>
                <div id = "sign-up-sheets-in-admin-volunteers"></div>
            </div>
            <div class = "page-sub-container-volunteer" id = "add-volunteer-option-div" style = "display: none;">
                <button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>
                <h4 class = "inline volunteer-section-title"><u>Add a Volunteer</u></h4>
                <br><br>
                <form action = "funcs.php" method = "POST" >
                    <input type = "text" class = "add-volunteer-input full" name = "firstname" placeholder = " First Name" autocomplete = "off"> <br><br>
                    <input type = "text" class = "add-volunteer-input full" name = "lastname" placeholder = " Last Name" autocomplete = "off"><br><br>
                    <input type = "text" class = "add-volunteer-input full" name = "email" placeholder = " Email Address" autocomplete = "off"><br><br>
                    <input type = "hidden" name = "message" value = "add-volunteer">
                    <button class = "btn add-volunteer-btn"> Submit </button>
                </form>
            </div>
            <div class = "page-sub-container-volunteer" id = "activation-waiting-volunteers-div" style = "display: none;">
                <button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>
                <h4 class = "inline volunteer-section-title"><u>Pending Volunteers</u></h4>
                <br><br><br><hr class = "spacebar-dark"><br>
                <div id = "pending-volunteers-div"><?php echo displayVolunteersAwaitingActivation(); ?> </div>

            </div>
            <div class = "page-sub-container-volunteer" id = "deactivated-volunteers-div" style = "display: none">
                <button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>

                <h4 class = "inline volunteer-section-title"><u>Deactivated Volunteers</u></h4>
                <br><br><br><hr class = "spacebar-dark"><br>
                <?php echo displayDeactivatedVolunteers(); ?>
            </div>
        </div>
       
    </body>
    <script>
        function approveRequest(x)
        {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "check-for-active-markets",
                    vol_email: substring(12, x.length)
                },
                success: function(data) {
                    $("#pending-volunteers-div").html(data);
                }
            });
        }
        
        function showMenuAgain()
        {
            var divs = ["email-volunteer-list-div", "volunteers-schedule-per-market-div", "add-volunteer-option-div", "activation-waiting-volunteers-div", "deactivated-volunteers-div"];
            for(var i = 0; i < divs.length; i++) 
            {
                document.getElementById(divs[i]).style.display = "none";
            }
            document.getElementById("general-div-with-active-volunteers-table-div").style.display = "block";
            return;
        }

        function showMe(x) 
        {
            var divs = ["email-volunteer-list-div", "volunteers-schedule-per-market-div", "add-volunteer-option-div", "activation-waiting-volunteers-div", "deactivated-volunteers-div"];
            for(var i = 0; i < divs.length; i++) 
            {
                document.getElementById(divs[i]).style.display = "none";
            }
            document.getElementById("general-div-with-active-volunteers-table-div").style.display = "none";
            document.getElementById(x+"-div").style.display = "block";
        }

       function chosenMarketDateChanged() {
        // populate inventory view table
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    date: document.getElementById("marketid").value, 
                    message: "display-signup-sheet"
                },
                success: function(data) {
                    $("#sign-up-sheets-in-admin-volunteers").html(data);
                }
            });
        };

        function sendEmailToActiveVolunteers()
        {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {message: "get-email-list"},
                success: function(data) {
                    window.open("mailto:" + data + "?subject=Volunteer at the Market!");
                }
            });
        }
    </script>
</html>