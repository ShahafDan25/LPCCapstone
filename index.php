<?php include "funcs.php";?>
<!DOCTYPE html>
<html>
    <head>
        <title>The Market </title>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
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


    <body class = "index-page-body">
        <div class = "sidebar" id = "sidebar">
                <a class = "a-item active" id = "new-members-sender" onclick = "responsive_sidebar_item(this.id);"> New Members </a>
                <a class = "a-item" id = "returning-members-sender" onclick = "responsive_sidebar_item(this.id);"> Returning Members</a>
                <a class = "a-item" id = "admin-login-sender" onclick = "responsive_sidebar_item(this.id);"> Admin Page</a>
        </div> 
        <div class = "page-container">
            <h2 class = "mid"> The Las Positas College Market </h2>
            <h4 class = "mid"><u> <?php echo current_market_date();?> </u></h4>
            <!------------------- NEW MEMBERS DIVISION ----------------------->
            <div class = "new-members" id = "new-members" style = "display: block">
            
            </div>
            <!------------------- RETURNING MEMBERS DIVISION ----------------------->
            <div class = "returning-members" id = "returning-members" style = "display: none">
                <h4><u>Returning Patrons</u></h4> 
                    <form method = "POST" action = "funcs.php">
                        <h5> Insert Your Market ID </h5>
                        <span>
                            <input type = "number" class = "mandatory form-control w55 inline" placeholder = "Market ID" name = "patronID">
                            <button class = "btn btn-success inline" id = "retPatSubmission"> SUBMIT </button>
                        </span>
                        <br><br>
                        <p> <strong> FORGOT YOUR ID? </strong> Look for you name below!</p>
                    
                        <input class="form-control" id="myInput" type="text" placeholder="Search.." autocomplete = "off">
                        <br>
                        <ul class="list-group" id="myList">
                            <?php echo populate_dropdown(connDB());?>
                        </ul>  
                        <input type="hidden" value = "patronLogin" name = "message">
                    </form>
            </div>
            <!------------------- ADMIN LOGIN DIVISION ----------------------->
            <div class = "admin-login" id = "admin-login" style = "display: none">
                <form action = "funcs.php" method = "POST">
                    <input type = "password" placeholder="  Password" class = "change-pw-input" name = "inputAdminPW" pattern = "\S+.*" required>
                    <input type = "hidden" value = "verifyPassword" name = "message">
                    <button class = "btn submit-admin-login" id = "inputAdminBtn"> Submit </button>
                </form>
            </div>
            <!------------------- FOOTER SECTION ----------------------->
            <footer class = "footer">
                <p> Las Positas College Student Government <br> </p>
                <p class = "shahaf-signature"> Shahaf Dan Productions </p>
            </footer>
        </div>

    </body>
    <script>
        function responsive_sidebar_item(x) {
            var targets = ["new-members", "returning-members", "admin-login"];
            for(var i = 0; i < targets.length; i++) { //do for all
                document.getElementById(targets[i] + "-sender").className = "a-item";
                // document.getElementById(targets[i]).style.marginTop = "0px";
                document.getElementById(targets[i]).style.display = "none";
            }
            //then do it for target along
            document.getElementById(x).className += " active";
            document.getElementById(x.substring(0, x.length - 7)).style.display = "block";
            // document.getElementById(x.substring(0, x.length - 7)).style.marginTop = "15%";
        }
    </script>
        <!-- <div class = "container"> -->
            <div class = "header">
                <button class = "sideBtn btn inline btn-primary pull-left" id = "goToAdminBtn"> Admin </button>
                    <form class = "inline pull-left" id = "goToAdminForm" method="post" action="index.php" style = "visibility: hidden;">
                    <br>
                        <input type = "password" class = "optional form-control w55 inline" placeholder="  Password" class = "password" id = "inputAdminPW" name = "inputAdminPW" required pattern = "\S+.*" style = "visibility: hidden;">
                        <button class = "btn btn-info inline" id = "inputAdminBtn" style = "visibility: hidden;"> Submit </button>
                        <input class = "inline" type="hidden" value = "verifyPassword" name = "message">
                    </form>
                    <h1 class = "pull-left headerTitle"><strong> The Market  -  LPCSG </strong></h1>
                <img src = "otherFiles/pics/lpcLogo.png" class = "lpcLogo pull-right inline"> &nbsp; &nbsp;
                <img src = "otherFiles/pics/lpcsgLogo.jpg" class = "lpcsgLogo pull-right inline">
            </div>
            
            
            <div class = "operational"> 
                <h1 class = "mid"> The Market </h1>
                <!-- Returning patrons: Login using ID -->
                <span>
                    <h3> Returning Patrons </h3> 
                    <button class = "btn btn-warning" data-toggle = "collapse" data-target = "#oldPats_div"> I have been here before </button>
                    <div class = "collapse w50" id = "oldPats_div">
                        <br> 
                        <form method = "post" action = "adminFuncs.php">
                            <h4> Insert Your Market ID </h4>
                            <span>
                                <input type = "number" class = "mandatory form-control w55 inline" placeholder = "Market ID" name = "patronID">
                                <button class = "btn btn-success inline" id = "retPatSubmission"> SUBMIT </button>
                            </span>
                        <br><br>
                            <p> <strong> FORGOT YOUR ID? </strong> Look for you name below!</p>
                        
                            <input class="form-control" id="myInput" type="text" placeholder="Search.." autocomplete = "off">
                            <br>
                            <ul class="list-group" id="myList">
                                <?php 
                                    echo populate_dropdown(connDB());
                                ?>
                            </ul>  
                            
                        <input type="hidden" value = "patronLogin" name = "message">
                        </form>
                    </div>
                </span>
                <hr>
                <span class = "right">
                <!-- Never been to the market before: sign up form -->
                    <h3> Newcoming Patrons</h3>
                    
                    <button id = "newPatsInfoReveal" class = "btn btn-warning" data-toggle = "collapse" data-target = "#newPats_div" > It's my first time here </button>
                

                <div class = "collapse" id = "newPats_div">
                    <div id = "name" class = "infoDiv">
                        <h4> Please enter your ID, first name, and last name </h4>
                        <br>
                        <input type = "number" class = "mandatory form-control" placeholder="Enter the ID you chose above" class = "idChosen" id = "idSignUpInput" name = "patron_id" required pattern = "\S+.*" min = "6" max = "6" autocomplete = "off"> &nbsp;
                        <p id = "alertedIDdiv"></p>
                        <input type = "text" class = "mandatory form-control" placeholder="Please enter your first name" class = "firstName" name = "first_name" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                        <input type = "text" class = "mandatory form-control" placeholder="Please enter your last name" class = "lastName" name = "last_name" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
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
        <!-- </div> -->


        <script>
            var adminBtn = document.getElementById("goToAdminBtn");
            var toAdminForm = document.getElementById("goToAdminForm");
            var toAdminInput = document.getElementById("inputAdminBtn");
            var toAdminBtn = document.getElementById("inputAdminPW");
            var ids = new Array(<?php echo populateArrayWithIds(connDB()); ?>);
            $(document).ready(function(){
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myList li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });         
                });
            });
            var idInput = document.getElementById("idSignUpInput");
            idInput.onkeyup = function(event){
                if (event.target.value.length == 0) document.getElementById("alertedIDdiv").innerHTML = "";
                else if(event.target.value.length != 6) document.getElementById("alertedIDdiv").innerHTML = "ID has to be 6 digits!";
                else 
                {
                    if(ids.includes(event.target.value)) document.getElementById("alertedIDdiv").innerHTML = "ALERT: This ID is already in use!";
                    else document.getElementById("alertedIDdiv").innerHTML = "ID availability confirmed";
                }
            }

            adminBtn.onclick = function(){
                if(toAdminForm.style.visibility == "visible")
                {
                    toAdminForm.style.visibility = "hidden";
                    toAdminInput.style.visibility = "hidden";
                    toAdminBtn.style.visibility = "hidden";
                }
                else
                {
                    toAdminForm.style.visibility = "visible";
                    toAdminInput.style.visibility = "visible";
                    toAdminBtn.style.visibility = "visible";
                }
                
            }
        </script>
    </body>
</html>
