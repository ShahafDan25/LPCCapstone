<?php include "funcs.php";?>
<!DOCTYPE html>
<html>
    <head>
        <title>The Market </title>
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
    <body class = "signups-page-body">
        <header class = "nav-bar" style = "margin-right: 5% !important;">
            <h2 class = "index-signups-page-header-title"> Las Positas College: The Market </h2>
            <h5 class = "index-signups-page-header-sub-title"><u> <?php echo volunteer_name_from_email($_SESSION['volunteer-id']);?> </u></h5>
            <a href = "profile.php" class = "nav-bar-option responsive inline" style = "float: right !important;"><i class="fa fa-user" aria-hidden="true"></i> Profile </a>
            <a href = "index.php" class = "nav-bar-option responsive inline" style = "float: right !important;"><i class="fa fa-home" aria-hidden="true"></i> Main Page </a>
        </header>
        <div class = "page-container">
            <h2> Sign Up To Markets </h2>
            <select class = 'select-markets' name = 'marketid' id = "marketid">
                <option value = 'none' selected disabled hidden>Choose a Market </option>
                 <?php echo populateNonTerminatedMarketsDropDown(); ?> 
            </select>
            <br><br>
            <div class = "page-sub-container" id = "signup-sheet-container-registration" style = "display: none !important;">
                <form action = "funcs.php" method = "POST">
                        <h6><strong><u> Sign Up To Volunteer At The Market </strong></u></h6>
                        <input type = "time" class = "index-registration-input half inline" name = "starttime" id = "starttime-input" required>
                        <input type = "time" class = "index-registration-input half inline" name = "endtime" id = "endtime-input" required>
                        <input type = "hidden" name = "message" value = "commit-signup">
                        <button class = "btn submit-admin-login"> Submit </button>
                </form>
            </div>
            <br>
            <div class = "page-sub-container" id = "signup-sheet-container" style = "display: none !important"></div>
        </div>
        <!-- ----------------- FOOTER SECTION --------------------- -->
        <footer class = "footer">
            <p> Las Positas College Student Government <br> </p>
            <p class = "shahaf-signature"> Shahaf Dan Productions </p>
        </footer> 
    </body>
    <script>
        $(document).on('change', '#marketid', function() {
            //populate pdf request form 
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
        });
    </script>
</html>
