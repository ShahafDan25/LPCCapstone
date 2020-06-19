<?php
    $c = connDB(); //set connection
    $firstnames = ["Diego", "Joe", "Efron", "Adam", "Destiny", "Kaylee", "Brooke", "Minor", "Robert", "William", "Ori", "Danny", "Jesus", "Moses", "Russell", "Sai", "Brandon", "Alisha", "Alice", "Bella", "Christine", "Joseph", "Jose", "Mohammed", "Abdul", "Matthew", "Shaun", "Sean", "Shanw", "Taylor", "Justin", "Kim", "Chloe", "Klay", "Ron", "Ronni", "Chyanne", "Donna", "Chelsea", "Kevin", "Pam", "Jim", "Michael", "Michaela", "Michelle", "David", "Itay", "Joshua", "Josh", "Ahmad", "Moustafa", "Ramon", "Frank", "Sandra", "Junior", "Leah", "Rachel", "Dude", "Tom", "Domminic", "AJ", "CJ", "KJ", "RJ", "TJ", "OJ", "Marry", "Katy", "Katja", "Idan", "Paula", "Soma", "Fabio", "Frumah", "Fatimah", "Namra", "Maham", "Jennifer", "Cheire", "Maud", "Hope", "Izzy", "Matthew", "Elijah", "Moses", "Abrahanm", "Noah", "Trevor", "Austin", "Tyler", "Chris", "Ray", "Chavez", "Isaiah", "Christopher", "Tomer", "Orion", "Cliff", "Jeffery", "Jefra", "Cassandra", "Kelly", "Amit"];
    $lastnames = ["Arnold", "Smith", "Watson", "Shpillberg", "Goldman", "Griffin", "Abdullah", "Rodrigez", "Smith", "Cole", "Seely", "Campbell", "Montez", "Silva", "Cortez", "Fibbonacci", "Fetuccini", "Jackson", "Kumar", "Kim", "Chen", "Zhou", "Xing", "Xavier", "Javier", "Junior", "Dahan", "Levi", "Cohen", "Hamdi", "Miller", "Milter", "Inberg", "Gottlieb", "Raizes", "Martin", "Garcia", "Thomas", "West", "Hill", "Fox", "Cortez", "Jane", "Bailey", "Ossman", "Perry", "Adams", "Cox", "Stone", "Cook", "Mitchell", "Reed", "Bennet", "Gray", "Sullivan", "Cooper", "Lopez", "Gonalez", "Perez", "Abadi", "Arian", "Brown", "David", "Taylor", "Kumar", "Kelly", "Probest", "Kardashian", "Shyan", "West", "Cliff", "Robinson", "Davis", "David", "Martinez","Taylor", "Thompson", "Montez", "Lewiz", "Voisin", "Abe", "Young", "Yang", "Drew", "Xong", "Hill", "Adams", "Bakers", "Mitchell", "Hall", "Nguyen", "Torres", "Scotts", "Wright", "Prince", "Allen", "Roberts", "Bates", "Addington"];
    $promotions = ["Community", "FriendsAndFamily", "Classroom", "Other"];
    $prevs = [];
    $prevnames = [];
    $counter = 0;

    $sql = "SELECT DISTINCT patID, FirstName, LastName FROM Patrons WHERE firstMarket < 20200623";
    $s = $c -> prepare($sql);
    $s -> execute();
    while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
        array_push($prevs, $r['patID']);
        array_push($prevnames, $r['FirstName']." ".$r['LastName']);
    }


    $active = false;
    $sql_active = "SELECT active FROM Markets WHERE idByDate = 20200623;";
    $s_active = $c -> prepare($sql_active);
    $s_active -> execute();
    $r_active = $s_active -> fetch(PDO::FETCH_ASSOC);
    if($r_active['active'] == 1) $active = true;
    while($active) {
        $counter++;

        if(rand(0,99) < 35) {
            $id = rand(100000,999999);
            $sql = "SELECT * FROM Patrons WHERE patID = ".$id.";";
            $s = $c -> prepare($sql);
            $s -> execute();
            if($s -> fetch(PDO::FETCH_ASSOC)){
                echo "PIGEON HOLE PRINCIPLE ERROR WITH ID: \t".$id."\t trying again:";
            }
            else {
                $first = $firstnames[rand(0, count($firstnames)-1)];
                $last = $lastnames[rand(0, count($lastnames)-1)];
                $studentStatus = rand(0,1);
                $child = rand(0,5);
                $adult = rand(1,4);
                $senior = rand(0,2);
                $prom = $promotions[rand(0,count($promotions))];
        
                $nuller = rand(0,3);
                if($nuller == 0) $sql = "INSERT INTO Patrons (FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount, PromotionMethod, patID, firstMarket) VALUES ('".$first."', '".$last."', ".$studentStatus.", ".$child.", ".$adult.", ".$senior.", '".$prom."', ".$id.", 20200623);";
                else if($nuller == 1) $sql = "INSERT INTO Patrons (FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount, EmailAdd, PromotionMethod, patID, firstMarket) VALUES ('".$first."', '".$last."', ".$studentStatus.", ".$child.", ".$adult.", ".$senior.", '".$first.".".$last.strval(rand(1,99))."@gmail.com"."','".$prom."', ".$id.", 20200623);";
                else if($nuller == 2) $sql = "INSERT INTO Patrons (FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount, PhoneNumber, PromotionMethod, patID, firstMarket) VALUES ('".$first."', '".$last."', ".$studentStatus.", ".$child.", ".$adult.", ".$senior.", '".strval(rand(100,999)).strval(rand(100,999)).strval(rand(1000,9999))."','".$prom."', ".$id.", 20200623);";
                else if($nuller == 3) $sql = "INSERT INTO Patrons VALUES ('".$first."', '".$last."', ".$studentStatus.", ".$child.", ".$adult.", ".$senior.", '".$first.".".$last.strval(rand(1,99))."@gmail.com"."', '".strval(rand(100,999)).strval(rand(100,999)).strval(rand(1000,9999))."', '".$prom."', ".$id.", 20200623);";
        
                $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $c -> exec($sql);
        
                login($id);
                echo "INSERTED NEW:\t\t".$counter.")\t   ".$first." ".$last."\t\n";
            }
        }
        else {
            $randindex = rand(0,count($prevs)-1);
            // echo $randindex."\t".$prevs[$randindex];
            login($prevs[$randindex]);
            echo "LOGGED PREVIOUS:\t".$counter.")\t   ".$prevnames[$randindex]."\t\n";
            unset($prevs[$randindex]);
            unset($prevnames[$randindex]);
        }
        
        sleep(rand(20,125));
        
        $s_active = $c -> prepare($sql_active);
        $s_active -> execute();
        $r_active = $s_active -> fetch(PDO::FETCH_ASSOC);
        if($r_active['active'] != 1) $active = false;

        date_default_timezone_set("America/Los_Angeles");
        $time = intval(substr(date("H:i"),0,2).substr(date("H:i"),0,2));
        if($time > 747) {
            $sql = "UPDATE Markets SET active = 2, terminationtime = '".$time."' WHERE idByDate = 20200623";
            $c -> prepare($sql) -> execute();
            $active = false;
        }        
    }

    function connDB(){
        $username = "root";
        $password = "MMB3189@A";
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306socket=/tmp/mysql.sock';
        try {$conn = new PDO($dsn, $username, $password);}
        catch (PDOException $e) {echo 'Connection Failed: ' . $e -> getMessage();}
        return $conn;
    }   

    function login($id) {
        if($id == NULL) return;
        $c = connDB();
        date_default_timezone_set("America/Los_Angeles");
        $time_digits = substr(date("H:i"), 0, 2).substr(date("H:i"), 3, 2);

        $sql = "INSERT INTO MarketLogins VALUES (20200623, ".$id.", '".$time_digits."');";
        $c -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $c -> exec($sql);
    }

    echo "\n\nMarket Not Active Anymore!\n----------------\n";
    $c = null; //close connetcion
    echo "Connection Closed \n terminating program!";
?>