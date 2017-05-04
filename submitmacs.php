<?php
	include_once("db.php");

	if (!isset($_GET['macs'])) {
		exit("nothing to do here.");
	}

	//Store whatever we got from GET, to the $macs variable
	$macs=$_GET['macs'];
	//Split the variable using the delimiter ','
	$macs=explode(',', $macs);
	//Now $macs is an array

	$db = new Db();
	$db->connect();

	$everythingIsOK = true;
	$time = new DateTime();
	$time = $time->format('Y-m-d H:i:s');
	foreach ($macs as $mac) {
		$escapedMac = $db->escapeString($mac);
		$db->insert('officelog', array('mac'=>$escapedMac,
						'time'=>$time));
		$res = $db->getResult();
		if (!(is_numeric($res[0]) && $res[0] >= 0) && $everythingIsOK) {
			$everythingIsOK = false;
		}
	}
	echo ($everythingIsOK ? "1" : "0");
?>
