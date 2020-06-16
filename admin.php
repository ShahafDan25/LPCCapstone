<!DOCTYPE html>
<html>
    <head>
        <title> Admin - LPC Market </title>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css' rel='stylesheet'></link>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      

        <!-- Bootstrap for JQuery, AJAX, JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- FONTAWESOME ICON --> 
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
        <div class = "sidebar" id = "sidebar">
                <a class = "a-item active" id = "new-market-sender" onclick = "responsive_sidebar_item(this.id);"> New Market </a>
                <a class = "a-item" id = "market-actions-sender" onclick = "responsive_sidebar_item(this.id);"> Market Actions </a>
                <a class = "a-item" id = "change-password-sender" onclick = "responsive_sidebar_item(this.id);"> Change Password</a>
        </div>
        <div class = "page-container">
            <div class="content">
                <h2> MARKET ADMIN PAGE </h2> 
                <!-- CREATE NEW MARKET OPTION -->
                <div class = "sub-admin-page-container" id = "new-market" style = "display: block">
                    <h4><u>Create New Market</u></h4>  
                    <input type = "date" placeholder = " Choose a Date" class = "choose-new-market-date" id = "new_market_date"><br><br>
                    <br>
                    <h6><u><strong> For what times would you need volunteers? </strong></u></h6> 
                    <br>
                    <input type = "time" placeholder = " Starting Time" class = "choose-new-market-date inline" id = "new_market_start_time">
                    <i class="fa fa-arrow-right inline" aria-hidden = "true" style = "margin-right: 2% !important; margin-left: 2% !important;"></i>
                    <input type = "time" placeholder = " Closing Time" class = "choose-new-market-date inline" id = "new_market_end_time"><br><br>
                    <button class = "btn submit-new-market-date" id = "submit-new-market-date-btn"> Submit </button>
                </div>
                <!-- MARKET ACTIONS OPTION -->
                <div class = "sub-admin-page-container" id = "market-actions" style = "display: none" >
                    <h4><u>Market Actions</u></h4>
                    <div id = "marketid-container"></div>
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
                            <input type = "radio" id = "option-3" name = "adminOption" value = "delete" class = "admin-option">
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
                    <input type = "password" placeholder = " Old Password" class = "change-pw-input third inline" id = "oldPW" autocomplete = "off" required>
                    <input type = "password" placeholder = " New Password" class = "change-pw-input third inline" id = "newPW1" autocomplete = "off" required>
                    <input type = "password" placeholder = " Verify New Password" class = "change-pw-input inline" id = "newPW2" autocomplete = "off" required> <br><br>
                    <h6 id = "checker"><strong>   *     *     *   </strong></h6>
                    <button class = "btn submit-pw-change-btn" id = "submit-pw-change">  Submit </button>
                </div>
                <footer class = "footer">
                    <p> Las Positas College Student Government </p>
                    <p class = "shahaf-signature"> Shahaf Dan Productions </p>
                </footer>
            </div>
        </div>
    </body>
    <script>
        
        
        $("#submit-pw-change").click(function() {
            if(pw1.value == pw2.value && pw1.value.length > 7){
                $.ajax ({
                    type: "POST",
                    url: "funcs.php",
                    data: {
                        oldPW: document.getElementById("oldPW").value,
                        newPW1: pw1.value,
                        newPW2: pw2.value,
                        message: "changePW"
                    },
                    success: function(data) {
                        if(data == "true") alert("Your password has \r\n been changed succesfully");
                        else if(data == "passeduse") alert ("You have alreday used this password before \r\n choose a different one please.");
                        else if(data == "false") alert("Your Old Password is Incorrect");
                        responsive_sidebar_item("new-market-sender");
                    }
                });
            }
            else {
                if (pw1.value.length < 8) alert("Password's length must be at least 8 characters");
                else if (pw1.value != pw2.value) alert ("Your new passwords do not match");
            }
        });
           
        var pw1 = document.getElementById("newPW1");
        var pw2 = document.getElementById("newPW2");
            
        function responsive_sidebar_item(x) {
            var targets = ["new-market", "market-actions", "change-password"];
            for(var i = 0; i < targets.length; i++) { //do for all
                document.getElementById(targets[i] + "-sender").className = "a-item";
                document.getElementById(targets[i]).style.display = "none";
            }
            document.getElementById(x).className += " active";
            document.getElementById(x.substring(0, x.length - 7)).style.display = "block";
        }

        pw2.onkeyup = function(event){
            if (event.target.value.length == 0)
            {
                document.getElementById("checker").innerHTML = "   *     *     *   ";
                pw2.style = "border-color: rgb(102, 124, 246) !important;";
            } 
            else if(event.target.value != pw1.value) 
            {
                document.getElementById("checker").innerHTML = "Passwords have to match";
                pw2.style = "border-color: rgb(255, 141, 141) !important;";
            }
            else if(event.target.value == pw1.value) 
            {
                pw2.style = "border-color: rgb(157, 255, 161) !important;";
                document.getElementById("checker").innerHTML = "Your password is good!";
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


        $("#submit-market-operation-option").click(function() {
            var options = document.getElementsByName("adminOption");
            for(var i = 0 ;i < options.length; i++) {
                if(options[i].checked) {
                    var checkedAdminOption = options[i].value;
                }
            }
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "adminOption",
                    adminOption: checkedAdminOption,
                    date: document.getElementById("marketid").value
                },
                success: function(data) {
                    if(data == "deleted") alert ("Market Deleted");
                    else if(data == "activated") alert("Market Activated !");
                    else if(data == "terminated") alert("Market Terminated");
                    else if(data == "notactive") alert("You Can't terminate a non active market.");
                    else if(data == "alreadyterminated") alert("This Market has already been terminated");
                    else if(data == "cantactivateterminated") alert("You can't reactivate a terminated market");
                    else if(data == "alreadyactive") alert("This market is already active.");
                    else if(data == "nodatechosen") alert("please choosee a date");
                }
            });
        });
        

        $("#submit-new-market-date-btn").click(function() {
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
                    if(data == "true") alert("Market Added !");
                    else if(data == "false") alert("Market already exists !");
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
