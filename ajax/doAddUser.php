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
    $firstname = $db->escapeString($_POST['firstname']);
    $lastname = $db->escapeString($_POST['lastname']);
    $email = $db->escapeString($_POST['email']);
    $slackid = $db->escapeString($_POST['slackid']);
    $username = $db->escapeString($_POST['username']);
    $password = $db->escapeString($_POST['password']); //it is allready MD5 encrypted
    $admin = $db->escapeString($_POST['admin']);

    if (!(is_numeric($admin)) || ($admin < 0 && $admin > 1) ) {
        echo "Πρέπει να επιλέξεις αν θες να είναι διαχειριστής ή όχι.";
        exit;
    }
    
    $db->select('users', '*', null, "username = '" . $username . "'" );  // Table name, column names and respective values
    if ($db->numRows() > 0){
        echo "Ο χρήστης με username " . $username . " υπάρχει ήδη.";
        exit;
    }

    $db->select('users', '*', null, "slackid = '" . $slackid . "'" );  // Table name, column names and respective values
    if ($db->numRows() > 0){
        echo "Ο χρήστης με slackid " . $slackid . " υπάρχει ήδη.";
        exit;
    }

    $db->select('users', '*', null, "email = '" . $email . "'" );  // Table name, column names and respective values
    if ($db->numRows() > 0){
        echo "Ο χρήστης με email " . $email . " υπάρχει ήδη.";
        exit;
    }

    $db->insert('users',array('lastname'=>$lastname, 'firstname'=>$firstname, 'slackid'=>$slackid, 'email'=>$email,
                                'username'=>$username, 'password'=>$password, 'isadmin'=>$admin));
    $res = $db->getResult();  
    
    if (is_numeric($res[0]) && $res[0] >= 0) {
        echo "kataxorisi ok" . $res[0];
    } else {
        echo "Παρουσιάστηκε πρόβλημα κατά την καταχώρηση του χρήστη.";
    }
   
?>