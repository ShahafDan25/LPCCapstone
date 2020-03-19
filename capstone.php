<?php
    
    
    $conn = connDB(); // get the connection string to the Database

    populate_dropdown($conn); //call the drop down populate function as soon as the page loads
 
    //DATA BASE ACTIOTS POST METHODS
    if($_POST['message'] == 'insertNewPats')
    {
        insertPat($conn, $_POST["first_name"], 
                        $_POST["last_name"],
                        $_POST["student?"],
                        $_POST["children_amount"], 
                        $_POST["adults_amount"],
                        $_POST["seniors_amount"], 
                        $_POST["email_address"], 
                        $_POST["phone_number"], 
                        $_POST["promotion"]);
    }





    /* ***************************************************************** */
    // -------------------------- FUNCTION ACTION -----------------------//
    /* ***************************************************************** */
    function insertPat($conn, $f, $l, $ss, $ca, $aa, $sa, $ea, $pn, $pm)
    {
        
        //dont forget to close connection later!
        //might need to transfer to html page? should I make that a php file?
        $first_name = $f;//filter_input(INPUT_POST, 'first_name');
        $last_name = $l;//filter_input(INPUT_POST, 'last_name'); //retrieve information from HTML
        
        if($ss == "yes") $student_status = TRUE;
        else $student_status = FALSE;

        $children_amount = $ca;
        $adults_amount = $aa;
        $seniors_amount = $sa;

        $email_address = $ea;
        $phone_number = $pn;

        $promotion_method = $pm;

        //sql insert new patron code:
        $sql  = "INSERT INTO Patrons (FirstName, LastName, StudentStatus,
        ChildrenAmount, AdultsAmount, SeniorsAmount, EmailAdd, PhoneNumber, PromotionMethod)
        VALUES ('".$first_name."', '".$last_name."', '".($student_status?1:0)."', 
        '".((int)$children_amount)."', '".((int)$adults_amount)."', '".((int)$seniors_amount)."', 
        '".$email_address."', '".$phone_number."', '".$promotion_method."')";


        // just to note: we use the period sign (.) to concatenate in php!!!
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql update query
        /// NEXT STEP IS TO CLOSE CONNECTION - BUT WHERE?
        header("Location: index.php"); //redirect to the main index.php page
    }

    function getPassword($conn)
    {
        $sql = "SELECT passwords FROM AdminPW";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        {
            $pwHidden = $row['passwords'];
        }
        return $pwHidden;
    }

    function populate_dropdown($conn)
    {
        $all_options = "";
        $sql = "SELECT DISTINCT FirstName, LastName FROM Patrons";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute(); ///execute the query to the database
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        { //concatinate to huge string to be passed //concatinaton in php is done with '.='
            $all_options .= "<a value = '".$row['FirstName']."".$row['LastName']."'>".$row['FirstName']." ".$row['LastName']."</a>";
        }
        return $all_options; //return the final string to echo on the html page
    }
     
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

    // ======================================================== //
    // ------------- ADMIN PAGE FUNCTIONS ----------------------//
    // ======================================================== //

    function populate_market_dropdown($conn)
    {
        $sql = "SELECT * FROM Markets";
        $stmt = $conn -> prepare($sql); //create the statment
        $stmt -> execute(); //execute the statement
        $stmt_existness_check = $conn ->prepare($sql);
        $stmt_existness_check -> execute();
        //check if ther are any markets stored in the database
        if(!$stmt_existness_check -> fetch(PDO::FETCH_ASSOC))
        {
            echo '<a class="dropdown-item" href="#">No Markets Have Been Found</a>';
            return; //return if no markets have been found from the database
        }

        // while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        // {
        //     $pwHidden = $row['passwords'];
        // }
        return; //justin casey
    }




?>
