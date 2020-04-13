<?php include "connDB.php"; ?>

<?php

    $c = connDB();
    $d = 20200416;
    $data = "";

            //COMMUNITY
            $sql_a = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Community' AND MarketLogins.Markets_idByDate = ".$d;
            $s_a = $c -> query($sql_a);
            $comm = $s_a -> fetchColumn();
            $data .= "{METHOD: 'Community', AMOUNT: ".$comm."}";
            //FRIENDS AND FAMILY
            $sql_b = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'FriendsAndFamily' AND MarketLogins.Markets_idByDate = ".$d;
            $s_b = $c -> query($sql_b);
            $fnf = $s_b -> fetchColumn();
            $data .= ", {METHOD: 'Friends/Family', AMOUNT: ".$fnf."}";
            // CLASSROOM
            $sql_c = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Classroom' AND MarketLogins.Markets_idByDate = ".$d;
            $s_c = $c -> query($sql_c);
            $class = $s_c -> fetchColumn();
            $data .= ", {METHOD: 'Classroom', AMOUNT: ".$class."}";
            //OTHER
            $sql_d = "SELECT COUNT(*) FROM Patrons INNER JOIN MarketLogins ON Patrons.patID = MarketLogins.Patrons_patID WHERE Patrons.PromotionMethod = 'Other' AND MarketLogins.Markets_idByDate = ".$d;
            $s_d = $c -> query($sql_d);
            $other = $s_d -> fetchColumn();
            $data .= ", {METHOD: 'Other', AMOUNT: ".$other."}";
        echo $data."\n\n";
?>