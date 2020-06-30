<?php session_start(); ?> 
<!DOCTYPE html>
<html>
    <head>
        <title> Market - Inventory </title>
        <link rel="icon" href="otherFiles/pics/lpcLogo2.png">
                
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

    <body class = "inventory-page-body">
        <header class = "nav-bar">
            <a href = "admin.php" class = "nav-bar-option responsive">Admin</a>
            <a href = "index.php" class = "nav-bar-option responsive">Market</a>
            <a href = "report.php" class = "nav-bar-option responsive">Report</a>
            <a href = "volunteers.php" class = "nav-bar-option responsive">Volunteers</a>
            <h5 class = "nav-bar-title responsive"> The Market - Inventory </h5>
        </header>
        <div class = "page-container">
            <div id = "marketid-container"></div>
            <br>
            <!-- Table with the current updated inventory -->
            <div class = "page-sub-container" id = "ext-container-inv" style = "display: none">
                <p class = "pull-left">*  Inventories of Previous Markets</p><br><br>
                <form action = "" method = "POST" id = "add-inv-form">
                    <input type = "text" id = "item_name" class = "add-inventory-input half inline" placeholder = " Item Name" autocomplete = "off" required>
                    <input type = "number" id = "item_number" class = "add-inventory-input half inline" placeholder = " Quantity" autocomplete = "off" required>
                    <button class = "btn add-to-inventory op4 inline"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </form>
                <br><br>
                <div id = "view_inv" style = "display: none"></div>
            </div>
        </div>
    </body>
    <script>
        alertify.set('notifier','position', 'top-right'); //set position    
        alertify.set('notifier','delay', 1.75); //set dellay

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
        });

        $("#add-inv-form").submit(function(e) {
            e.preventDefault();
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
                    alertify.success("Item Added !")
                    $("#view_inv").html(data);
                    document.getElementById("item_number").value = "";
                    document.getElementById("item_name").value = "";
                }
            });
        });

        function removeItem(x) {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    date: document.getElementById("marketid").value, 
                    name: document.getElementById("edit-name-"+x).value, 
                    message: "remove-item"
                },
                success: function(data) {
                    alertify.message("Item Removed");
                    $("#view_inv").html(data);
                }
            });
        }

        function updateInventoryItem(x) {
            console.log(x);
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    namechange: document.getElementById("edit-name-"+x).value, 
                    amount: document.getElementById("edit-amount-"+x).value,
                    name: document.getElementById("og-name-"+x).value,
                    date: document.getElementById("marketid").value,
                    message: "update-inventory-item"
                },
                success: function(data) {
                    alertify.message("Item Updated! ");
                    $("#view_inv").html(data);
                }
            });
        }

        function editInventoryItem(x) {
            document.getElementById("tr-"+x).style.display = "none";
        }

        function changedMarketId() {
            document.getElementById("ext-container-inv").style.display = "block";
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
                    $("#view_inv").html(data);
                }
            });            
            return;
        }
    </script>
</html>
