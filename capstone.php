<?php
    // $servername = "localhost"; //we should use teh IP address 127.0.0.1
    //$conn; //variable declaration - am I allowed to do this in PHP?
    //connectDB();
    $username = "root";
    $password = "MMB3189@A";
    $dsn = 'mysql:dbname=TheMarket;host=127.0.0.1;port=3306;socket=/tmp/mysql.sock';
      

    //try and catch block to connect to MySQL, or throw an error
    try {
        $conn = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo 'Connection Failed: ' . $e -> getMessage();
    } // end of try and catch

    echo "BEGINNING";
    var_dump($_POST);
    //DATA BASE ACTIOTS POST METHODS
    if($_POST['message'] == 'insertNewPats')
    {
        echo "HELLO WORLD OF SUCCESS!";
        insertPat($conn);
    }

    /* ***************************************************************** */
    // -------------------------- FUNCTION ACTION -----------------------//
    /* ***************************************************************** */
    function insertPat($conn)
    {
        
        //dont forget to close connectio later!
        echo 'insertPat Check';
        //might need to transfer to html page? should I make that a php file?
        var_dump($conn);
        $first_name = "Hope";//filter_input(INPUT_POST, 'first_name');
        $last_name = "Fully";//filter_input(INPUT_POST, 'last_name'); //retrieve information from HTML
        $student_status = True;
        $children_amount = 1;
        $adults_amount = 2;
        $seniors_amount = 3;
        $email_address = "An@email.com";
        $phone_number = NULL;
        $promotion_method = "Testing";
        //sql insert new patron code

        $sql  = "INSERT INTO Patrons (FirstName, LastName, StudentStatus, ChildrenAmount, AdultsAmount, SeniorsAmount, PromotionMethod) VALUES 
        ('".$first_name."', '".$last_name."', '".($student_status?1:0)."', '".((int)$children_amount)."', '".((int)$adults_amount)."', '".((int)$seniors_amount)."', '".$pomotion_method."')";
        // just to note: we use the period sign (.) to concatenate in php!!!
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql update query
        
        
        echo 'insertPat() Completed\n';
        
    }
    
?>