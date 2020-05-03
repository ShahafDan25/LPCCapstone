<?php include "adminFuncs.php";?>
<!DOCTYPE html>
<html>
    <head>
        <title>The Market </title>

        <!-- CSS HARDCODE FILE LINK -->
        <link rel = "stylesheet" type = "text/css" href = "capstone.css"/>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!-- Bootstrap for JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Bootstrap for JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src = "captsone.js"></script>
    </head>


    <body>
        <div class = "container">
            <div class = "header">
                <span>
                    <img src = "otherFiles/pics/lpcLogo.png" class = "lpcLogo pull-right"> &nbsp; &nbsp;
                    <img src = "otherFiles/pics/lpcsgLogo.jpg" class = "lpcsgLogo pull-right">
                </span>
            </div>
            
            
            <div class = "operational"> 
                <h1 class = "mid"> The Market </h1>
                <h4 class = "mid"> 
                    <?php
                        echo current_market_date();
                    ?>
                </h4>
                <!-- Returning patrons: Login using ID -->
                <span>
                    <h3> Returning Patrons </h3> 
                    <button class = "btn btn-warning" data-toggle = "collapse" data-target = "#oldPats_div"> I have been here before </button>
                    <div class = "collapse w50" id = "oldPats_div">
                        <br> 
                        <form method = "post" action = "adminFuncs.php">
                            <h4> Insert Your Market ID </h4>
                            <span>
                                <input type = "text" class = "mandatory form-control inline" placeholder = "Market ID" name = "patronID">
                                <button class = "btn btn-success inline" id = "retPatSubmission"> SUBMIT </button>
                            </span>
                        <br>
                            <p> please look for your name from the dropdown below <br>  After finding your ID, please insert it in the box above </p>
                        
                            <input class="form-control" id="myInput" type="text" placeholder="Search.." autocomplete = "off">
                            <br>
                            <ul class="list-group" id="myList">
                                <?php 
                                    echo populate_dropdown(connDB());
                                ?>
                            </ul>  
                            <br>
                        <input type="hidden" value = "patronLogin" name = "message">
                        </form>
                    </div>
                </span>
                <hr><hr>
                <span class = "right">
                <!-- Never been to the market before: sign up form -->
                    <h3> Newcoming Patrons</h3>
                    
                    <button id = "newPatsInfoReveal" class = "btn btn-warning" data-toggle = "collapse" data-target = "#newPats_div" > It's my first time here </button>
                

                <div class = "collapse" id = "newPats_div">
                    <form method = "post" action = "adminFuncs.php"> 
                        <br>
                        <input type = "text" class = "mandatory btn form-not-form" placeholder="Choose ID (6 Digits)" class = "idChosen" id = "input" name = "patron_id" required pattern = "\S+.*" min = "6" max = "6" autocomplete = "off"> &nbsp;
                        <input type = "hidden" value = "checkID" name = "message" id = "input">
                        <button class = "btn blackback"> Check ID </button> <br>
                        
                    </form>
                    <hr>
    
                    <form method = "post" action = "adminFuncs.php"> 
                    <h4> Please fill out the followings</h4>
                    <p> Red Border = Mandatory <br> Black border = Optional <br> Green Border = Approved </p> 
                    <div id = "name" class = "infoDiv">
                        <h4> Please enter you first and last name </h4>
                        <br>
                        <p> First, check to see if the ID is available before you proceed [SEE ABOVE]</p>
                        <input type = "text" class = "mandatory form-control" placeholder="Enter the ID you chose above" class = "idChosen" id = "input" name = "patron_id" required pattern = "\S+.*" min = "6" max = "6" autocomplete = "off"> &nbsp;
                        <input type = "text" class = "mandatory form-control" placeholder="Please enter your first name" class = "firstName" id = "input" name = "first_name" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                        <input type = "text" class = "mandatory form-control" placeholder="Please enter your last name" class = "lastName" id = "input" name = "last_name" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
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
                        <input type = "number" class = "mandatory form-control" id = "input" name = "children_amount" placeholder="Children (Ages 0 - 17)" min = "0" max = "20" required pattern="\S+.*" autocomplete = "off"><br>
                        <input type = "number" class = "mandatory form-control" id = "input" name = "adults_amount" placeholder="Adults (Ages 18 - 64)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"><br>
                        <input type = "number" class = "mandatory form-control" id = "input" name = "seniors_amount" placeholder="Seniors (Ages 64 +)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"><br>
                    </div>
                    <hr>

                    <div id = "PersonalInfo" class = "infoDiv">
                        <h4> Contact Information </h4>
                        <input type = "text" class = "optional form-control" id = "EmailInput" name = "email_address" placeholder="email address" autocomplete = "off"><br>
                        <input type = "text" class = "optional form-control" id = "PhoneNumberInput" name = "phone_number" placeholder="phone number" autocomplete = "off"><br>
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
                                <input type = "radio" name = "promotion" value = "Community"> Community
                            </label> 
                            <label class="btn btn-info active">
                                <input type = "radio" name = "promotion" value = "Other"> Other
                            </label> 
                        </div>
                    </div>
                    <input type="hidden" value = "insertNewPats" name = "message">
                    <button class = "btn btn-success" id = "newPatSubmission"> SUBMIT </button>
                    </form> 
                </div> 
                </span>
                <br><br><br>
            </div>
        </div>


        <script>
            $(document).ready(function(){
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myList li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });         
                });
            });
            var ids = new Array(<?php echo populateArrayWithIds(connDB()); ?>);
            console.log(ids.length);
            for(var i = 0; i < ids.length; i++)
            {
                console.log(ids[i]);
                console.log(" ");
            }
        </script>

    </body>
</html>
