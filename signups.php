<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up - The Market </title>
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
    <body class = "signups-page-body">
        <header class = "nav-bar" style = "margin-right: 5% !important;">
            <h2 class = "index-signups-page-header-title"> Las Positas College: The Market </h2>
            <h5 class = "index-signups-page-header-sub-title" id = "volunteer-name-displayed"><u></u></h5>
            <!-- <a href = "profile.php" class = "nav-bar-option responsive inline" style = "float: right !important;"><i class="fa fa-user" aria-hidden="true"></i> Profile </a> -->
            <a href = "index.php" class = "nav-bar-option responsive inline" style = "float: right !important;"><i class="fa fa-home" aria-hidden="true"></i> Main Page </a>
        </header>
        <div class = "page-container">
            <h2> Sign Up To Markets </h2>
            <div id = "marketid-container"></div>
            <br>
            <div class = "page-sub-container" id = "signup-sheet-container-registration" style = "display: none !important;">
                <form>
                    <h6><strong><u> Sign Up To Volunteer At The Market </strong></u></h6>
                    <p id = "needed-time-paragraph"> </p> 
                    <div id = "needed-time-inputs"></div>
                    <button class = "btn submit-admin-login" id = "commit-volunteer-signup"> Submit </button>
                </form>
                <div class = "signup-commits" id = "signup-commits"> </div>
            </div>
            <br>
            <div class = "page-sub-container" id = "signup-sheet-container" style = "display: none;">
                <!-- Schedule Of Volunteers Will Be Populated Here  -->
            </div>
        </div>        
        <br><br>
    </body>
    <script>
        alertify.set('notifier','position', 'bottom-center'); //set position    
        alertify.set('notifier','delay', 2.25); //set dellay

        $(document).ready(function() {
            $.ajax({
                type: "POST",
                url: "funcs.php", 
                data: {
                    message: "populate-nonterminated-markekts-dropdown"
                },
                success: function(data){
                    $("#marketid-container").html(data);
                }
            });
            //populate volunteers name at the top of the screen
            $.ajax({
                type: "POST",
                url: "funcs.php", 
                data: {
                    message: "populate-volunteer-name"
                },
                success: function(data){
                    $("#volunteer-name-displayed").html(data);
                }
            });
        });

        $("#commit-volunteer-signup").click(function() {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "commit-signup",
                    starttime: document.getElementById("starttime-input").value,
                    endtime: document.getElementById("endtime-input").value,
                    date: document.getElementById("marketid").value
                },
                success: function(data) {

                    if(data == "committedsignup") alertify.message("Thank you for signing up !");
                }
            });
        });

        function changeMarketId() {
            //populate sign up sheet in divs format 
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "display-signup-sheet",
                    date: document.getElementById("marketid").value
                },
                success: function(data) {
                    $("#signup-sheet-container").html(data);
                    document.getElementById("signup-sheet-container").style.display = "block";
                    document.getElementById("signup-sheet-container-registration").style.display = "block";
                }
            });

            //populate the commits already made by the user
            $.ajax ({
                type: "POST",
                url: "funcs.php", 
                data: {
                    message: "display-volunteer-signup-commits",
                    date: document.getElementById("marketid").value
                },
                success: function (data) {
                    $("#signup-commits").html(data);
                }
            });

            //populate starting time needed and end time needed
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "display-needed-times",
                    date: document.getElementById("marketid").value
                },
                success: function(data) {
                    $("#needed-time-paragraph").html(data);
                }
            });

            //populate the inputs with max and min accordingly 
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "display-needed-times-input",
                    date: document.getElementById("marketid").value
                },
                success: function(data) {
                    $("#needed-time-inputs").html(data);
                }
            });
        }

        $("#remove-signup-commit-btn").click (function (event) {
            //removing a sign up commit from table
            $.ajax ({
                type: "POST",
                url: "funcs.php", 
                data: {
                    message: "remove-then-display-volunteer-signup-commits",
                    date: document.getElementById("marketid").value,
                    starttime: document.getElementById("starttime-input").value,
                    endtime: document.getElementById("endtime-input").value
                },
                success: function (data) {
                    $("#signup-commits").html(data);
                    alertify.message("Sign up commit was removed");
                }
            });
        });
    </script>
</html>
