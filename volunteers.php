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
            <div class = "page-sub-container" id = "general-div-with-active-volunteers-table-div">
                <h4 class = "inline volunteer-section-title"><u>Volunteers</u></h4>
                <button class = "btn volunteer-option op1 inline" id = "send-volunteers-email" onclick = "sendEmailToActiveVolunteers();" title = "Send Email to Volunteers"><i class="fa fa-share" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op2 inline" id = "email-volunteer-list" onclick = "showMe(this.id);" title = "See Volunteers' Email List"><i class="fa fa-envelope" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op3 inline" id = "volunteers-schedule-per-market" onclick = "showMe(this.id);" title = "See Volunteer Schedule"><i class="fa fa-calendar" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op4 inline" id = "add-volunteer-option" onclick = "showMe(this.id);populateAddVolunteerForm();" title = "Add Volunteers"><i class="fa fa-plus" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op5 inline" id = "activation-waiting-volunteers" onclick = "showMe(this.id);populatePendingVolunteers();" title = "See Pending Volunteers"><i class="fa fa-power-off" aria-hidden="true"></i></button>
                <button class = "btn volunteer-option op6 inline" id = "deactivated-volunteers" onclick = "showMe(this.id);displayTheDeactivated();" title = "See Deactivated Volunteers"><i class="fa fa-minus" aria-hidden="true"></i></button>
                <br><br><br>
                <div id = "all-volunteers-container"></div>
            </div>
            <div class = "page-sub-container-volunteer" id = "email-volunteer-list-div" style = "display: none;">
                <button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>
                <h4 class = "inline volunteer-section-title inline"><u>Volunteers' Email List</u></h4> <br>
                <br><br><br><hr class = "spacebar-dark"><br>
                <div id = "email-list-container"></div>
            </div>
            <div class = "page-sub-container-volunteer" id = "volunteers-schedule-per-market-div" style = "display: none">
                <button class = "btn back-to-menu-volunteer-option inline" onclick = "showMenuAgain();"><strong><i class="fa fa-angle-double-left" aria-hidden="true"></i></strong></button>
                <h4 class = "volunteer-section-title inline"><u>Volunteers Schedule</u></h4>
                <div id = "marketid-container"></div>
                <select class = 'select-markets inline' name = 'marketid' id = "marketid" style = "float: right !important; margin-right: 4% !important;" onchange = "chosenMarketDateChanged();"></select>
                <br><br><br><hr class = "spacebar-dark"><br>
                <div id = "sign-up-sheets-in-admin-volunteers"></div>
            </div>
            <div class = "page-sub-container-volunteer" id = "add-volunteer-option-div" style = "display: none;"></div>
            <div class = "page-sub-container-volunteer" id = "activation-waiting-volunteers-div" style = "display: none;"></div>
            <div class = "page-sub-container-volunteer" id = "deactivated-volunteers-div" style = "display: none"></div>
        </div>
       
    </body>
    <script>
        
        function deactivateVolunteer(x) {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "deactivateVolunteer"
                }
                success: {
                    alert("Volunteer has been deactivated");
                }
            });
        }

        $(document).ready(function() {
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

            //load volunteer email list 
            $.ajax({
                type: "POST",
                url: "funcs.php", 
                data: {
                    message: "load-email-list",
                },
                succes: function(data){
                    $("email-list-container").html(data);
                }
            });

            //load all volunteers in the table format
            $.ajax({
                type: "POST",
                url: "funcs.php", 
                data: {
                    message: "load-volunteers-table",
                },
                succes: function(data){
                    $("all-volunteers-container").html(data);
                }
            });
        });

        function populateAddVolunteerForm() 
        {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "populate-add-volunteer-form"
                },
                success: function(data) {
                    $("#add-volunteer-option-div").html(data);
                }
            });
        }

        function addVolunteer() 
        {
            var name = document.getElementById("firstname").value + " " + document.getElementById("lastname").value;
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "add-volunteer",
                    email: document.getElementById("email").value,
                    firstname: document.getElementById("firstname").value,
                    lastname: document.getElementById("lastname").value
                },
                success: function(data) {
                    if(data != "alreadyinuse") {
                        $("#add-volunteer-option-div").html(data);
                        alertify.set('notifier','position', 'bottom-right');
                        var message = document.createElement('message');
                        message.style.maxHeight = "auto";
                        message.style.width = "250px";
                        message.style.marginRight = "10%";
                        message.style.marginTop = "10%";
                        message.style.padding = "none";
                        message.style.textAlign = "justify";
                        message.style.fontWeight = "bolder";
                        message.style.fontSize = "90%";
                        message.appendChild(document.createTextNode( name + " was added ! "));
                        alertify.set('resizable',true).resizeTo('25%','15%');
                        alertify.success(message).delay(2.25);
                    }
                    else  {
                        alert("This email address is alreday in use by someone!");
                        $.ajax({
                            type: "POST",
                            url: "funcs.php",
                            data: {
                                message: "populate-add-volunteer-form"
                            }
                            success: function(){
                                $("#add-volunteer-option-div").html(data);
                            }
                        });
                    }
                }
            });
        }

        function approveRequest(x)
        {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "approve-pending-vol-request",
                    vol_email: x.substring(12, x.length)
                },
                success: function(data) {
                    $("#activation-waiting-volunteers-div").html(data);
                }
            });
        }
        
        function populatePendingVolunteers() {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "populate-pending-volunteers"
                },
                success: function(data) {
                    $("#activation-waiting-volunteers-div").html(data);
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

        function chosenMarketDateChanged() 
        {
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
        }

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

        function reactivateVolunteer(x) 
        {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "reactivate-volunteer",
                    vol_email: x
                },
                success: function(data) {
                    $("#deactivated-volunteers-div").html(data);
                }
            });
        }

        function removeVolunteer(x)
        {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "remove-volunteer",
                    vol_email: x
                },
                success: function(data) {
                    $("#deactivated-volunteers-div").html(data);
                }
            });
        }

        function displayTheDeactivated()
        {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "display-deactivated-volunteers"
                },
                success: function(data) {
                    $("#deactivated-volunteers-div").html(data);
                }
            });
        }
    </script>
</html>