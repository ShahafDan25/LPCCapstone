<?php
    // $servername = "localhost";
    function connectDB()
    {
        $username = "root";
        $password = "MMB3189@A";
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306;socket=/tmp/mysql.sock';
        
        
        try{
            $dbh = new PDO($dsn, $username, $password);
        }
        catch (PDOException $e)
        {
            echo 'Connection Failed: ' . $e -> getMessage();
        }
        //dont forget to close connectio later!

        //might need to transfer to html page? should I make that a php file?
    }

    function insertPat($f, $l, $ss, $ca, $aa, $sa, $ea, $pn, $pm)
    {
        $first_name = $f;
        $last_name = $l;
        $student_status = $ss;
        $children_amount = $ca;
        $adults_amount = $aa;
        $seniors_amount = $sa;
        $email_address = $ea;
        $phone_number = $pn;
        $promotion_method = $pm;
        //sql insert new patron code

        $sql  = "INSERT INTO Patrons ('FirstName', 'LastName', 'StudentStatus', 'ChildrenAmount', 'AdultsAmount', 'SeniorAmount', EmailAdd', 'PhoneNumber', 'PromotionMethod') VALUE ("
        . $first_name. $lastname. $student_status. $children_amount. $adults_amount. $seniors_amount. $email_address. $phone_number. $promotion_method. ");";
        // just to note: we use the period sign (.) to concatenate in php!!!

        
    }
    
?>