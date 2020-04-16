<?php include "connDB.php"; ?>

<?php

    $c = connDB();
    $d = 20200416;
    
    $sql = "SELECT passwords FROM AdminPW";
    $s = $c -> prepare ($sql);
    $s -> execute();
    $row = $s -> fetch(PDO::FETCH_ASSOC);
    $oldpw = $row['passwords'];
    $hashpw = md5($oldpw, FALSE); //32character hexa hash
    $sql2 = "UPDATE AdminPW SET passwords = '".$hashpw."'";
    $s2 = $c -> prepare($sql2);
    $s2 -> execute();

    echo $oldpw."\n";
    echo $hashpw."\n";
?>