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
        <h1> MARKET'S INVENTORY </h1>
        <br>
        <button class = "btn btn-warning collapsed" data-toggle="collapse" data-target="#edit_inv" aria-expanded="false" id = "submit"> EDIT INVENTORY </button><br>
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
        <div class = "inv_box_class collapse" id = "view_inv">
            <h4><u> VIEW INVENTORY </u></h4>
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
                    <?php populateItemTable(connDB()); ?>
                </tbody>
            </table>
        </div>
    </body>

</html>
