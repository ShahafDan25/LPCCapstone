<?php
    // $servername = "localhost";
    //$conn; //variable declaration - am I allowed to do this in PHP?
    //connectDB();

    function connectDB()
    {
        $username = "root";
        $password = "MMB3189@A";
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306;socket=/tmp/mysql.sock';
        
        //try and catch block to connect to PMySQL
        try{
            $conn = new PDO($dsn, $username, $password);
        }
        catch (PDOException $e)
        {
            echo 'Connection Failed: ' . $e -> getMessage();
        }
        //dont forget to close connectio later!
        echo 'connectDB() Completed\n';
        //might need to transfer to html page? should I make that a php file?
    }

    function insertPat(/*$f, $l, $ss, $ca, $aa, $sa, $ea, $pn, $pm*/)
    {
        $username = "root";
        $password = "MMB3189@A";
        $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306;socket=/tmp/mysql.sock';
        
        //try and catch block to connect to PMySQL
        try{
            $conn = new PDO($dsn, $username, $password);
        }
        catch (PDOException $e)
        {
            echo 'Connection Failed: ' . $e -> getMessage();
        }
        //dont forget to close connectio later!
        echo 'connectDB() Completed \n';
        //might need to transfer to html page? should I make that a php file?
        
        $first_name = "Final"; //filter_input(INPUT_POST, 'first_name');
        $last_name = "Test";
        $student_status = True;
        $children_amount = 3;
        $adults_amount = 5;
        $seniors_amount = 0;
        $email_address = "some@email.com";
        $phone_number = NULL;
        $promotion_method = 'Classroom';
        //sql insert new patron code

        $sql  = "INSERT INTO Patrons (FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount, PromotionMethod) VALUES 
        ('".$first_name."', '".$last_name."', '".($student_status?1:0)."', '".((int)$children_amount)."', '".((int)$adults_amount)."', '".((int)$seniors_amount)."', '".$pomotion_method."')";
        // just to note: we use the period sign (.) to concatenate in php!!!
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql update query
        
        
        echo 'insertPat() Completed\n';
        
    }
    
?>