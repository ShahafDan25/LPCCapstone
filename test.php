<?php
    $conn = connDB();
    $d = 20200401;
    $sql_times = "SELECT starttime, closetime FROM Markets WHERE idByDate = ".$d;
    $stmt_times = $conn -> prepare($sql_times);
    $stmt_times -> execute();
    $times = $stmt_times -> fetch(PDO::FETCH_ASSOC);
    $st = $times['starttime']; //market opening time
    $ct = $times['closetime']; //market closing time

    $sti = intval($st); //calculation purposes
    $interval = $sti + (10 - ($sti%10)); //formula just to get the first interval
    $sql_amount_a = "SELECT COUNT('Patron_patID') FROM MarketLogins WHERE time_stamp < ".($interval).";";
    $stmt_amount_a = $conn -> query($sql_amount_a);
    //$stmt_amount_a -> execute();
    $first_amount = $stmt_amount_a -> fetchColumn();
    $chart_data = "{TIME:'".$sti."',AMOUNT:".$first_amount[0]."}";
    if($interval % 100 == 60) {$interval += 40;} // go to the next hour
    //now number of rep repsents the number of 5 minute inetrvals from the imte the market was openeed, to the time it was closed
    while(($interval + 10) < intval($ct))
    {
        //one condition for it to work:
        if($interval % 100 == 60) {$interval += 40;} // go to the next hour
        $interval_b = $interval + 10; // follow up build up

        $sql_i = "SELECT COUNT('Patrons_patID') FROM MarketLogins WHERE time_stamp < ".$interval_b." AND time_stamp >= ".$interval.";"; 
        $stmt_i = $conn -> query($sql_i);
        //$stmt_i -> execute();
        $amount = $stmt_i -> fetchColumn();
        $chart_data .= ", {TIME:'".$interval."',AMOUNT:".$amount."}";
        $interval = $interval_b;
        $interval_b += 10;
    }
    //add the last data piece
    $sql_i_b = "SELECT COUNT('Patron_patID') FROM MarketLogins WHERE time_stamp >= ".$interval.";"; 
    $stmt_i_b= $conn -> query($sql_i_b);
    //$stmt_i_b -> execute();
    $amount = $stmt_i_b -> fetchColumn();
    $chart_data .= ", {TIME:'".$interval."',AMOUNT:".$amount."}";

    echo $chart_data."\n\n";

    //functions:
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
?>