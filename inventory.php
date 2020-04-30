<?php include "adminFuncs.php"; ?> <!-- THIS WILL ALSO INCLUDE connDB() -->
<html !DOCTYPE>
    <head>
        <title> Market - Report </title>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="./The Market_files/bootstrap.min.css">
        
        <!-- CSS HARDCODE FILE LINK -->
        <link rel="stylesheet" type="text/css" href="capstone.css">

        <!-- Bootstrap for JQuery -->
        <script src="./The Market_files/jquery.min.js"></script>

        <!-- Bootstrap for JavaScript -->
        <script src="./The Market_files/bootstrap.min.js"></script>

        <!-- Bootstrap for CSS Icon -->
        <script src="./The Market_files/a076d05399.js"></script><link rel="stylesheet" href="./The Market_files/free.min.css" media="all">

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="./The Market_files/captsone.js"></script>

 
    </head>

    <body class = "body">
    <button id = "goToMarket" class = "btn btn-primary admin pull-left" onclick = "location.replace('admin.php')"> Admin Page </button>
    <button id = "goToMarket" class = "btn btn-primary admin pull-left" onclick = "location.replace('index.php')"> The Market </button>
    <br>    
    <span style = "text-align:center!important;">
            <h1 > MARKET'S INVENTORY </h1>
        </span>
        <br>
        <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#edit_inv" aria-expanded="false" id = "submit"> ADD TO INVENTORY </button><br>
        <!-- Add new item to the inventory -->

        <div class = "inv_box_class collapse" id = "edit_inv">
            <h4><u> ADD TO INVENTORY </u></h4>
            <br>
            <form action = "adminFuncs.php" method = "post">
                <input type = "text" name = "item_name" class = "inv_input" placeholder="Item Name">
                <input type = "number" name = "item_number" class = "inv_input" placeholder="Quantity">
                <input type = "hidden" name = "message" value = "insertItem">
                <button class = "btn btn-success inv_input_btn"> ADD ITEM </button>
            </form>
        </div>
        <br><br>
        <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#view_inv" aria-expanded="false" id = "submit"> VIEW INVENTORY </button><br>
        <!-- Table with the current updated inventory -->
        <div class = "inv_box_class collapse" id = "view_inv">
            <h4><u> CURRENT INVENTORY </u></h4>
            <br>
            <table class = "table inv_table">
                <thead>
                    <tr>
                        <th scope = "col" class = "inv_label"> ITEM NAME </th>
                        <th scope = "col" class = "inv_label"> QUANTITY </th>
                        <th scope = "col" class = "inv_edit_btn pull-left"> ~ EDIT ~ </th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo populateItemTable(connDB()); ?>
                </tbody>
            </table>
        </div>
    </body>

</html>
