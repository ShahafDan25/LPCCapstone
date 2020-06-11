<?php session_start(); include "funcs.php"; ?> 
<!DOCTYPE html>
<html>
    <head>
        <title> Market - Inventory </title>
        <link rel="icon" href="otherFiles/pics/lpcLogo2.png">
                
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

    <body class = "inventory-page-body">
        <header class = "nav-bar">
            <a href = "admin.php" class = "nav-bar-option responsive">Admin</a>
            <a href = "index.php" class = "nav-bar-option responsive">Market</a>
            <a href = "report.php" class = "nav-bar-option responsive">Report</a>
            <a href = "volunteers.php" class = "nav-bar-option responsive">Volunteers</a>
            <h5 class = "nav-bar-title responsive"> The Market - Report </h5>
        </header>
        <div class = "page-container">
        <h2> MARKET INVENTORY </h2>
            <select class = 'select-markets' name = 'marketid' id = "marketid">
                <option value = 'none' selected disabled hidden>Choose a Market </option>
                <?php echo populateMarketsDropDown(); ?>
            </select>
            <br>
            <!-- Add new item to the inventory -->
            <div class = "page-sub-container" id = "edit_inv" style = "margin-top: 2% !important;" hidden = "true">
                
            </div>
            <br>
            <!-- Table with the current updated inventory -->
            <div class = "page-sub-container" id = "view_inv" hidden = "true">

            </div>
        </div>
    </body>
    <script>
        $(document).on('change', '#marketid', function() {
            // populate inventory view table
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {date: document.getElementById("marketid").value, message: "display-inventory-table"},
                success: function(data) {
                    document.getElementById("view_inv").hidden = false;
                    document.getElementById("edit_inv").hidden = false;

                    document.getElementById("view_inv").innerHTML = "";
                    $("#view_inv").html(data);
                }
            });

            // populate inventory add item form
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {date: document.getElementById("marketid").value, message: "display-inventory-add-item-form"},
                success: function(data) {
                    document.getElementById("edit_inv").innerHTML = "";
                    $("#edit_inv").html(data);
                }
            });
        });
    </script>
</html>
