<!-- <?php include "funcs.php" ?> -->
<!DOCTYPE html>
<html>
    <head>
        <title> Market - Admin </title>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css?version=1' rel='stylesheet'></link>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      

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
                    <input type = "text" class = "add-volunteer-input inlinew w80" name = "lastname" placeholder=" Last Name" autocomplete = "off"><br><br>
                    <input type = "text" class = "add-volunteer-input inline w80" name = "email" placeholder=" Email Address" autocomplete = "off"><br><br>
                    <input type = "hidden" name = "message" value = "add-volunteer">
                    <button class = "add-volunteer-btn"> Submit </button>
                </form>
            </div>
            <br>
            <div class = "page-sub-container">
                <h4 class = "inline"><u>Volunteers</u></h4>
                <button class = "volunteer-email-list inline">Generate Email List</button>
                <br>
                <table class = "table">
                    <thead>
                        <tr>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Add Date </th>
                            <th> Delete </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo displayAllVolunteers(); ?>
                    </tbody>
                </table>
                <!-- Add option to see volunteers for a specific market and their timeslot -->
            </div>
        </div>
    </body>
</html>