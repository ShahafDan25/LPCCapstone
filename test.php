<?php
    $c = connDB(); //set connection
    $firstnames = ["Diego", "Joe", "Efron", "Adam", "Destiny", "Kaylee", "Brooke", "Minor", "Robert", "William", "Ori", "Danny", "Jesus", "Moses", "Russell", "Sai", "Brandon", "Alisha", "Alice", "Bella", "Christine", "Joseph", "Jose", "Mohammed", "Abdul", "Matthew", "Shaun", "Sean", "Shanw", "Taylor", "Justin", "Kim", "Chloe", "Klay", "Ron", "Ronni", "Chyanne", "Donna", "Chelsea", "Kevin", "Pam", "Jim", "Michael", "Michaela", "Michelle", "David", "Itay", "Joshua", "Josh", "Ahmad", "Moustafa", "Ramon", "Frank", "Sandra", "Junior", "Leah", "Rachel", "Dude", "Tom", "Domminic", "AJ", "CJ", "KJ", "RJ", "TJ", "OJ", "Marry", "Katy", "Katja"];
    $lastnames = ["Arnold", "Smith", "Watson", "Shpillberg", "Goldman", "Griffin", "Abdullah", "Rodrigez", "Smith", "Cole", "Seely", "Campbell", "Montez", "Silva", "Cortez", "Fibbonacci", "Fetuccini", "Jackson", "Kumar", "Kim", "Chen", "Zhou", "Xing", "Xavier", "Javier", "Junior", "Dahan", "Levi", "Cohen", "Hamdi", "Miller", "Milter", "Inberg", "Gottlieb", "Raizes", "Martin", "Garcia", "Thomas", "West", "Hill", "Fox", "Cortez", "Jane", "Bailey", "Ossman", "Perry", "Adams", "Cox", "Stone", "Cook", "Mitchell", "Reed", "Bennet", "Gray", "Sullivan", "Cooper", "Lopez", "Gonalez", "Perez", "Abadi", "Arian", "Brown", "David", "Taylor"];
    $promotions = ["Community", "FriendsAndFamily", "Classroom", "Other"];
    $active = false;
    $sql_active = "SELECT active FROM Markets WHERE idByDate = 20200617;";
    $s_active = $c -> prepare($sql_active);
    $s_active -> execute();
    $r_active = $s_active -> fetch(PDO::FETCH_ASSOC);
    if($r_active['active'] == 1) $active = true;
    while($active) {
        $id = rand(100000,999999);
        $first = $firstnames[rand(0, count($firstnames))];
        $last = $lastnames[rand(0, count($lastnames))];
        $studentStatus = rand(0,1);
        $child = rand(0,5);
        $adult = rand(1,4);
        $senior = rand(0,2);
        $prom = $promotions[rand(0,count($promotions))];

        $nuller = rand(0,3);
        if($nuller == 0) $sql = "INSERT INTO Patrons (FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount, PromotionMethod, patID, firstMarket) VALUES ('".$first."', '".$last."', ".$studentStatus.", ".$child.", ".$adult.", ".$senior.", '".$prom."', ".$id.", 20200617);";
        else if($nuller == 1) $sql = "INSERT INTO Patrons (FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount, EmailAdd, PromotionMethod, patID, firstMarket) VALUES ('".$first."', '".$last."', ".$studentStatus.", ".$child.", ".$adult.", ".$senior.", '".$first.".".$last."@gmail.com"."','".$prom."', ".$id.", 20200617);";
        else if($nuller == 2) $sql = "INSERT INTO Patrons (FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount, PhoneNumber, PromotionMethod, patID, firstMarket) VALUES ('".$first."', '".$last."', ".$studentStatus.", ".$child.", ".$adult.", ".$senior.", '".strval(rand(100,999)).strval(rand(100,999)).strval(rand(1000,9999))."','".$prom."', ".$id.", 20200617);";
        else if($nuller == 3) $sql = "INSERT INTO Patrons VALUES ('".$first."', '".$last."', ".$studentStatus.", ".$child.", ".$adult.", ".$senior.", '".$first.".".$last."@gmail.com"."', '".strval(rand(100,999)).strval(rand(100,999)).strval(rand(1000,9999))."', '".$prom."', ".$id.", 20200617);";

        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);

        $sql = "INSERT INTO MarketLogins VALUES (20200617, ".$id.", NOW());";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);

        echo $first." ".$last." - INSERTED";
        sleep(rand(10,50));
        //check is still active
        $s_active = $c -> prepare($sql_active);
        $s_active -> execute();
        $r_active = $s_active -> fetch(PDO::FETCH_ASSOC);
        if($r_active['active'] == 1) $active = true;
    }


    echo "Market Not Active Anymore!\n---------\n";
    $c = null; //close connetcion
    echo "Connection Closed \n terminating program!";
    function connDB(){
        $username = "root";
        $password = "Sdan3189";
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306socket=/tmp/mysql.sock';
        try {$conn = new PDO($dsn, $username, $password);}
        catch (PDOException $e) {echo 'Connection Failed: ' . $e -> getMessage();}
        return $conn;
    }   
?>