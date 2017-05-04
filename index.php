<?php
  session_start();
  if (!isset($_SESSION['valid']) || $_SESSION['valid'] == false) {
    header("Location: logout.php");
    exit("you are not logged in");
  }
	header("Location: viewusers.php");
?>
