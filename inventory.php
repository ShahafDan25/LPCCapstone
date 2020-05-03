<?php include "adminFuncs.php"; ?> <!-- THIS WILL ALSO INCLUDE connDB() -->
<!DOCTYPE html>
<html>
        <title> Market - Report </title>
                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css?version=1' rel='stylesheet'></link>


        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="./otherFiles/bootstrap.min.css">

        <!-- Bootstrap for JQuery -->
        <script src="./otherFiles/jquery.min.js"></script>

        <!-- Bootstrap for JavaScript -->
        <script src="./otherFiles/bootstrap.min.js"></script>

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="captsone.js"></script>

 
    </head>

    <body class = "bodyRed">
        <div class = "header">
            <button id = "goToAdmin" class = "inline btn btn-primary sideBtn pull-left" onclick = "location.replace('admin.php')"> Admin Page </button>
            <button id = "goToMarket" class = "inline btn btn-primary sideBtn pull-left" onclick = "location.replace('index.php')"> The Market </button>
            <h1 class = "pull-left headerTitle"><strong> The Market  -  LPCSG </strong></h1>
            <img src = "otherFiles/pics/lpcLogo.png" class = "lpcLogo pull-right inline"> &nbsp; &nbsp;
            <img src = "otherFiles/pics/lpcsgLogo.jpg" class = "lpcsgLogo pull-right inline">
        </div>
        <div>  
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
                <p class = "pull-left">* = From Previous Markets' Inventories</p>
                <br><h4><u> CURRENT INVENTORY </u></h4>
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
        </div>
    </body>

</html>
