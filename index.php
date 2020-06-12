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
        <div class = "sidebar" id = "sidebar" style = "border-right: 2px solid black !important; background-color: #303030 !important;">
            <a class = "a-item active" id = "new-members-sender" onclick = "responsive_sidebar_item(this.id);"> New Members </a>
            <a class = "a-item" id = "returning-members-sender" onclick = "responsive_sidebar_item(this.id);"> Returning Members</a>
            <a class = "a-item" id = "admin-login-sender" onclick = "responsive_sidebar_item(this.id);"> Admin Page</a>
        </div> 
        <div class = "content" style = "padding-top: 1.5% !important; text-align: center !important;">
            <h2> Las Positas College: The Market </h2>
            <h5><u> <?php echo current_market_date();?> </u></h5>
            <!------------------- NEW MEMBERS DIVISION ----------------------->
            <br>
            <div class = "new-members" id = "new-members" style = "display: block">
                <div id = "name">
                    <h6 class = "registration-instructions-text"><strong><u> Please choose an ID, and enter your first and last names </u></strong></h6>
                    <input type = "number" class = "index-registration-input third inline" placeholder=" Market ID" id = "idSignUpInput" name = "patron_id" pattern = "\S+.*" min = "6" max = "6" autocomplete = "off" required> &nbsp;
                    <input type = "text" class = "index-registration-input third inline" placeholder = " First Name" class = "firstName" name = "first_name" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                    <input type = "text" class = "index-registration-input third inline" placeholder = " Last Name" class = "lastName" name = "last_name" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                    <p id = "alertedIDdiv" style = "display: none !important;"></p>
                </div>
                <br>
                <div id = "student-status">
                    <h6 class = "registration-instructions-text"><strong><u> Are you a student as Las Positas? </strong></u></h6>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" required>
                        <label class="btn btn-info active">
                            <input type = "radio" name = "student?" value = "yes"> Yes 
                        </label>
                        <label class="btn btn-info active">
                            <input type = "radio" name = "student?" value = "no"> No
                        </label> 
                    </div>
                </div>
                <br>
                <div id = "household">
                    <h6 class = "registration-instructions-text"><strong><u> How many people are in your household? </u></strong></h6>
                    <input type = "number" class = "index-registration-input third inline" name = "children_amount" placeholder = "Children (Ages 0 - 17)" min = "0" max = "20" required pattern="\S+.*" autocomplete = "off"> &nbsp;
                    <input type = "number" class = "index-registration-input third inline" name = "adults_amount" placeholder = "Adults (Ages 18 - 64)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                    <input type = "number" class = "index-registration-input third inline" name = "seniors_amount" placeholder = "Seniors (Ages 64 +)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                </div>
                <br>
                <div id = "PersonalInfo">
                    <h6 class = "registration-instructions-text"><strong><u> Contact Information </strong></u></h6>
                    <input type = "text" class = "index-registration-input half inline" name = "email_address" placeholder = " Email" autocomplete = "off"> &nbsp;
                    <input type = "text" class = "index-registration-input half inline" name = "phone_number" placeholder = " Phone Number" autocomplete = "off"> &nbsp;
                </div>
                <br>
                <div id = "promotiong-method">
                    <h6><strong><u> How did you hear about the market? </strong></u></h6>
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
                <br>
                <input type="hidden" value = "insertNewPats" name = "message"> 
                <button class = "btn btn-submit-new-patron" id = "newPatSubmission"> SUBMIT </button>
                </form> 
            </div>
            <!------------------- RETURNING MEMBERS DIVISION ----------------------->
            <div class = "returning-members" id = "returning-members" style = "display: none">
                    <form method = "POST" action = "funcs.php">
                        <span>
                            <input type = "number" class = "mandatory form-control w55 inline" placeholder = "Market ID" name = "patronID">
                            <button class = "btn btn-success inline" id = "retPatSubmission"> SUBMIT </button>
                        </span>
                        <br><br>
                        <p> <strong> FORGOT YOUR ID? </strong> Look for you name below!</p>
                    
                        <input class="form-control" id="myInput" type="text" placeholder=" Search.." autocomplete = "off">
                        <br>
                        <ul class="list-group" id="myList">
                            <?php echo populate_dropdown(connDB());?>
                        </ul>  
                        <input type="hidden" value = "patronLogin" name = "message">
                        <button class = "btn btn-success">SUBMIT </button>
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
            <!-- ----------------- FOOTER SECTION ---------------------
            <footer class = "footer">
                <p> Las Positas College Student Government <br> </p>
                <p class = "shahaf-signature"> Shahaf Dan Productions </p>
            </footer> -->
        </div>

    </body>
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
        var text = document.getElementById("alertedIDdiv");
        idInput.onkeyup = function(event){
            if (event.target.value.length == 0)  {
                text.innerHTML = "";
                text.style.display = "none";

            }
            else {
                text.style.display = "block";
                if(event.target.value.length != 6) text.innerHTML = "ID has to be 6 digits!";
                else 
                {
                    if(ids.includes(event.target.value)) text.innerHTML = "ALERT: This ID is already in use!";
                    else text.innerHTML = "ID availability confirmed";
                }
            }
        }
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
            <!-- <div class = "header">
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
            </div> -->
        <!-- </div> -->
    </body>
</html>
