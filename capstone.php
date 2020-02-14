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

    populate_dropdown($conn); //call the drop down populate function as soon as the page loads
    // echo "BEGINNING"; //used for debuggin purposes
   // var_dump($_POST); // we use var dump as console.log
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

    if($_POST['message'] == 'getPassword')
    {
        
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
        ChildrenAmount, AdultsAmount, SeniorsAmount, EmailAdd, PhoneNubmerPromotionMethod)
        VALUES ('".$first_name."', '".$last_name."', '".($student_status?1:0)."', 
        '".((int)$children_amount)."', '".((int)$adults_amount)."', '".((int)$seniors_amount)."', 
        '".$email_address."', '".$phone_number."', '".$promotion_method."')";


        // just to note: we use the period sign (.) to concatenate in php!!!
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql update query
        /// NEXT STEP IS TO CLOSE CONNECTION - BUT WHERE?
    }
    
    function populate_dropdown($conn)
    {
        $all_options = "";
        $sql = "SELECT FirstName, LastNAme FROM Patrons";
        $stmt = $pdo->query($sql);
        while ($row = $stmt->fetch()) {
            $all_options += "<option value='".$row['FirstName'].'" "'.$row['LastName']."'>".$row['FirstName']." ".$row['LastNAme']."</option><br>";
        }
        return $all_options; //return the final string to echo on the html page
    }
?>