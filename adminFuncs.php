<?php

function connDB() //call to get connection
    {
        $username = "root";
        $password = "MMB3189@A";
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306;socket=/tmp/mysql.sock';
      

        //try and catch block to connect to MySQL, or throw an error
        try {
             $conn = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
             echo 'Connection Failed: ' . $e -> getMessage();
        } // end of try and catch
        return $conn;
    }


    // ======================================================== //
    // ------------- ADMIN PAGE FUNCTIONS ----------------------//
    // ======================================================== //

    function populate_market_dropdown($conn)
    {
        $conn = connDB();
        $sql = "SELECT * FROM Markets";
        $stmt = $conn -> prepare($sql); //create the statment
        $stmt -> execute(); //execute the statement
        $stmt_existness_check = $conn ->prepare($sql);
        $stmt_existness_check -> execute();
        //check if ther are any markets stored in the database
        if(!$stmt_existness_check -> fetch(PDO::FETCH_ASSOC))
        {
            echo '<a class="dropdown-item midbigger" href="#">No Markets to Show</a>';
            return; //return if no markets have been found from the database
        }
        //else statement
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        { //new format: mm / dd / yyyy
            echo '&nbsp;<a class = "dropdown-item midbigger" href="#">'.substr($row['idByDate'],4,2).' / '.substr($row['idByDate'],6,2).' / '.substr($row['idByDate'],0,4).'</a><br>';
        }
        return; //justin casey
    }

    if($_POST['message'] == 'submitNewMarket')
    {
        $date_format_d = $_POST['new_market_date'];
        $date_format_int = substr($_POST['new_market_date'],0,4).substr($_POST['new_market_date'],5,2).substr($_POST['new_market_date'],8,2);
        //var_dump($date_format_int);
        newMarket(connDB(), $date_format_int);
        //header("Location: admin.php"); //redirect to the main index.php page
    }

    if($_POST['message'] == 'invokeOrReport')
    {
        $date = $_POST['marketDate'];
        $date_format = substr($date,0,4).substr($date,5,2).substr($date,8,2);
        if($_POST['invokeOrReport'] == "invoke")//invoke
        {
            $sql = "UPDATE Markets SET active = 1 WHERE idByDate = ".$date_format; //we use the period dot to concatinate
            $conn = connDB(); //justin casey
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            var_dump($date_format);
            //$sql = "UPDATE Markets SET active = 0 WHERE idByDate NOT = ".$date; //we use the period dot to concatinate
            //$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$conn -> exec($sql);
        }
        if($_POST['invokeOrReport'] == "report")//report
        {
            generate_report($conn);
        }
        header("Location: admin.php");
    }

    function generate_report($conn)
    {
        $conn; //connection is already passed // Do something with it
    // CODE IS YET TO COME;
        return;
    }
    function newMarket($conn, $date)
    {
        $sql_existence = "SELECT * FROM Markets WEHERE idByDate = ".$date;
        $stmt = $conn -> prepare($sql_existence); //create the statment
        $stmt -> execute(); //execute the statement
        if($stmt -> fetch(PDO::FETCH_ASSOC))
        {
            echo '<script> alert("Sorry, This market already exists in the database. Only one market per day."); </script>';
            return; //this market already exists in the data base
        }
        $sql = "INSERT INTO Markets (idByDate, active) VALUES (".$date.", 0);"; //0 = not active, 1 = active (tiny int sserving as boolean)
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql update query
        //header("Location: admin.php"); //redirect to the main index.php page
    }
    //IDEA: ADD LATER CHANGE PASSWORD OPTION
?>