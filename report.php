<?php
    session_start();
    include "funcs.php";
    $conn = connDB(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Market - Report </title>
        <link rel="icon" href="otherFiles/pics/lpcLogo2.png"/>
        <link rel="shortcut icon" href="otherFiles/pics/lpcLogo2.png"/>
                
        <!-- CSS HARDCODE FILE LINK -->
        <link href='capstone.css?version=1' rel='stylesheet'></link>

        <!-- Bootstrap for CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">      

        <!-- Bootstrap for JQuery, AJAX, JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- JAVASCRIPT PAGE CONNECTION-->
        <script src="captsone.js"></script>

        <!-- FONTAWESOME ICON --> 
        <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
        <script src = "https://use.fontawesome.com/9f04ec4af7.js"></script>

        <!-- MORRIS.JS (for graphing utilities from PHP data) LINKS -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
 

        <style>
            .inline{display: inline-block !important;}
            .w25{width: 30% !important;}
            .w55{width: 60% !important;}
        </style>
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
            <!-- <form action = "funcs.php" method = "post">
                <input type = "hidden" value = "pdfreport" name = "message">
                <button  class = "inline btn btn-success sideBtn pull-right"> Generate Report [ PDF ] </button>
            </form> -->
            <h2> MARKET REPORT </h2>
            
            <select class = 'select-markets' name = 'marketid' id = "marketid">
                <option value = 'none' selected disabled hidden>Choose a Market </option>
                <?php echo populateMarketsDropDown(); ?>
            </select>
            <br>
            <!-- Table: Patrons in that specific market -->
            <div class = "report-container" id = "report-container" hidden = "true">
                <div class = "report_box_class" id = "report-table-box-id"><br></div>
                <br><br>
                <h3> Attendance Graph </h3>
                <div class = "report_box_class">
                    <div id = "chart"></div>
                </div>
                <br><br>
                <span>
                    <div class = "inline w55">
                        <h3> Advertisement and Promotions </h3>
                        <div class = "report_box_class">
                            <div id = "promGraph"></div>
                        </div>
                    </div>
                    <div class = "inline w25">
                        <h3> New VS. Returning Patrons </h3>
                        <div class = "report_box_class">
                            <div id = "retvsnew"></div>
                        </div>
                    </div>
                </span>
            </div>
            <br><br>
            <br><br>
        </div>
    </body>
    <script>
        $(document).on('change', '#marketid', function() {
            //populate table
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {date: document.getElementById("marketid").value, message: "start-market-report-session"},
                success: function(data) {
                    $("#report-table-box-id").html(data);
                    document.getElementById("report-container").hidden = false;
                }
            });

            //populate attendance line graph
            $.ajax ({
                type: "POST",
                url: "funcs.php",
                data: {date: document.getElementById("marketid").value, message: "populate-attendance-graph"},
                success: function(info) {
                    console.log(info);
                    console.log(typeof(info));
                    document.getElementById('chart').innerHTML = "";
                    Morris.Line({
                        element : 'chart', 
                        data: [JSON.parse([info])], 
                        xkey:'TIME',
                        ykeys:['AMOUNT'],
                        labels:['Attendance'],
                        hideHover:'auto',
                        stacked:true
                    });
                }
            });

            //populate promotiom method bar graph


            //populate first-marketers donut graph

        });

        // function populateGraphs() {
        //     $a = getAttData($_SESSION['reportid']);
        //     console.log(<?php echo $_SESSION['reportid']; ?>);
        //     Morris.Line({
        //         element : 'chart', 
        //         data:[<?php echo "h" // getAttData($_SESSION['reportid']); ?>], 
        //         xkey:'TIME',
        //         ykeys:['AMOUNT'],
        //         labels:['Attendance'],
        //         hideHover:'auto',
        //         stacked:true
        //     });

        //     // promotion method comparison graph (bars)
        //     Morris.Bar({
        //         element: 'promGraph', 
        //         data:[<?php echo "h" // promGraphData($_SESSION['reportid']);?>], 
        //         xkey:'METHOD',
        //         ykeys:['AMOUNT'],
        //         labels:['Impact'],
        //         hideHover:'auto',
        //         stacked:true,
        //         barColors: ['#4DA74D'],
        //         barSizeRatio:0.40,
        //         resize:false
        //     });

        //     //return vs new patrons graph (donuts (pi chart))
        //     Morris.Donut({
        //         element: 'retvsnew',
        //         data: [<?php echo "h" //getRetVSNew($_SESSION['reportid']); ?>],
        //         colors:['#994d00','#ffa64d']
        //     });
        // }
    </script>
</html>