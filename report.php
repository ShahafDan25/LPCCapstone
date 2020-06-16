<!DOCTYPE html>
<html>
    <head>
        <title> Market - Report </title>
        <link rel="icon" href="otherFiles/pics/lpcLogo2.png"/>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
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

        <!-- MORRIS.JS (for graphing utilities from PHP data) LINKS -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    </head>

    <!-- ---------------------------------------------------------------- -->
    <body class = "report-page-body">
        <header class = "nav-bar">
            <a href = "admin.php" class = "nav-bar-option responsive">Admin</a>
            <a href = "index.php" class = "nav-bar-option responsive">Market</a>
            <a href = "inventory.php" class = "nav-bar-option responsive">Inventory</a>
            <a href = "volunteers.php" class = "nav-bar-option responsive">Volunteers</a>
            <h5 class = "nav-bar-title responsive"> The Market - Report </h5>
        </header>
        <div class = "page-container">
            <br>
            <div id = "marketid-container"></div>
            
            <br>
            <div class = "report-btn-options-container" id = "report-btn-options-container" style = "display: none;">
                <button class = "btn report-option-btn inline op8" onclick = "pdfReport();"><i class="fa fa-file-text-o" aria-hidden="true"></i></button>
                <button class = "btn report-option-btn inline op2" onclick = "showMe('report-table-graph');"><i class="fa fa-table" aria-hidden="true"></i></button>
                <button class = "btn report-option-btn inline op3" onclick = "showMe('report-attendance-graph');"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
                <button class = "btn report-option-btn inline op1" onclick = "showMe('report-promotion-graph');"><i class="fa fa-bar-chart" aria-hidden="true"></i></button>
                <button class = "btn report-option-btn inline op7" onclick = "showMe('report-noobies-graph');"><i class="fa fa-pie-chart" aria-hidden="true"></i></button>
            </div>
            <br>
            <!-- Table: Patrons in that specific market -->
            <div class = "page-sub-container" id = "report-table-graph" style = "display: none">
                <h3> Attendees </h3>
                <div id = "report-table-box-id"></div>
            </div>
            <div class = "page-sub-container" id = "report-attendance-graph" style = "display: none">
                <h3> Attendance Graph </h3>
                <div id = "chart"></div>
            </div>    
            <div class = "page-sub-container" id = "report-promotion-graph" style = "display: none">
                <h3> Advertisement and Promotions </h3>
                <div id = "promGraph"></div>
            </div>    
            <div class = "page-sub-container" id = "report-noobies-graph" style = "display: none">
                <h3> New VS. Returning Patrons </h3>
                <div id = "retvsnew"></div>
            </div>
        </div>
        <div id = "scripts1"></div>
        <div id = "scripts2"></div>
        <div id = "scripts3"></div>
    </body>
    <script>
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

        function pdfReport() 
        {
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    date: document.getElementById("marketid").value, 
                    message: "generate-pdf-report"
                },
                success: function(data) {
                    if(data == "true") alert("Report generated succesfully : \r\n report_" + document.getElementById("marketid").value + ".pdf");
                    else alert("A Market must be terminated \r\n to generate a report ...");
                }
            });
        }

        function showMe(x) {
            divs = ["report-table-graph", "report-attendance-graph", "report-promotion-graph", "report-noobies-graph"];
            for(var i = 0; i < divs.length; i++) {
                document.getElementById(divs[i]).style.display = "none";
            }
            document.getElementById(x).style.display = "block";
        }

        // $("#marketid").change(function() {
        function showbtns() {
            document.getElementById("report-btn-options-container").style.display = "block";

            //populate the table of attendees
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    date: document.getElementById("marketid").value, 
                    message: "start-market-report-session"
                },
                success: function(data) {
                    $("#report-table-box-id").html(data);
                }
            });

            //populate attendance line graph
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    date: document.getElementById("marketid").value, 
                    message: "populate-attendance-graph"
                },
                success: function(info) {
                    console.log(info);
                    document.getElementById("scripts1").innerHTML = "";
                    document.getElementById("chart").innerHTML = "";
                    $("#scripts1").html(info);
                }
            });

            //populate promotiom method bar graph
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {
                    date: document.getElementById("marketid").value, 
                    message: "populate-promotion-graph"
                },
                success: function(info) {
                    document.getElementById("scripts2").innerHTML = "";
                    document.getElementById("promGraph").innerHTML = "";
                    $("#scripts2").html(info);
                }
            });

            //populate first-marketers donut graph
            // $.ajax ({
            //     type: "POST",
            //     url: "funcs.php",
            //     data: {
            //         date: document.getElementById("marketid").value, 
            //         message: "populate-newones-graph"
            //     },
            //     success: function(info) {
            //         document.getElementById("scripts3").innerHTML = "";
            //         document.getElementById("retvsnew").innerHTML = "";
            //         $("#scripts3").html(info);
            //     }
            // });
        };
    </script>
</html>