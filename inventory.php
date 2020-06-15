<?php session_start(); include "funcs.php"; ?> 
<!DOCTYPE html>
<html>
    <head>
        <title> Market - Inventory </title>
        <link rel="icon" href="otherFiles/pics/lpcLogo2.png">
                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css?' rel='stylesheet'></link>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      

        <!-- Bootstrap for JQuery, AJAX, JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

        <!-- FONTAWESOME ICON --> 
        <script src = "https://use.fontawesome.com/9f04ec4af7.js"></script>
    </head>

    <body class = "inventory-page-body">
        <header class = "nav-bar">
            <a href = "admin.php" class = "nav-bar-option responsive">Admin</a>
            <a href = "index.php" class = "nav-bar-option responsive">Market</a>
            <a href = "report.php" class = "nav-bar-option responsive">Report</a>
            <a href = "volunteers.php" class = "nav-bar-option responsive">Volunteers</a>
            <h5 class = "nav-bar-title responsive"> The Market - Inventory </h5>
        </header>
        <div class = "page-container">
        <h2> MARKET INVENTORY </h2>
            <select class = 'select-markets' name = 'marketid' id = "marketid">
                <option value = 'none' selected disabled hidden>Choose a Market </option>
                <?php echo populateMarketsDropDown(); ?>
            </select>
            <br><br>
            <!-- Table with the current updated inventory -->
            <div class = "page-sub-container" id = "view_inv" style = "display: none"></div>
        </div>
    </body>
    <script>
        $(document).on('change', '#marketid', function() {
            // populate inventory view table
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    date: document.getElementById("marketid").value, 
                    message: "display-inventory-table"
                },
                success: function(data) {
                    document.getElementById("view_inv").style.display = "block";
                    document.getElementById("view_inv").innerHTML = "";
                    $("#view_inv").html(data);
                }
            });
        });

        function insertInventoryItem()
        {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    date: document.getElementById("marketid").value, 
                    amount: document.getElementById("item_number").value,
                    name: document.getElementById("item_name").value,
                    message: "insertItem"
                },
                success: function(data) {
                    document.getElementById("view_inv").innerHTML = "";
                    $("#view_inv").html(data);
                }
            });
        }

        function removeItem(x) {
            var opac = 1;
            var looper = 0;
            setTimeout(() => {
                looper++;
                opac -= looper/3000;
                document.getElementById("tr-"+x).opacity = opac;
            }, 3000);
            // console.log(document.getElementById("tr-"+x));
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    date: document.getElementById("marketid").value, 
                    name: document.getElementById("name-"+x).value, 
                    message: "remove-item"
                },
                success: function(data) {
                    document.getElementById("view_inv").innerHTML = "";
                    $("#view_inv").html(data);
                }
            });
        }
    </script>
</html>
