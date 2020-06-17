<!DOCTYPE html>
<html>
    <head>
        <title>The Market </title>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css?' rel='stylesheet'></link>

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
    <body class = "index-page-body">
        <header class = "index-registration-page-header">
            <h2 class = "index-registration-page-header-title"> Las Positas College: The Market </h2>
            <h5 class = "index-registration-page-header-sub-title" id = "currentMarketDate"><u></u></h5>
        </header>
        <div class = "sidebar" id = "sidebar" style = "border-right: 2px solid black !important; background-color: #303030 !important;">
            <a class = "a-item active" id = "index-index-sender" onclick = "responsive_sidebar_item(this.id);"><i class = "fa fa-home" aria-hidden="true"></i></a>
            <a class = "a-item" id = "new-members-sender" onclick = "responsive_sidebar_item(this.id);"> New Members </a>
            <a class = "a-item" id = "returning-members-sender" onclick = "responsive_sidebar_item(this.id);"> Returning Members</a>
            <a class = "a-item" id = "admin-login-sender" onclick = "responsive_sidebar_item(this.id);"> Admin </a>
            <a class = "a-item" id = "volunteer-signup-sender" onclick = "responsive_sidebar_item(this.id);"> Volunteer </a>
        </div> 
        <div class = "content" style = "padding-top: 6.5% !important; text-align: center !important;">
            <!------------------- INDEX INDEX DIVISION ----------------------->
            <br>
            <div class = "index-index" id = "index-index" style = "display: block">
                <h4> Las Positas College Presents: </h4>
                <br>
                <h1> The Market </h1>
                <br><br>
                <p style = "text-align: justify !important;">
                    The Market is a free food distribution program brought to you by our Las Positas College 
                    Student Government (LPCSG). Free groceries are available on a first-come, first-serve 
                    basis, and until food runs out. We'll have information about additional resources available 
                    on campus and in our local community. Please bring a reusable bag!
                </p>
                <br><br>
                <h6><i class="fa fa-map-marker" aria-hidden="true"></i>  &nbsp;  Student Service & Administration Building (1600 - South Patio) </h6> <br>
                <h6><i class="fa fa-phone" aria-hidden="true"></i>  &nbsp;  For more information contact the Student Life Office <u> 925 424 1494 </u> </h6>
                <br><br>
                <img src = "otherFiles/pics/lpcLogo.png" class = "index-registration-page-header-image inline">
                <!-- <img src = "otherFiles/pics/lpcsgLogo.jpg" class = "inline" style = "height: 1% !important;"> -->
            </div>
            <!------------------- NEW MEMBERS DIVISION ~ ENGLISH ----------------------->
            <div class = "new-members" id = "new-members" style = "display: none">
                <button class = "btn spanish-new-member-page" id = "spanish-new-member" onclick = "spanishPage();"> Español </button>
                <br>
                <h6 class = "registration-instructions-text"><strong><u> Please choose an ID, and enter your first and last names </u></strong></h6>
                <input type = "number" class = "index-registration-input third inline" placeholder = " Market ID" id = "idSignUpInput" name = "patron_id" pattern = "\S+.*" min = "100000" max = "999999" autocomplete = "off" required> &nbsp;
                <input type = "text" class = "index-registration-input third inline" placeholder = " First Name" class = "firstName" name = "first_name" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                <input type = "text" class = "index-registration-input third inline" placeholder = " Last Name" class = "lastName" name = "last_name" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                <p id = "alertedIDdiv" style = "display: none !important;"></p>
                <br>
                <h6 class = "registration-instructions-text"><strong><u> Are you a student as Las Positas? </strong></u></h6>
                <ul class = "new-member-options-list">
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "studentStatus" value = "yes" class = "new-member-option inline">
                        <label for = "yes-student-option"  class = "admin-option-label inline"> Yes </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "studentStatus" value = "no" class = "new-member-option inline">
                        <label for = "no-student-option"  class = "admin-option-label inlin"> No </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                </ul>
                <br>
                <h6 class = "registration-instructions-text"><strong><u> How many people are in your household? </u></strong></h6>
                <input type = "number" class = "index-registration-input third inline" name = "children_amount" placeholder = "Children (Ages 0 - 17)" min = "0" max = "20" required pattern="\S+.*" autocomplete = "off"> &nbsp;
                <input type = "number" class = "index-registration-input third inline" name = "adults_amount" placeholder = "Adults (Ages 18 - 64)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                <input type = "number" class = "index-registration-input third inline" name = "seniors_amount" placeholder = "Seniors (Ages 64 +)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                <br>
                <h6 class = "registration-instructions-text"><strong><u> Contact Information </strong></u></h6>
                <input type = "text" class = "index-registration-input half inline" name = "email_address" placeholder = " Email" autocomplete = "off"> &nbsp;
                <input type = "text" class = "index-registration-input half inline" name = "phone_number" placeholder = " Phone Number" autocomplete = "off"> &nbsp;
                <br>
                <h6><strong><u> How did you hear about the market? </strong></u></h6>
                <ul class = "new-member-options-list">
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "promotion" id = "classroom-option" value = "Classroom" class = "new-member-option inline">
                        <label for = "classroom-option"  class = "admin-option-label inline"> Classroom </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "promotion" id = "fnf-option" value = "FriendsAndFamily" class = "new-member-option inline">
                        <label for = "fnf-option"  class = "admin-option-label inline"> Friends and Family </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "promotion" id = "community-option" value = "Community" class = "new-member-option inline">
                        <label for = "community-option"  class = "admin-option-label inline"> Community </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "promotion" id = "other-option" value = "Other" class = "new-member-option inline">
                        <label for = "other-option"  class = "admin-option-label inline"> Other </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                </ul>
                <button class = "btn btn-submit-new-patron" id = "newPatSubmission" onclick = "insert_patron();"> SUBMIT </button>
            </div>
            <!------------------- NEW MEMBERS DIVISION ~ SPANISH ----------------------->
            <div class = "new-members" id = "spanish-new-members" style = "display: none">
                <button class = "btn spanish-new-member-page" id = "new-member" onclick = "englishPage();"> English </button>
                <br>
                <h6 class = "registration-instructions-text"><strong><u> Por favor, elija un número de identificación e ingrese su nombre y apellido </u></strong></h6>
                <input type = "number" class = "index-registration-input third inline" placeholder=" Identificación" id = "idSignUpInput" name = "patron_id" pattern = "\S+.*" min = "6" max = "6" autocomplete = "off" required> &nbsp;
                <input type = "text" class = "index-registration-input third inline" placeholder = " Nombre" class = "firstName" name = "first_name" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                <input type = "text" class = "index-registration-input third inline" placeholder = " Apellido" class = "lastName" name = "last_name" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                <p id = "alertedIDdiv" style = "display: none !important;"></p>
                <br>
                <h6 class = "registration-instructions-text"><strong><u> ¿Eres estudiante en Las Positas College? </strong></u></h6>
                <ul class = "new-member-options-list">
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "studentStatus" value = "yes" class = "new-member-option inline">
                        <label for = "yes-student-option"  class = "admin-option-label inline"> Si </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "studentStatus" value = "no" class = "new-member-option inline">
                        <label for = "no-student-option"  class = "admin-option-label inlin"> No </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                </ul>
                <br>
                <h6 class = "registration-instructions-text"><strong><u> ¿Cuantos personas hay en tu hogar? </u></strong></h6>
                <input type = "number" class = "index-registration-input third inline" name = "children_amount" placeholder = " Niños (Años 0 - 17)" min = "0" max = "20" required pattern="\S+.*" autocomplete = "off"> &nbsp;
                <input type = "number" class = "index-registration-input third inline" name = "adults_amount" placeholder = " Adultos (Años 18 - 64)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                <input type = "number" class = "index-registration-input third inline" name = "seniors_amount" placeholder = " Personas mayores (Años 64 +)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                <br>
                <h6 class = "registration-instructions-text"><strong><u> Información del contacto </strong></u></h6>
                <input type = "text" class = "index-registration-input half inline" name = "email_address" placeholder = " Correo electrónico" autocomplete = "off"> &nbsp;
                <input type = "text" class = "index-registration-input half inline" name = "phone_number" placeholder = " Número de teléfono" autocomplete = "off"> &nbsp;
                <br>
                <h6><strong><u> ¿Cómo se enteró del mercado? </strong></u></h6>
                <ul class = "new-member-options-list">
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "promotion" value = "Classroom" class = "new-member-option inline" id = "classroom-option-spanish">
                        <label for = "classroom-option-spanish"  class = "admin-option-label inline"> Aula </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "promotion" value = "FriendsAndFamily" class = "new-member-option inline" id = "fnf-option-spanish">
                        <label for = "fnf-option-spanish"  class = "admin-option-label inline"> Amigos y familia </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "promotion" value = "Community" class = "new-member-option inline" id = "community-option-spanish">
                        <label for = "community-option-spanish"  class = "admin-option-label inline"> Comunidad </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                    <li class = "new-member-options-list-item inline">
                        <input type = "radio" name = "promotion" value = "Other" class = "new-member-option inline" id = "other-option-spanish">
                        <label for = "other-option-spanish"  class = "admin-option-label inline"> Otra </label>
                        <div class = "new-member-check inline"></div>
                    </li>
                </ul>
                <button class = "btn btn-submit-new-patron" id = "newPatSubmission-spanish" onclick = "insert_patron();"> Enviar </button>
            </div>
            <!------------------- RETURNING MEMBERS DIVISION ~ English ----------------------->
            <div class = "returning-members" id = "returning-members" style = "display: none">
                <button class = "btn spanish-new-member-page" id = "returning-member" onclick = "spanishPageReturning();"> Spanish </button>
                <br><br>
                <p> <strong> Login with your Market ID </strong></p>
                <span><i class = "fa fa-user inline" aria-hidden = "true"></i><input type = "number" class = "index-registration-input full-share-icon inline" placeholder = "Market ID" name = "patronID" required></label>
                <br><br>
                <p> <strong> FORGOT YOUR ID? </strong> Look for you name below!</p>
                <span><i class = "fa fa-search inline" aria-hidden = "true"></i> <input class = "index-registration-input full-share-icon inline" id = "myInput" type="text" placeholder = " Search.." autocomplete = "off"> </span>
                <br>
                <ul class = "list-group" id = "myList"></ul>  
                <br>
                <button class = "btn submit-returning-patron-login" onclick = "login_patron();"> SUBMIT </button>
            </div>
            <!------------------- RETURNING MEMBERS DIVISION ~ Spanish ----------------------->
            <div class = "returning-members" id = "returning-members-spanish" style = "display: none">
                <button class = "btn spanish-new-member-page" id = "returning-member-spanish" onclick = "englishPageReturning();"> English </button>
                <br><br>
                <p> <strong> Inicie sesión con su identificación </strong></p>
                <span><i class = "fa fa-user inline" aria-hidden = "true"></i><input type = "number" class = "index-registration-input full-share-icon inline" placeholder = "  Identificación" name = "patronID"></label>
                <br><br>
                <p> <strong> ¿Olvidaste tu identificación? </strong> Busca tu nombre ! </p>
                <span><i class = "fa fa-search inline" aria-hidden = "true"></i> <input class = "index-registration-input full-share-icon inline" id = "myInput-spanish" type = "text" placeholder = " Busca.." autocomplete = "off"> </span>
                <br>
                <ul class = "list-group" id = "myList-spanish"></ul>  
                <br>
                <input type="hidden" value = "patronLogin" name = "message">
                <button class = "btn submit-returning-patron-login" onclick = "login_patron():"> Enviar </button>
            </div>
            <!------------------- ADMIN LOGIN DIVISION ----------------------->
            <div class = "admin-login" id = "admin-login" style = "display: none">
                <h3>Login as an Admin </h3>
                <br><br>
                <h6><strong><u>Enter Password Below</u></strong></h6> <br>
                <input type = "password" placeholder="  Password" class = "change-pw-input full" id = "inputAdminPW" pattern = "\S+.*" required> <br><br>
                <button class = "btn submit-admin-login" id = "inputAdminBtn" onclick = "adminLogin();"> Submit </button>
            </div>
            <!------------------- VOLUNTEER SIGN UP DIVISION ----------------------->
            <div class = "volunteer-signup" id = "volunteer-signup" style = "display: none">
                <h6><strong><u> Login With Your Email </strong></u></h6>
                <input type = "text" placeholder = "  Email" class = "index-registration-input full" id = "volunteer-email" pattern = "\S+.*" required> <br><br>
                <button class = "btn submit-admin-login" id = "volunteer-login-btn"> Submit </button>
                <br><br> <hr style = "width: 80% !important; border: 0.7px solid #303030 !important;"> <br><br>
                <h6><strong><u> Request Volunteer Access </strong></u></h6>
                <input type = "text" placeholder = "  First Name" class = "index-registration-input half inline" id = "first-name-volunteer" pattern = "\S+.*" required> 
                <input type = "text" placeholder = "  Last Name" class = "index-registration-input half inline" id = "last-name-volunteer" pattern = "\S+.*" required> <br>
                <input type = "text" placeholder = "  Email" class = "index-registration-input full" id = "volunteer-email-request" pattern = "\S+.*" required> <br><br>
                <button class = "btn submit-admin-login" id = "volunteer-request-btn"> Submit </button>
            </div>
            <!-------------------- NO ACTIVE MARKET MESSAGE --------------->
            <div class = "no-active-market-message" id = "no-active-market-message" style = "display: none;">
                <br>    
                <h1> There is Currently No Active Market </h1>
                <h3> The Admin needs to create and activate a market </h3>
                <br><br>
                <img src = "otherFiles/pics/lpcLogo.png" class = "index-registration-page-header-image inline">

            </div>
            <!-- ----------------- FOOTER SECTION --------------------- -->
            <!-- <footer class = "footer">
                <p> Las Positas College Student Government <br> </p>
                <p class = "shahaf-signature"> Shahaf Dan Productions </p>
            </footer>  -->
        </div>
    </body>
    <script>
        $("#volunteer-request-btn").click(function() {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "volunteer-request",
                    volunteerEmail: document.getElementById("volunteer-email-request").value,
                    first: document.getElementById("first-name-volunteer").value,
                    last: document.getElementById("last-name-volunteer").value
                },
                success: function(data) {
                    if(data == "true") {
                        alert("Your request has been submitted!");
                        location.replace("index.php");
                    }
                    else if (data == "false") alert("Your email is not a registered volunteer. \r\n You can request a volunteer access below.")
                }  
            });
        });

        $("#volunteer-login-btn").click(function() {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "volunteer-login",
                    volunteerEmail: document.getElementById("volunteer-email").value
                },
                success: function(data) {
                    if(data == "true") location.replace("signups.php");
                    else if (data == "false") alert("Your email is not a registered volunteer. \r\n You can request a volunteer access below.")
                }  
            });
        });

        $( document ).ready(function() {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "loadidsarray"
                },
                success: function(data) {
                    var ids = new Array(data);
                }  
            });
        });

        $( document ).ready(function() {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "get-current-market-date"
                },
                success: function(data) {
                    $("#currentMarketDate").html(data);
                }  
            });
        });

        var adminBtn = document.getElementById("goToAdminBtn");
        var toAdminForm = document.getElementById("goToAdminForm");
        var toAdminInput = document.getElementById("inputAdminBtn");
        var toAdminBtn = document.getElementById("inputAdminPW");

        $("#myInput").keyup(function() {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    likename: (document.getElementById("myInput").value).split(" ").join(" "), //get rid of all white spaces,
                    message: "populate-like-returning-patrons"
                },
                success: function(data) {
                    $("#myList").html(data);
                }  
            });
            //filter:
            var value = $(this).val().toLowerCase();
            $("#myList li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });         
        });

        //same but for spanish page to differentiate id uniqueness
        $("#myInput-spanish").keyup(function() {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    likename: (document.getElementById("myInput-spanish").value).split(" ").join(" "), //get rid of all white spaces,
                    message: "populate-like-returning-patrons"
                },
                success: function(data) {
                    $("#myList-spanish").html(data);
                }  
            });
            //filter:
            var value = $(this).val().toLowerCase();
            $("#myList-spanish li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });         
        });
        
        function login_patron() {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {patronID: document.getElementByName("patronID").value,message: "patronLogin"},
                success: function(data) 
                {
                    if(data == "false") {
                        alert("You are already logged in !");
                    } 
                    else if(data == "true") {
                        alert ("Thank you! \r\n Enjoy the Market");
                        responsive_sidebar_item("index-index-sender");
                    }
                }  
            });
        }
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
            var targets = ["new-members", "returning-members", "admin-login", "volunteer-signup", "index-index"];
            for(var i = 0; i < targets.length; i++) { //do for all
                document.getElementById(targets[i] + "-sender").className = "a-item";
                document.getElementById(targets[i]).style.display = "none";
            }
            document.getElementById("spanish-new-members").style.display = "none";
            document.getElementById("returning-members-spanish").style.display = "none";
            document.getElementById("no-active-market-message").style.display = "none";
            //then do it for target alone
            document.getElementById(x).className += " active";
            if(x.substring(0, x.length - 7) == "new-members" || x.substring(0, x.length - 7) == "returning-members") {
                $.ajax({
                    type: "POST",
                    url: "funcs.php",
                    data: {
                        message: "check-for-active-markets"
                    },
                    success: function(data) {
                        if(data == "true") {
                            document.getElementById(x.substring(0, x.length - 7)).style.display = "block";
                        }
                        else {
                            document.getElementById(x.substring(0, x.length - 7)).style.display = "none";
                            document.getElementById("no-active-market-message").style.display = "block";
                        }
                    }
                });
            }
            else {
                document.getElementById(x.substring(0, x.length - 7)).style.display = "block";
            }
        }

        function filterFunction()
        {
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            div = document.getElementById("myDropdown");
            a = div.getElementsByTagName("a");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                    } else {
                    a[i].style.display = "none";
                }
            }
        }

        function spanishPage(){
            document.getElementById("new-members").style.display = "none";
            document.getElementById("spanish-new-members").style.display = "block";
        }

        function englishPage() {
            document.getElementById("new-members").style.display = "block";
            document.getElementById("spanish-new-members").style.display = "none";
        }

        function englishPageReturning() {
            document.getElementById("returning-members-spanish").style.display = "none";
            document.getElementById("returning-members").style.display = "block";
        }

        function spanishPageReturning() {
            document.getElementById("returning-members-spanish").style.display = "block";
            document.getElementById("returning-members").style.display = "none";
        }

        function adminLogin() {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    inputAdminPW:  document.getElementById("inputAdminPW").value,
                    message: "verifyPassword"
                },
                success: function(data) {
                    if(data == "false") alert("Incorrect Password");
                    else if(data == "true") location.replace("admin.php");
                }
            });
        }

        function insert_patron() 
        {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    patron_id: document.getElementByName("patron_id").value,
                    first_name: document.getElementByName("first_name").value,
                    last_name: document.getElementByName("last_name").value,
                    studentStatus: document.getElementByName("studentStatus").value,
                    children_amount: document.getElementByName("children_amount").value,
                    adults_amount: document.getElementByName("adults_amount").value,
                    seniors_amount: document.getElementByName("seniors_amount").value,
                    email_address: document.getElementByName("email_address").value,
                    phone_number: document.getElementByName("phone_number").value,
                    promotion: document.getElementByName("promotion").value,
                    message: "insertNewPats"
                },
                success: function(data) {
                    responsive_sidebar_item("index-index-sender");

                    
                }
            });
        }

        
    </script>
</html>
