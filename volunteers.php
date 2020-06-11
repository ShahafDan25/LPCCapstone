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

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="captsone.js"></script>

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
            <h2> The Market - Volunteers </h2>
            <br>
            <div class = "page-sub-container">
                <h4><u>Add a Volunteer</u></h4>
                <br>
                <form action = "funcs.php" method = "POST">
                    <input type = "text" class = "add-volunteer-input inline w80" name = "firstname" placeholder=" First Name" autocomplete = "off"> <br><br>
                    <input type = "text" class = "add-volunteer-input inline w80" name = "lastname" placeholder=" Last Name" autocomplete = "off"><br><br>
                    <input type = "text" class = "add-volunteer-input inline w80" name = "email" placeholder=" Email Address" autocomplete = "off"><br><br>
                    <input type = "hidden" name = "message" value = "add-volunteer">
                    <button class = "btn add-volunteer-btn"> Submit </button>
                </form>
            </div>
            <br>
            <div class = "page-sub-container">
                <h4 class = "inline volunteer-section-title"><u>Volunteers</u></h4>
                <button type = "button" class = "btn volunteer-email-list inline" data-toggle="collapse" data-target="#send-emails-volunteers-div" aria-expanded="false" aria-controls="send-emails-volunteers-div">Generate Email List</button>
                <button type = "button" class = "btn show-deactivated-volunteers inline" data-toggle="collapse" data-target="#deactivated-volunteers-div" aria-expanded="false" aria-controls="deactivated-volunteers-div">See Deactivated Volunteers</button>
                <br><br><?php echo displayAllVolunteers(); ?>
                <!-- Add option to see volunteers for a specific market and their timeslot -->
                <!-- Add option to order volunteers by various options -->

            </div>
            <br>
            <div class = "collapse page-sub-container" id = "deactivated-volunteers-div">
                <h4 class = "inline volunteer-section-title"><u>Deactivated Volunteers</u></h4>
                <?php echo displayDeactivatedVolunteers(); ?>
            </div>
            <br>
            <div class = "collapse page-sub-container" id = "send-emails-volunteers-div">
                <h4 class = "inline volunteer-section-title"><u>Volunteers' Email List</u></h4>
                <button type = "button" class = "btn inline email-volunteer-list-btn" id = "email-volunteer-list-btn">Send Email</button> <br>
                <?php echo displayVolunteerEmailList(); ?>
            </div>
        </div>
        <script>
            $.("email-volunteer-list-btn").click(function(event) {
                $.ajax ({
                    type: "POST",
                    url: "funcs.php",
                    data: {message: "get-email-list"},
                    success: function(data) {
                        window.open("mailto:" + data + "?subject=Volunteer at the Market!");
                    }
                });
            });
        </script>
    </body>
    
</html>