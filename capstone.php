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
                        $_POST["promotion"],
                        $_POST["patron_id"]);
    }

    if($_POST['message'] == 'patronLogin')
    {
        //1. connect
        //2. verify that the id does not already exist in the database
        //3. if verified: insert to M:M mid relationship table
        $conn = connDB();
        
        if(!verifyExistence($conn, $_POST['patronID']))
        {
            echo '<script>alert ("Your ID was not found")</script>';
            echo '<script>location.replace("index.php")</script>';
        }
        else
        {
            // id verified!
            // a. retrive current market's date
            // b. insert the patron's id to the table by calling a function
            // c. change back to index.php
            $sql = "SELECT idByDate FROM Markets WHERE active = 1";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute(); ///execute the query to the database
            $row = $stmt->fetch(PDO::FETCH_ASSOC); //becasue we are onlu fetching one line
            loginPat($conn, $row['idByDate'], $_POST['patronID']);
            echo '<script>location.replace("index.php");</script>';

        }
    }





    /* ***************************************************************** */
    // -------------------------- FUNCTION ACTION -----------------------//
    /* ***************************************************************** */
    function insertPat($conn, $f, $l, $ss, $ca, $aa, $sa, $ea, $pn, $pm, $id)
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
        ChildrenAmount, AdultsAmount, SeniorsAmount, EmailAdd, PhoneNumber, PromotionMethod, patID)
        VALUES ('".$first_name."', '".$last_name."', '".($student_status?1:0)."', 
        '".((int)$children_amount)."', '".((int)$adults_amount)."', '".((int)$seniors_amount)."', 
        '".$email_address."', '".$phone_number."', '".$promotion_method."', ".$id.")";


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
        $sql = "SELECT DISTINCT FirstName, LastName, patID FROM Patrons";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute(); ///execute the query to the database
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        { //concatinate to huge string to be passed //concatinaton in php is done with '.='
            $all_options .= "<option value = '".$row['FirstName']."".$row['LastName']."'>".$row['FirstName']." ".$row['LastName']."      -       ".$row['patID']."</option><br>";
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

    function current_market_date()
    {
        $conn = connDB();
        //return month and date as a string
        $sql = "SELECT idByDate FROM Markets WHERE active = 1";
        $stmt_check_existence = $conn -> prepare($sql);
        $stmt_check_existence -> execute();
        $stmt = $conn -> prepare($sql);
        $stmt -> execute(); ///execute the query to the database
        if(!$stmt_check_existence -> fetch(PDO::FETCH_ASSOC))
        {
            return "WARNING: No Market has been invoked, ask the admin to invoke a market";
        }
        else
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            { //concatinate to huge string to be passed //concatinaton in php is done with '.='
                $final_date = substr($row['idByDate'], 4, 2)." / ".substr($row['idByDate'],0, 4);
            }
            return $final_date;
        }
        
    }

    function verifyExistence($conn, $id)
    {
        $sql = "SELECT * FROM Patrons WHERE patID = ".$id;
        $stmt = $conn -> prepare($sql);
        $stmt -> execute(); ///execute the query to the database
        if(!$stmt->fetch(PDO::FETCH_ASSOC)) //meaning if not results have been found in the database
        {
            return false; //person not found in the database 
        }
        else return true; //else, the ID already exists in the database

    }

    function loginPat($conn, $date, $id)
    {
        var_dump($date, $id);
        //GOAL: insert the two into the mid m:m table
        $sql = "INSERT INTO Markets_has_Patrons (Markets_idByDate, Patrons_patID) VALUES (".$date.", ".$id.");";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql); //execute the sql inset query (insert to data base)
        return;
    }
?>
