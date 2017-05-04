<?php
//ini_set('session.cookie_lifetime', 10);
session_start();
include_once('../classes/user.php');

$inputUsername = $_POST['inputUsername'];
$inputPassword = $_POST['inputPassword'];

$objUser = new User();
$objUser->setUsername($inputUsername);
$objUser->setPassword($inputPassword);

if ($objUser->passwordIsOK()) {
	$_SESSION['valid'] = true;
	$_SESSION['username'] = $inputUsername;
	echo "login ok";
} else {
	echo "Bad login.";
}

?>