<?php session_start(); include "funcs.php"; ?>
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
            <div id = "marketid-container"></div>
            <br>
            <div class = "report-btn-options-container" id = "report-btn-options-container" style = "display: none;">
                <button class = "btn report-option-btn inline op8" onclick = "pdfReport();"><i class="fa fa-file-text-o" aria-hidden="true"></i></button>
                <button class = "btn report-option-btn inline op2" onclick = "showMe('report-table-box-id');" id = "report-table-sender"><i class="fa fa-table" aria-hidden="true"></i></button>
                <button class = "btn report-option-btn inline op3" onclick = "showMe('attendance-chart');" id = "att-graph-sender"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
                <button class = "btn report-option-btn inline op1" onclick = "showMe('promGraph');" id = "prom-graph-sender"><i class="fa fa-bar-chart" aria-hidden="true"></i></button>
                <button class = "btn report-option-btn inline op7" onclick = "showMe('retvsnew');" id = "noobies-graph-sender"><i class="fa fa-pie-chart" aria-hidden="true"></i></button>
                <hr style = "color: #303030 !important; border: 0.5px solid #303030 !important;">
            </div>
            <br>
            <!-- Table: Patrons in that specific market -->
            <h3 style = "display: none;" id = "report-table-box-id-title" > Attendees </h3>
            <div id = "report-table-box-id" style = "display: none; margin-right: 3% !important; margin-left: 3% !important;"></div>

            <h3 style = "display: none;" id = "attendance-chart-title"> Attendance Graph </h3>
            <div id = "attendance-chart" style = "display: none;" class = "report-page-sub-container"></div>

            <h3 style = "display: none;" id = "promGraph-title"> Advertisement and Promotions </h3>
            <div id = "promGraph" style = "display: none;" class = "report-page-sub-container"></div>

            <h3 style = "display: none;" id = "retvsnew-title"> New VS. Returning Patrons </h3>
            <div id = "retvsnew" style = "display: none;"></div>

            <div id = "download-pdf-report-div" style = "text-align: center; display: none;">
                <br><br><br>
                <h3> Download the report ( PDF ) </h3>
                <br>
                <button class = "btn download-pdf-report-btn" onclick = "alert('Report generated succesfully : \r\n report_' + document.getElementById('marketid').value + '.pdf');"> Download </button>
            </div>
            
        </div>
    </body>
    <script type = "text/javascript">

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
                    if(data == "true"){
                        hideAll();
                        document.getElementById("download-pdf-report-div").style.display = "block";
                    } 
                    else alert("A Market must be terminated \r\n to generate a report ...");
                }
            });
        }

        function hideAll() {
            divs = ["report-table-box-id", "attendance-chart", "promGraph", "retvsnew"];
            for(var i = 0; i < divs.length; i++) {
                document.getElementById(divs[i]).style.display = "none";
                document.getElementById(divs[i]).innerHTML = "";
                document.getElementById(divs[i]+"-title").style.display = "none";
            }
        }

        function showMe(x) {
            hideAll();
            document.getElementById("download-pdf-report-div").style.display = "none";
            document.getElementById(x).style.display = "block";
            document.getElementById(x+"-title").style.display = "block";
        }

        function changedMarketId() {
            document.getElementById("report-btn-options-container").style.display = "block";
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "start-market-report-session",
                    date: document.getElementById("marketid").value
                }
            });
        }


        $("#report-table-sender").click(function() {
            $.ajax({
                type: "POST",
                url: "funcs.php", 
                data: {
                    message: "populate-att-table",
                    date: document.getElementById("marketid").value
                },
                success: function(data){
                    $("#report-table-box-id").html(data);
                }
            });
        });

        $("#noobies-graph-sender").click(function() {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "display-noobies-graph",
                    date: document.getElementById("marketid").value
                },
                dataType: "json",
                success: function(info) {
                    Morris.Donut({
                        element: 'retvsnew',
                        data: info,
                        colors:['#994d00','#ffa64d']
                    });
                }
            });
        });

        $("#prom-graph-sender").click(function() {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "display-prom-graph",
                    date: document.getElementById("marketid").value
                },
                dataType: "json",
                success: function(info) {
                    Morris.Bar({
                        element: 'promGraph', 
                        data: info, 
                        xkey: 'METHOD',
                        ykeys: ['AMOUNT'],
                        labels: ['Impact'],
                        hideHover: 'auto',
                        stacked: true,
                        barColors: ['#4DA74D'],
                        barSizeRatio: 0.40,
                        resize: false
                    });
                }
            });
            
        });

        $("#att-graph-sender").click(function() {
            $.ajax({
                type: "POST",
                url: "funcs.php",
                data: {
                    message: "display-att-graph",
                    date: document.getElementById("marketid").value
                },
                dataType: "json",
                success: function(info) {
                    Morris.Line({
                        element : 'attendance-chart', 
                        data:info, 
                        xkey:'TIME',
                        ykeys:['AMOUNT'],
                        labels:['Attendance'],
                        stacked:true
                    });
                }
            });
            
        });
    </script>
</html>