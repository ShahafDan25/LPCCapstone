<?php //THIS IS A PHP FILE WITH EMBEDED HTML CODE
    include "capstone.php";
?>
<html !DOCTYPE>
    <head>
        <title> The Market </title>

        <link rel="shortcut icon" href="pics/lpcsgLogo.jpg"/>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        
        <!-- CSS HARDCODE FILE LINK -->
        <link rel = "stylesheet" type = "text/css" href = "capstone.css">

        <!-- Bootstrap for JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


        <!-- Bootstrap for JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

        <!-- Bootstrap for CSS Icon -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src = "captsone.js"></script>
    </head>
    <body class = "body">
        <br><br>
        <!-- THIS IS THE HEAD OF THE PAGE: LOGO, TITLE, ADMIN, etc.-->
        <!-- LOOK INTO FLEX BOXED: DIVIDE THIS DIV INTO 3 SEGMENTS -->
        <div class = "upperPortion">
            
                <img src = "pics/lpcLogo.png" class = "lpcLogo pull-right"> &nbsp; &nbsp;
                <img src = "pics/lpcsgLogo.jpg" class = "lpcsgLogo pull-right">
            <div class = "pull-left">
                <button id = "goToAdmin" class = "btn btn-primary pull-left admin" data-toggle = "collapse" data-target = "#adminPagePW"> Admin </button><br><br> 
                <div class = "collapse" id = "adminPagePW">
                    <input type = "text" class = "optional form-control" placeholder="insert password here" class = "password" id = "input" name = "input" required pattern = "\S+.*"> 
                    <button class = "btn btn-info pull-left submitPW" onclick = "checkAdminPW()"> Submit </button>
                </div>  
            </div>
            <br><br><br>
            <h1 class = "mid"> The Market </h1>
            <h4 class = "mid"> MONTH / YEAR</h4>
        </div>


        <!-- THIS IS THE BODY OF THE PAGE -->
        <div class = "operational"> 
            
            <span class = "left" >
                <h3> Returning Patrons </h3> 
                <button class = "btn btn-warning" data-toggle = "collapse" data-target = "#oldPats_div" onclick = "popdd()"> I have been here before </button>
                <div class = "collapse retPats" id = "oldPats_div">
                    <br><br>
                    <p> please choose your name from the dropdown below </p>
                    <!-- DROP DOWN STARTS HERE -->
                    <!-- TAKE CARE OF THAT LATER... POST OR PULL? (What is the oppositve of a pull form?)-->
                    <div id="myDropdown" class="dropdown-content">
                       <input type="text" placeholder="Search..." id="myInput" onkeyup="filterFunction()">
                        <?php  
                            echo populate_dropdown(connDB());
                        ?>
                    </div>
                    <!-- DROPDOWN ENDS HERE -->
                    <br>
                    <button class = "btn btn-secondary" id = submitRetPatBtn> SUBMIT </button>
                </div>
            </span>
            <span class = "right">
                <h3> Newcoming Patrons</h3>
                
                <button id = "newPatsInfoReveal" class = "btn btn-warning" data-toggle = "collapse" data-target = "#newPats_div" > It's my first time here </button>
            

            <div class = "collapse" id = "newPats_div">
                <form method = "post" action = "capstone.php"> <!-- FORM FOR NEW PATRONS -->
                <h3> Please fill out the followings</h3>
                <p> Red Border = Mandatory <br> Black border = Optional <br> Green Border = Filled </p> 
                <div id = "name" class = "infoDiv">
                    <h4> Please enter you first and last name </h4>
                    <input type = "text" class = "mandatory form-control" placeholder="Please enter your first name" class = "firstName" id = "input" name = "first_name" required pattern = "\S+.*"> &nbsp;
                    <input type = "text" class = "mandatory form-control" placeholder="Please enter your last name" class = "lastName" id = "input" name = "last_name" required pattern = "\S+.*"> &nbsp;
                </div>
                <hr>
                <div id = "student?" class = "infoDiv">
                    <h4> Are you a student as Las Positas? </h4>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" required>
                        <label class="btn btn-info active">
                            <input type = "radio" name = "student?" value = "yes"> Yes 
                        </label>
                        <label class="btn btn-info active">
                            <input type = "radio" name = "student?" value = "no"> No
                        </label> 
                    </div>
                </div>
                <hr>
                <div id = "household" class = "infoDiv">
                    <h4> How many people are in your family? (per age) </h4>
                    <input type = "number" class = "mandatory form-control" id = "input" name = "children_amount" placeholder="Children (Ages 0 - 17)" required pattern="\S+.*"><br>
                    <input type = "number" class = "mandatory form-control" id = "input" name = "adults_amount" placeholder="Adults (Ages 18 - 64)" required pattern = "\S+.*"><br>
                    <input type = "number" class = "mandatory form-control" id = "input" name = "seniors_amount" placeholder="Seniors (Ages 64 +)" required pattern = "\S+.*"><br>
                </div>
                <hr>
                <!----- MAKE EMAIL MANDATORY !!!
                -->
                <div id = "PersonalInfo" class = "infoDiv">
                    <h4> Contact Information </h4>
                    <input type = "text" class = "optional form-control" id = "EmailInput" name = "email_address" placeholder="email address" ><br>
                    <input type = "text" class = "optional form-control" id = "PhoneNumberInput" name = "phone_number" placeholder="phone number"><br>
                </div>
                <hr>
                <div id = "Promotion" class = "infoDiv">
                    <h4> How did you hear about the market?</h4>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-info active">
                            <input type = "radio" name = "promotion" value = "Classroom"> Classroom
                        </label>
                        <label class="btn btn-info active">
                            <input type = "radio" name = "promotion" value = "FriendsAndFamily"> Friends / Family
                        </label> 
                        <label class="btn btn-info active">
                            <input type = "radio" name = "promotion" value = "FriendsAndFamily"> Community
                        </label> 
                        <label class="btn btn-info active">
                            <input type = "radio" name = "promotion" value = "FriendsAndFamily"> Other
                        </label> 
                    </div>
                </div>
                <input type="hidden" value = "insertNewPats" name = "message">
                <button class = "btn btn-secondary" id = "newPatSubmission"> SUBMIT </button>
                </form> <!-- WE END THE FORM FOR NEW PATRONS -->
            </div> 
            </span>
            <br><br><br>
        </div><!-- END OF operational div-->
    </body>
</html>
