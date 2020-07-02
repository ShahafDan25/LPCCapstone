<!DOCTYPE html>
<html>
    <head>
        <title> Admin - LPC Market </title>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      

        <!-- Bootstrap for JQuery, AJAX, JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- FONTAWESOME ICON --> 
        <script src = "https://use.fontawesome.com/9f04ec4af7.js"></script>

        <!-- ALERTIFY.JS: JavaScrip and CSS -->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>

          <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css' rel='stylesheet'></link>
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
        <div class = "sidebar" id = "sidebar">
                <a class = "a-item active" id = "index-index-sender" onclick = "responsive_sidebar_item(this.id);"><i class = "fa fa-home" aria-hidden="true"></i></a>
                <a class = "a-item" id = "new-market-sender" onclick = "responsive_sidebar_item(this.id);"> New Market </a>
                <a class = "a-item" id = "market-actions-sender" onclick = "responsive_sidebar_item(this.id);"> Market Actions </a>
                <a class = "a-item" id = "change-password-sender" onclick = "responsive_sidebar_item(this.id);"> Change Password</a>
                <a class = "a-item" id = "change-welcome-sender" onclick = "responsive_sidebar_item(this.id);"> Welcome Message</a>

        </div>
        <div class = "page-container">
            <div class="content">
                <!-- CREATE NEW MARKET OPTION -->
                <div class = "index-index" id = "index-index" style = "display: block">
                    <h3> The Las Positas College Market</h3> 
                    <br>
                    <h1> Admin Page </h1>
                    <br><br>
                    <p style = "text-align: justify !important;">
                        The Administrator's Page is used to oversee and manage the entire market. 
                        You can create responsive and dynamic reports, 
                        manage the inventory of each market event individually and collectively, 
                        oversee the volunteers of each market in either a formatted table or a user-friendly schedule,
                        and even send emails directly to your active volunteers by clicking a single button!
                    </p>
                    <br>
                    <h6 style = "text-align: justify !important;">
                        <strong>
                            <i class="fa fa-exclamation" aria-hidden="true" style = "color: red !important;"></i>  
                            Hopefully, this site will assist you with the entire management of the market and
                            will increase the efficiency and effectiveness of this monthly service provided 
                            by the LPCSG.
                        <strong>
                    </h6> <br>
                    <br><br>
                    <img src = "otherFiles/pics/lpcLogo.png" class = "index-registration-page-header-image inline">
                </div>
                <!-- CREATE NEW MARKET OPTION -->
                <div class = "sub-admin-page-container" id = "new-market" style = "display: none">
                    <h4><u>Create New Market</u></h4> <br> 
                    <form action = "" method = "POST" id = "new-market-form">
                        <input type = "date" placeholder = " Choose a Date" class = "choose-new-market-date" id = "new_market_date" required><br><br>
                        <br>
                        <h6><u><strong> For what times would you need volunteers? </strong></u></h6> 
                        <br>
                        <input type = "time" placeholder = " Starting Time" class = "choose-new-market-date inline" id = "new_market_start_time" required>
                        <i class="fa fa-arrow-right inline" aria-hidden = "true" style = "margin-right: 2% !important; margin-left: 2% !important;"></i>
                        <input type = "time" placeholder = " Closing Time" class = "choose-new-market-date inline" id = "new_market_end_time" required><br><br>
                        <button class = "btn submit-new-market-date" id = "submit-new-market-date-btn"> Submit </button>
                    </form>
                </div>
                <!-- MARKET ACTIONS OPTION -->
                <div class = "sub-admin-page-container" id = "market-actions" style = "display: none">
                    <div id = "marketid-container"></div>
                    <br>
                    <ul class = "admin-options-list">
                        <li class = "admin-options-list-item">
                            <input type = "radio" id = "option-1" name = "admin-option" value = "invoke" class = "admin-option">
                            <label for = "option-1"  class = "admin-option-label"> Activate </label>
                            <div class = "check"></div>
                        </li>
                        <li class = "admin-options-list-item">
                            <input type = "radio" id = "option-2" name = "admin-option" value = "terminate" class = "admin-option">
                            <label for = "option-2"  class = "admin-option-label"> Terminate </label>
                            <div class = "check"></div>
                        </li>
                        <li class = "admin-options-list-item">
                            <input type = "radio" id = "option-3" name = "admin-option" value = "delete" class = "admin-option">
                            <label for = "option-3" class = "admin-option-label"> Delete </label>
                            <div class = "check"></div>
                        </li>
                    </ul>
                    <br>
                    <button class = "btn submit-admin-market-option" id = "submit-market-operation-option"> SUBMIT </button>
                </div>
                <!---- CHANGE PASSWORD OPTION -->
                <div class = "sub-admin-page-container" id = "change-password" style = "display: none">
                    <h4><u>Change Admin's Password</u></h4> <br>
                    <form action = "" method = "POST" id = "change-admin-pw-form">
                        <input type = "password" placeholder = " Old Password" class = "change-pw-input third inline" id = "oldPW" autocomplete = "off" required>
                        <input type = "password" placeholder = " New Password" class = "change-pw-input third inline" id = "newPW1" autocomplete = "off" required>
                        <input type = "password" placeholder = " Verify New Password" class = "change-pw-input inline" id = "newPW2" autocomplete = "off" required> <br><br>
                        <h6 id = "checker"><strong>   *     *     *   </strong></h6> <br>
                        <button class = "btn submit-pw-change-btn" id = "submit-pw-change">  Submit </button> <br>
                    </form>
                </div>
                <!---- CHANGE WELCOME MESSAGE OPTION -->
                <div class = "sub-admin-page-container" id = "change-welcome" style = "display: none">
                    <h3> <u> Edit Information Presented in the Welcome Message </u> </h3><br>
                    <form action = '' method = 'POST' id = 'submit-welcome-index-change'>
                        <div id = "change-welcome-inner-form"></div>
                    </form>
                </div>
                <!-- <footer class = "footer">
                    <p> Las Positas College Student Government </p>
                    <p class = "shahaf-signature"> Shahaf Dan Productions </p>
                </footer> -->
            </div>
        </div>
    </body>
    <script>
        alertify.set('notifier','position', 'bottom-center'); //set position    
        alertify.set('notifier','delay', 1.375); //set dellay

        var pw1 = document.getElementById("newPW1");
        var pw2 = document.getElementById("newPW2");
        var pwtext = document.getElementById("checker");
        var opw = document.getElementById("oldPW");

        $(document).ready(function() {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "populate-edit-welcome-inputs"
                },
                success: function(data) {
                    $("#change-welcome-inner-form").html(data);
                }
            });
        });

        $("#submit-welcome-index-change").submit(function(e) {
            e.preventDefault();
            //change in database
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "edit-welcome-message",
                    subTitle: document.getElementById("sub-title-WE").value,
                    mainTitle: document.getElementById("main-title-WE").value,
                    mainText: document.getElementById("main-text-WE").value,
                    location: document.getElementById("location-WE").value,
                    contact: document.getElementById("contact-WE").value
                },
                success: function(data) {
                    if(data == "true") alertify.success("Welcome Message Changes!");
                    else if(data == "false") alertify.error("Something went wrong. Try Again Later");
                }
            });
        });

        $("#change-admin-pw-form").submit(function(e) {
            e.preventDefault();
            alertify.set('notifier','position', 'bottom-center'); //set position    
            alertify.set('notifier','delay', 1.75); //set dellay
            if(pw1.value == pw2.value && pw1.value.length > 7){
                $.ajax ({
                    type: "POST",
                    url: "funcs.php",
                    data: {
                        oldPW: opw.value,
                        newPW1: pw1.value,
                        newPW2: pw2.value,
                        message: "changePW"
                    },
                    success: function(data) {
                        if(data == "true")  {
                            alertify.success('Your password has been changed !').ondismiss = function() {
                                pw1.value = "";
                                opw.value = "";
                                pw2.value = "";
                                pwtext.innerHTML = "   *     *     *   ";
                                responsive_sidebar_item("index-index-sender");
                            }
                        }
                        else if(data == "passeduse") {
                            alertify.warning('This password was already used before \r\n Please choose a different one.');
                        }
                        else if(data == "false") {
                            alertify.error("Incorrect Password");
                            opw.value = "";
                        }                        
                    }
                });
            }
            else {
                if (pw1.value.length < 8) alertify.warning("Password must be at least 8 characters");
                else if (pw1.value != pw2.value) alertify.warning ("Passwords must match");
            }
            pw1.value = "";
            pw2.value = "";
            pwtext.innerHTML = "   *     *     *   ";
        });
            
        function responsive_sidebar_item(x) {
            var targets = ["new-market", "market-actions", "change-password", "index-index", "change-welcome"];
            for(var i = 0; i < targets.length; i++) { //do for all
                document.getElementById(targets[i] + "-sender").className = "a-item";
                document.getElementById(targets[i]).style.display = "none";
            }
            document.getElementById(x).className += " active";
            document.getElementById(x.substring(0, x.length - 7)).style.display = "block";
            var options = document.getElementsByName("adminOption"); //clean up radio buttons
            for(var i = 0 ;i < options.length; i++) {
                options[i].value = "";                       
            }
        }

        pw2.onkeyup = function(event){
            if (event.target.value.length == 0)
            {
                pwtext.innerHTML = "   *     *     *   ";
                pw2.style = "border-color: rgb(102, 124, 246) !important;";
            } 
            else if(event.target.value != pw1.value) 
            {
                pwtext.innerHTML = "Passwords have to match";
                pw2.style = "border-color: rgb(255, 141, 141) !important;";
            }
            else if(event.target.value == pw1.value) 
            {
                pw2.style = "border-color: rgb(157, 255, 161) !important;";
                pwtext.innerHTML = "Your password is good!";
            }
        }

        pw1.onkeyup = function(event)
        {
            if (event.target.value.length == 0)
            {
                document.getElementById("checker").innerHTML = "   *     *     *   ";
                pw1.style.backgroundColor = "white";
                pw1.borderColor = "rgb(102, 124, 246) !important;";
            } 
            else if(event.target.value.length < 8) 
            {
                document.getElementById("checker").innerHTML = "Password must be 8 characters long";
                pw1.style = "border-color: rgb(255, 141, 141) !important;";
            }
            else if(event.target.value.length > 7) 
            {
                pw1.style = "border-color: rgb(157, 255, 161) !important;";
                document.getElementById("checker").innerHTML = "Your password is good!";
            }
        }

        function changedMarketId() {
            //just to avoid any console error that may occur for now,
            //may use this for later (read plans in diary)
            return;
        }

        function showSubTitleCharCount(len) {
            document.getElementById("sub-title-char-count").innerHTML = len;
            if(len > 65) documet.getElementById("sub-title-WE").value.substr(0,65);
        }

        function showMainTitleCharCount(len) {
            document.getElementById("main-title-char-count").innerHTML = len;
            if(len > 65) documet.getElementById("main-title-WE").value.substr(0,65);
        }

        function showLocationCharCount(len) {
            document.getElementById("location-char-count").innerHTML = len;
            if(len > 100) documet.getElementById("location-WE").value.substr(0,100);
        }

        function showContactCharCount(len) {
            document.getElementById("contact-char-count").innerHTML = len;
            if(len > 100) documet.getElementById("contact-WE").value.substr(0,100);
        }

        $("#submit-market-operation-option").click(function() {
            var options = document.getElementsByName("admin-option");
            for(var i = 0 ;i < options.length; i++) {
                if(options[i].checked) {
                    var checkedAdminOption = options[i].value;
                }
            }
            var date = document.getElementById("marketid").value;
            if(checkedAdminOption == "delete") {
                alertify.confirm("Are you sure you want to delete this market? \r\n All related records will be deleted!", 
                    function() { //yes
                        alertify.message("Ok, Market will be deleted");
                        performAction(checkedAdminOption, date);
                    },
                    function () { //no
                        alertify.message("Operation Cancelled.");
                    }
                );
            }
        });
        
        function performAction(passedaction, passeddate) {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "adminOption",
                    adminOption: passedaction,
                    date: passeddate
                },
                success: function(data) {
                    cleanRadioAdminOptions();
                    if(data == "deleted")  {
                        alertify.success("Market Deleted").ondismiss = function() {
                            responsive_sidebar_item("index-index-sender");
                        }
                    }
                    else if(data == "activated")  {
                        alertify.success("Market Activated !").ondismiss = function() {
                            responsive_sidebar_item("index-index-sender");
                        }
                    }
                    else if(data == "terminated")  {
                        alertify.success("Market Terminated").ondismiss = function() {
                            responsive_sidebar_item("index-index-sender");
                        }
                    }
                    else if(data == "notactive") alertify.warning("Market hasn't been activated yet");
                    else if(data == "alreadyterminated") alertify.warning("Already Terminated");
                    else if(data == "cantactivateterminated") alertify.error("Can't activate a terminated market");
                    else if(data == "alreadyactive") alertify.warning("Already Active");
                    else if(data == "nodatechosen") alertify.warning("Please choose a date");
                    else if(data == "thereexistsanactiveone") alertify.warning("Can't have two active markets!");
                }
            });
        }

        function cleanRadioAdminOptions() {
            var options = document.getElementsByName("admin-option");
            for(var i = 0 ;i < options.length; i++) {
                options[i].checked = false; //set to unchecked for all admin options
            }
            return;
        }

        $("#new-market-form").submit(function(e) {
            e.preventDefault();
            $.ajax( {
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "submitNewMarket",
                    new_market_start_time: document.getElementById("new_market_start_time").value,
                    new_market_date: document.getElementById("new_market_date").value,
                    new_market_end_time: document.getElementById("new_market_end_time").value
                },
                success: function(data) {
                    if(data == "true")  {
                        document.getElementById("new_market_start_time").value = "";
                        document.getElementById("new_market_date").value = "";
                        document.getElementById("new_market_end_time").value = "";
                        alertify.success("Market Added !").ondismiss = function() {
                            responsive_sidebar_item("index-index-sender");
                        }
                    }
                    else if(data == "false") alertify.error("Market already exists !");
                }
            })
        });

        $("#market-actions-sender").click(function() {
            $.ajax({
                type: "POST",
                url: "funcs.php", 
                data: {
                    message: "populate-markets-dropdown"
                },
                success: function(data){
                    $("#marketid-container").html(data);
                }
            });
        });

    </script>
</html>
