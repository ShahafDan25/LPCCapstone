<?php
    $servername = "localhost";
    $username = "root";
    $password = "MMB3189@A";

    //CREATE A CONNECTION
    try 
    {
        $conn = new PDO("mysql:host=$servername;dbname=TheMarket", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // set the PDO error mode to exception
    
        echo "Connected successfully";
    }
    
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
?>