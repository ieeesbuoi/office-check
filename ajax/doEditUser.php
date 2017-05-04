<?php
    if(!isset($_SESSION)) { session_start(); } 
    if (!isset($_SESSION['valid']) || $_SESSION['valid'] == false) {
        header("Location: ../logout.php");
        exit("you are not logged in");
    }

    include_once('../classes/db.php');

    $db = new Db();
    $db->connect();
    
    // Escape any input before insert
    $userid = $db->escapeString($_POST['userid']);
    if (isset($_POST['admin'])) {
        $admin = $db->escapeString($_POST['admin']);

        if (!(is_numeric($admin)) || ($admin < 0 && $admin > 1) ) {
            echo "Πρέπει να επιλέξεις αν θες να είναι διαχειριστής ή όχι.";
            exit;
        }
        
        $db->select('users', '*', null, "id = '" . $userid . "'" );  // Table name, column names and respective values
        if ($db->numRows() == 0){
            echo "Ο χρήστης με id " . $userid . " δεν υπάρχει.";
            exit;
        }
        $data = $db->getResult();
        if ($data[0]["isadmin"] == $admin) {
            echo "change ok. Ο χρήστης είναι ήδη έτσι όπως τον ζήτησες.";
            exit;
        }

        //update($table,$params=array(),$where)
        if ($db->update('users',array('isadmin'=>$admin), "id = '" . $userid . "'")) {
            echo "change ok. Ο χρήστης άλλαξε με επιτυχία.";
        } else {
            echo "Παρουσιάστηκε πρόβλημα κατά την αλλαγή του χρήστη.";
        }
        exit;
    }    //if (isset($_POST['admin']))

    if (isset($_POST['password'])) {
        $password = $db->escapeString($_POST['password']);

        $db->select('users', '*', null, "id = '" . $userid . "'" );  // Table name, column names and respective values
        if ($db->numRows() == 0){
            echo "Ο χρήστης με id " . $userid . " δεν υπάρχει.";
            exit;
        }

        //update($table,$params=array(),$where)
        if ($db->update('users',array('password'=>$password), "id = '" . $userid . "'")) {
            echo "change ok. Ο κωδικός άλλαξε με επιτυχία.";
        } else {
            echo "Παρουσιάστηκε πρόβλημα κατά την αλλαγή του κωδικού.";
        }
        exit;
    }    //if (isset($_POST['admin']))

?>