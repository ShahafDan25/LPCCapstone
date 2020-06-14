<?php


function connDB()
{
    $username = "root";
    $password = "Sdan3189";
    // $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306;socket=/tmp/mysql.sock';  //connection link
    $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306socket=/tmp/mysql.sock';
    try {$conn = new PDO($dsn, $username, $password);}
    catch (PDOException $e) {echo 'Connection Failed: ' . $e -> getMessage();}
    return $conn;
}


?>