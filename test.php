<?php

    $c = connDB(); //set connection
    $sql = "SELECT starttime, closetime FROM Markets WHERE idByDate = 20200618;";
    $s = $c -> prepare($sql);
    $s -> execute();
    $r = $s -> fetch(PDO::FETCH_ASSOC);
    $c = null; //close connection


    $starttime = substr($r['starttime'],0,strlen($r['starttime'])-2).":".substr($r['starttime'],strlen($r['starttime'])-2,2).":00";
    $closetime = substr($r['closetime'],0,strlen($r['closetime'])-2).":".substr($r['closetime'],strlen($r['closetime'])-2,2).":00";

    echo strlen($r['starttime']);
    echo "-----------------\n";
    echo $r['starttime']."\t\t".$r['closetime']."\n";
    echo $starttime."\t\t".$closetime."\n";


    function connDB(){
        $username = "root";
        $password = "MMB3189@A";
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306socket=/tmp/mysql.sock';
        try {$conn = new PDO($dsn, $username, $password);}
        catch (PDOException $e) {echo 'Connection Failed: ' . $e -> getMessage();}
        return $conn;
    }
?>