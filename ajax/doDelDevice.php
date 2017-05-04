<?php
    if(!isset($_SESSION)) { session_start(); } 
    if (!isset($_SESSION['valid']) || $_SESSION['valid'] == false) {
        header("Location: ../logout.php");
        exit("you are not logged in");
    }
    include_once('../classes/db.php');

    if (!(isset($_POST['mac']))) {
        echo "Πρέπει να επιλέξεις κάποια MAC Address.";
        exit;
    }
    
    $db = new Db();
    $db->connect();

    // Escape any input before insert
    $mac = $db->escapeString($_POST['mac']);

    $db->select('devices', '*', null, "mac = '" . $mac . "'" );  // Table name, column names and respective values
    if ($db->numRows() == 0){
        echo "Δεν υπάρχει συσκευή με MAC Address " . $mac;
        exit;
    }

    if ( $db->delete('devices', "mac = '" . $mac . "'") ) {
        echo "delete ok";
    } else {
        echo "Παρουσιάστηκε πρόβλημα κατά την διαγραφή της συσκευής.";
    }
   
?>