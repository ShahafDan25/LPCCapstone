<!DOCTYPE html>
<html>
    <head>
        <title>The Market </title>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      

        <!-- Bootstrap for JQuery, AJAX, JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- FONTAWESOME ICON --> 
        <script src = "https://use.fontawesome.com/9f04ec4af7.js"></script>

        <!-- ALERTIFY.JS JavaScrip and CSS -->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>

          <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css' rel='stylesheet'></link>
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
                <br><br>
                <form action = "" method = "POST" id = "submit-new-member-english">
                    <h6 class = "registration-instructions-text"><strong><u> Please choose an ID, and enter your first and last names </u></strong></h6>
                    <input type = "number" class = "index-registration-input third inline" placeholder = " Market ID" id = "idSignUpInput" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                    <input type = "text" class = "index-registration-input third inline" placeholder = " First Name" class = "firstName" id = "first_name" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                    <input type = "text" class = "index-registration-input third inline" placeholder = " Last Name" class = "lastName" id = "last_name" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                    <p id = "alertedIDdiv" style = "display: none !important;"> - </p>
                    <br>
                    <h6 class = "registration-instructions-text"><strong><u> Are you a student at Las Positas? </strong></u></h6>
                    <ul class = "new-member-options-list">
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "studentStatus-english" value = "yes" class = "new-member-option inline" id = "yes-student-option">
                            <label for = "yes-student-option"  class = "admin-option-label inline"> Yes </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "studentStatus-english" value = "no" class = "new-member-option inline" id = "no-student-option">
                            <label for = "no-student-option"  class = "admin-option-label inlin"> No </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                    </ul>
                    <br>
                    <h6 class = "registration-instructions-text"><strong><u> How many people are in your household? </u></strong></h6>
                    <input type = "number" class = "index-registration-input third inline" id = "children_amount" placeholder = "Children (Ages 0 - 17)" min = "0" max = "20" required pattern="\S+.*" autocomplete = "off"> &nbsp;
                    <input type = "number" class = "index-registration-input third inline" id = "adults_amount" placeholder = "Adults (Ages 18 - 64)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                    <input type = "number" class = "index-registration-input third inline" id = "seniors_amount" placeholder = "Seniors (Ages 64 +)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                    <br><br>
                    <h6 class = "registration-instructions-text"><strong><u> Contact Information </strong></u></h6>
                    <input type = "text" class = "index-registration-input half inline" id = "email_address" placeholder = " Email" autocomplete = "off"> &nbsp;
                    <input type = "text" class = "index-registration-input half inline" id = "phone_number" placeholder = " Phone Number" autocomplete = "off"> &nbsp;
                    <br><br>
                    <h6><strong><u> How did you hear about the market? </strong></u></h6>
                    <ul class = "new-member-options-list">
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "promotion-english" id = "classroom-option" value = "Classroom" class = "new-member-option inline">
                            <label for = "classroom-option"  class = "admin-option-label inline"> Classroom </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "promotion-english" id = "fnf-option" value = "FriendsAndFamily" class = "new-member-option inline">
                            <label for = "fnf-option"  class = "admin-option-label inline"> Friends and Family </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "promotion-english" id = "community-option" value = "Community" class = "new-member-option inline">
                            <label for = "community-option"  class = "admin-option-label inline"> Community </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "promotion-english" id = "other-option" value = "Other" class = "new-member-option inline">
                            <label for = "other-option"  class = "admin-option-label inline"> Other </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                    </ul>
                    <br>
                    <button class = "btn btn-submit-new-patron" id = "newPatSubmission"> SUBMIT </button>
                </form>
            </div>
            <!------------------- NEW MEMBERS DIVISION ~ SPANISH ----------------------->
            <div class = "new-members" id = "spanish-new-members" style = "display: none">
                <button class = "btn spanish-new-member-page" id = "new-member" onclick = "englishPage();"> English </button>
                <br><br>
                <form action = "" method = "POST" id = "submit-new-member-spanish">
                    <h6 class = "registration-instructions-text"><strong><u> Por favor, elija un número de identificación e ingrese su nombre y apellido </u></strong></h6>
                    <input type = "number" class = "index-registration-input third inline" placeholder=" Identificación" id = "idSignUpInput-spanish" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                    <input type = "text" class = "index-registration-input third inline" placeholder = " Nombre" class = "firstName" id = "first_name-spanish" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                    <input type = "text" class = "index-registration-input third inline" placeholder = " Apellido" class = "lastName" id = "last_name-spanish" pattern = "\S+.*" autocomplete = "off" required> &nbsp;
                    <p id = "alertedIDdiv-spanish" style = "display: none !important;"> - </p>
                    <br>
                    <h6 class = "registration-instructions-text"><strong><u> ¿Eres estudiante en Las Positas College? </strong></u></h6>
                    <ul class = "new-member-options-list">
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "studentStatus-spanish" value = "yes" class = "new-member-option inline">
                            <label for = "yes-student-option"  class = "admin-option-label inline"> Si </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "studentStatus-spanish" value = "no" class = "new-member-option inline">
                            <label for = "no-student-option"  class = "admin-option-label inlin"> No </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                    </ul>
                    <br>
                    <h6 class = "registration-instructions-text"><strong><u> ¿Cuantos personas hay en tu hogar? </u></strong></h6>
                    <input type = "number" class = "index-registration-input third inline" id = "children_amount-spanish" placeholder = " Niños (Años 0 - 17)" min = "0" max = "20" required pattern="\S+.*" autocomplete = "off"> &nbsp;
                    <input type = "number" class = "index-registration-input third inline" id = "adults_amount-spanish" placeholder = " Adultos (Años 18 - 64)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                    <input type = "number" class = "index-registration-input third inline" id = "seniors_amount-spanish" placeholder = " Personas mayores (Años 64 +)"  min = "0" max = "20" required pattern = "\S+.*" autocomplete = "off"> &nbsp;
                    <br><br>
                    <h6 class = "registration-instructions-text"><strong><u> Información del contacto </strong></u></h6>
                    <input type = "text" class = "index-registration-input half inline" id = "email_address-spanish" placeholder = " Correo electrónico" autocomplete = "off"> &nbsp;
                    <input type = "text" class = "index-registration-input half inline" id = "phone_number-spanish" placeholder = " Número de teléfono" autocomplete = "off"> &nbsp;
                    <br><br>
                    <h6><strong><u> ¿Cómo se enteró del mercado? </strong></u></h6>
                    <ul class = "new-member-options-list">
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "promotion-spanish" value = "Classroom" class = "new-member-option inline" id = "classroom-option-spanish">
                            <label for = "classroom-option-spanish"  class = "admin-option-label inline"> Aula </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "promotion-spanish" value = "FriendsAndFamily" class = "new-member-option inline" id = "fnf-option-spanish">
                            <label for = "fnf-option-spanish"  class = "admin-option-label inline"> Amigos y familia </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "promotion-spanish" value = "Community" class = "new-member-option inline" id = "community-option-spanish">
                            <label for = "community-option-spanish"  class = "admin-option-label inline"> Comunidad </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                        <li class = "new-member-options-list-item inline">
                            <input type = "radio" name = "promotion-spanish" value = "Other" class = "new-member-option inline" id = "other-option-spanish">
                            <label for = "other-option-spanish"  class = "admin-option-label inline"> Otra </label>
                            <div class = "new-member-check inline"></div>
                        </li>
                    </ul>
                    <br>
                    <button class = "btn btn-submit-new-patron" id = "newPatSubmission-spanish" onclick = "insert_patron_spanish();"> Enviar </button>
                </form>
            </div>
            <!------------------- RETURNING MEMBERS DIVISION ~ English ----------------------->
            <div class = "returning-members" id = "returning-members" style = "display: none">
                <button class = "btn spanish-new-member-page" id = "returning-member" onclick = "spanishPageReturning();"> Spanish </button>
                <br><br>
                <form action = "" method = "POST" id = "login-member-english">
                    <p> <strong> Login with your Market ID </strong></p>
                    <span><i class = "fa fa-user inline" aria-hidden = "true"></i><input type = "number" class = "index-registration-input full-share-icon inline" placeholder = "Market ID" id = "patron-loginid-english" required></label>
                    <br><br>
                    <p> <strong> FORGOT YOUR ID? </strong> Look for you name below!</p>
                    <span><i class = "fa fa-search inline" aria-hidden = "true"></i> <input class = "index-registration-input full-share-icon inline" id = "myInput" type="text" placeholder = " Search.." autocomplete = "off"> </span>
                    <br>
                    <ul class = "list-group" id = "myList"></ul>  
                    <br>
                    <button class = "btn submit-returning-patron-login"> SUBMIT </button>
                </form>    
            </div>
            <!------------------- RETURNING MEMBERS DIVISION ~ Spanish ----------------------->
            <div class = "returning-members" id = "returning-members-spanish" style = "display: none">
                <button class = "btn spanish-new-member-page" id = "returning-member-spanish" onclick = "englishPageReturning();"> English </button>
                <br><br>
                <form action = "" method = "POST" id = "login-member-spanish">
                    <p> <strong> Inicie sesión con su identificación </strong></p>
                    <span><i class = "fa fa-user inline" aria-hidden = "true"></i><input type = "number" class = "index-registration-input full-share-icon inline" placeholder = "  Identificación" id = "patron-loginid-spanish" required></label>
                    <br><br>
                    <p> <strong> ¿Olvidaste tu identificación? </strong> Busca tu nombre ! </p>
                    <span><i class = "fa fa-search inline" aria-hidden = "true"></i> <input class = "index-registration-input full-share-icon inline" id = "myInput-spanish" type = "text" placeholder = " Busca.." autocomplete = "off"> </span>
                    <br>
                    <ul class = "list-group" id = "myList-spanish"></ul>  
                    <br>
                    <button class = "btn submit-returning-patron-login" onclick = "login_patron_spanish();"> Enviar </button>
                </form>
            </div>
            <!------------------- ADMIN LOGIN DIVISION ----------------------->
            <div class = "admin-login" id = "admin-login" style = "display: none">
                <h3>Login as an Admin </h3>
                <br><br>
                <form action = "" method = "POST" id = "admin-login-form">
                    <h6><strong><u>Enter Password Below</u></strong></h6> <br>
                    <input type = "password" placeholder="  Password" class = "change-pw-input full" id = "inputAdminPW" pattern = "\S+.*" required> <br><br>
                    <button class = "btn submit-admin-login" id = "inputAdminBtn"> Submit </button>
                </form>   
            </div>
            <!------------------- VOLUNTEER SIGN UP DIVISION ----------------------->
            <div class = "volunteer-signup" id = "volunteer-signup" style = "display: none">
                <h6><strong><u> Login With Your Email </strong></u></h6>
                <form action = "" method = "POST" id = "vol-login-form">
                    <input type = "text" placeholder = "  Email" class = "index-registration-input full" id = "volunteer-email" pattern = "\S+.*" required> <br><br>
                    <button class = "btn submit-admin-login" id = "volunteer-login-btn"> Submit </button>
                </form>

                <br><br> <hr style = "width: 80% !important; border: 0.7px solid #303030 !important;"> <br><br>
                <h6><strong><u> Request Volunteer Access </strong></u></h6>
                <form action = "" method = "POST" id = "vol-request-form">
                    <input type = "text" placeholder = "  First Name" class = "index-registration-input half inline" id = "first-name-volunteer" pattern = "\S+.*" required> 
                    <input type = "text" placeholder = "  Last Name" class = "index-registration-input half inline" id = "last-name-volunteer" pattern = "\S+.*" required> <br>
                    <input type = "text" placeholder = "  Email" class = "index-registration-input full" id = "volunteer-email-request" pattern = "\S+.*" required> <br><br>
                    <button class = "btn submit-admin-login" id = "volunteer-request-btn"> Submit </button>
                </form>
            </div>
            <!-------------------- NO ACTIVE MARKET MESSAGE --------------->
            <div class = "no-active-market-message" id = "no-active-market-message" style = "display: none">
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
        alertify.set("notifier", "position", "bottom-center"); //set position    
        alertify.set("notifier", "delay", 2.00); //set dellay    

        var adminBtn = document.getElementById("goToAdminBtn");
        var toAdminForm = document.getElementById("goToAdminForm");
        var toAdminInput = document.getElementById("inputAdminBtn");
        var toAdminBtn = document.getElementById("inputAdminPW");
        var idInput = document.getElementById("idSignUpInput");
        var idInput_spanish = document.getElementById("idSignUpInput-spanish");
        var text = document.getElementById("alertedIDdiv");
        var text_spanish = document.getElementById("alertedIDdiv-spanish");
        var ids = new Array();
        $.ajax ({
            type: "POST",
            url: "funcs.php",
            data: {
                message: "loadidsarray"
            },
            dataType: "json",
            success: function(data) {
                ids = data;
            }  
        });
        cleanupRadioBtns();

        $("#vol-request-form").submit(function(e) {
            e.preventDefault();
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
                        alertify.success("Your request has been submitted!");
                        location.replace("index.php");
                    }
                    else if (data == "false") alertify.error("Your email is not a registered volunteer. \r\n You can request a volunteer access below.")
                }  
            });
        });

        $("#vol-login-form").submit(function(e) {
            alertify.set("notifier", "delay", 3.00); //set dellay    

            e.preventDefault();
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "volunteer-login",
                    volunteerEmail: document.getElementById("volunteer-email").value
                },
                success: function(data) {
                    if(data == "true") location.replace("signups.php");
                    else if (data == "false") alertify.error("Your email is not a registered volunteer. \r\n You can request a volunteer access below.");
                    else if (data == "pending") alertify.warning("You're yet to be activated... Can't Login");
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
        
        $("#login-member-english").submit(function(e) {
            e.preventDefault();
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    patronID: document.getElementById("patron-loginid-english").value,
                    message: "patronLogin"
                },
                success: function(data) 
                {
                    console.log(data);
                    if(data == "false") {
                        alertify.error("You are already logged in");
                    } 
                    else if(data == "true") {
                        alertify.success("Welcome ! \r\n Enjoy The Market !").ondismiss = function() {
                            document.getElementById("patron-loginid-english").value = null;
                            document.getElementById("myInput").value = null;
                            responsive_sidebar_item("index-index-sender");
                        }
                    }
                }  
            });
        });


        $("#login-member-spanish").submit(function(e) {
            e.preventDefault();
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    patronID: document.getElementById("patron-loginid-spanish").value,
                    message: "patronLogin"
                },
                success: function(data) 
                {
                    if(data == "false") {
                        alertify.error("ya has iniciado sesión");
                    } 
                    else if(data == "true") {
                        alertify.success("Bienvenidos ! \r\n Disfruta el mercado").ondismiss = function() {
                            document.getElementById("patron-loginid-spanish").value = null;
                            document.getElementById("myInput-spanish").value = null;
                            responsive_sidebar_item("index-index-sender");
                        }
                    }
                }  
            });
        });
        
        idInput.onkeyup = function(event) {
            if (event.target.value.length == 0)  {
                text.innerHTML = "";
                text.style.display = "none";
                idInput.style.borderBottom = "2px solid black";
            }
            else {
                text.style.display = "block";
                if(event.target.value.length != 6)  {
                    text.innerHTML = "ID has to be 6 digits!";
                    idInput.style.borderBottom = "4.5px solid #FFC107";
                }
                else if(event.target.value.length == 6)
                {
                    if(ids.includes(event.target.value)) {
                        text.innerHTML = "ALERT: This ID is already used !";
                        idInput.style.borderBottom = "4.5px solid #DC3545";
                    }
                    else {
                        text.innerHTML = "ID's availability confirmed";
                        idInput.style.borderBottom = "4.5px solid #28A745";
                    }
                }
            }
        }

        idInput_spanish.onkeyup = function(event){
            if (event.target.value.length == 0)  {
                text_spanish.innerHTML = "";
                text_spanish.style.display = "none";
                idInput_spanish.style.borderBottom = "2px solid black";
            }
            else {
                text_spanish.style.display = "block";
                if(event.target.value.length != 6) {
                    text_spanish.innerHTML = "ID has to be 6 digits!";
                    idInput_spanish.style.borderBottom = "4.5px solid $FFC107";
                }
                else 
                {
                    if(ids.includes(event.target.value)) {
                        text_spanish.innerHTML = "ALERT: This ID is already in use!";
                        idInput_spanish.style.borderBottom = "4.5px solid #DC3545";
                    }
                    else {
                        text_spanish.innerHTML = "ID availability confirmed";
                        idInput_spanish.style.borderBottom = "4.5px solid #28A745";
                    }
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
                if (txtValue.toUpperCase().indexOf(filter) > -1) a[i].style.display = "";
                else a[i].style.display = "none";
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

        $("#admin-login-form").submit(function(e){
            e.preventDefault();
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    inputAdminPW:  document.getElementById("inputAdminPW").value,
                    message: "verifyPassword"
                },
                success: function(data) {
                    if(data == "false") alertify.error("Incorrect Password");
                    else if(data == "true") location.replace("admin.php");
                }
            });
        }); 

        $("#submit-new-member-english").submit(function(e) {
            e.preventDefault();
            
            var promotions = document.getElementsByName("promotion-english");
            for(var i = 0 ;i < promotions.length; i++) {
                if(promotions[i].checked) {
                    var selectedPromotionMethod = promotions[i].value;
                }
            }

            var studentStatus = document.getElementsByName("studentStatus-english");
            for(var i = 0 ;i < studentStatus.length; i++) {
                if(studentStatus[i].checked) {
                    var studentStatusCheck = studentStatus[i].value;
                }
            }

            if(!ids.includes(document.getElementById("idSignUpInput").value)) {
                $.ajax ({
                    type: "POST",
                    url: "funcs.php",
                    data: {
                        patron_id: document.getElementById("idSignUpInput").value,
                        first_name: document.getElementById("first_name").value,
                        last_name: document.getElementById("last_name").value,
                        studentStatus: studentStatusCheck,
                        children_amount: document.getElementById("children_amount").value,
                        adults_amount: document.getElementById("adults_amount").value,
                        seniors_amount: document.getElementById("seniors_amount").value,
                        email_address: document.getElementById("email_address").value,
                        phone_number: document.getElementById("phone_number").value,
                        promotion: selectedPromotionMethod,
                        message: "insertNewPats"
                    },
                    success: function(data) {
                        if(data == "true"){
                            alertify.success("Welcome! Enjoy The Market").ondismiss = function() {
                                cleanupInputs();
                                responsive_sidebar_item("index-index-sender");
                            }
                        }
                        else if(data = "shortid") alertify.warning("ID is too short. \r\n must be 6 digits");
                        else if(data == "longid") alertify.warning("ID is too long. \r\n must be 6 digits");
                        else alertify.error("Something went wrong");
                    }
                });
            }
            else  alertify.error("This ID is already used!");
        });
            

        $("#submit-new-member-spanish").submit(function(e) {
            e.preventDefault();
            var promotions = document.getElementsByName("promotion-spanish");
            for(var i = 0 ;i < promotions.length; i++) {
                if(promotions[i].checked) {
                    var selectedPromotionMethod = promotions[i].value;
                }
            }

            var studentStatus = document.getElementsByName("studentStatus-spanish");
            for(var i = 0 ;i < studentStatus.length; i++) {
                if(studentStatus[i].checked) {
                    var studentStatusCheck = studentStatus[i].value;
                }
            }

            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    patron_id: document.getElementById("idSignUpInput-spanish").value,
                    first_name: document.getElementById("first_name-spanish").value,
                    last_name: document.getElementById("last_name-spanish").value,
                    studentStatus: studentStatusCheck,
                    children_amount: document.getElementById("children_amount-spanish").value,
                    adults_amount: document.getElementById("adults_amount-spanish").value,
                    seniors_amount: document.getElementById("seniors_amount-spanish").value,
                    email_address: document.getElementById("email_address-spanish").value,
                    phone_number: document.getElementById("phone_number-spanish").value,
                    promotion: selectedPromotionMethod,
                    message: "insertNewPats"
                },
                success: function(data) {
                    if(data == "true"){
                        alertify.success("Bienvenidos ! \r\n Disfruta el mercado").ondismiss = function() {
                            cleanupInputs();
                            responsive_sidebar_item("index-index-sender");
                        }
                    }
                    else if(data = "shortid") alertify.warning("La identificación es demasiado corta. Debe tener 6 dígitos.");
                    else if(data == "longid") alertify.warning("La identificación es demasiado larga. Debe tener 6 dígitos.");
                    else alertify.error("Algo salió mal");
                }
            });
        });

        function cleanupInputs() {
            document.getElementById("idSignUpInput").value = null;
            document.getElementById("idSignUpInput").style.borderBottom = "2px solid black";
            document.getElementById("first_name").value = null;
            document.getElementById("last_name").value = null;
            document.getElementById("children_amount").value = null;
            document.getElementById("adults_amount").value = null;
            document.getElementById("seniors_amount").value = null;
            document.getElementById("email_address").value = null;
            document.getElementById("phone_number").value = null;

            document.getElementById("idSignUpInput-spanish").value = null;
            document.getElementById("idSignUpInput-spanish").style.borderBottom = "2px solid black";
            document.getElementById("first_name-spanish").value = null;
            document.getElementById("last_name-spanish").value = null;
            document.getElementById("children_amount-spanish").value = null;
            document.getElementById("adults_amount-spanish").value = null;
            document.getElementById("seniors_amount-spanish").value = null;
            document.getElementById("email_address-spanish").value = null;
            document.getElementById("phone_number-spanish").value = null;

            cleanupRadioBtns();

        }

        function cleanupRadioBtns() {
            var promotions = document.getElementsByName("promotion-spanish");
            for(var i = 0 ;i < promotions.length; i++) {
                promotions[i].checked = false;
            }

            var studentStatus = document.getElementsByName("studentStatus-spanish");
            for(var i = 0 ;i < studentStatus.length; i++) {
                studentStatus[i].checked = false;
            }

            var promotions = document.getElementsByName("promotion-english");
            for(var i = 0 ;i < promotions.length; i++) {
                promotions[i].checked = false;
            }

            var studentStatus = document.getElementsByName("studentStatus-english");
            for(var i = 0 ;i < studentStatus.length; i++) {
                studentStatus[i].checked = false;
            }
        }
        
    </script>
</html>
