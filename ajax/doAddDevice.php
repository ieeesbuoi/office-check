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
    $mac = $db->escapeString($_POST['mac']);
    $user_id = $db->escapeString($_POST['user_id']);

    if (!(is_numeric($user_id)) || ($user_id <= 0) ) {
        echo "Πρέπει να επιλέξεις κάποιον χρήστη.";
        exit;
    }
    
    $db->select('users', '*', null, "id = '" . $user_id . "'" );  // Table name, column names and respective values
    if ($db->numRows() == 0){
        echo "Ο χρήστης με id " . $user_id . " δεν υπάρχει.";
        exit;
    }

    $url = "http://api.macvendors.com/" . urlencode($mac);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    if($response) {
        $vendor = $response;
    } else {
        $vendor = "Unknown";
    }

    $submitted = $db->insert('devices',array('mac'=>$mac, 'user_id'=>$user_id, 'vendor'=>$vendor));
    
    if ($submitted) {
        echo "kataxorisi ok" . $vendor;
    } else {
        echo "Παρουσιάστηκε πρόβλημα κατά την καταχώρηση της συσκευής.";
    }
   
?>