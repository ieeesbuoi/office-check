<?php
	include_once('classes/db.php');

	$db = new Db();
	$db->connect();

	//SELECT DISTINCT `mac` FROM `officelog` WHERE time > '2017-04-27 13:45:00'
	//SELECT COUNT(DISTINCT `mac`) FROM `officelog` WHERE time > '2017-04-27 13:45:00'
	date_default_timezone_set('Europe/Athens');
	//set $time to 5 minutes ago
	$time = new DateTime();
	$time->modify('-5 minutes');
	$sql = "SELECT DISTINCT `mac` FROM `officelog` WHERE time > '" . $time->format("Y-m-d H:i:s") . "'";
	if ($db->sql($sql)) {
		//Yparxei toylaxiston 1 xristis online
		$count = $db->numRows();
		$data = $db->getResult();
		$macs = array();
		foreach ($data as $mac) {
			$macs[] = $mac['mac'];
		}
	} else {
		//Den yparxei kanenas xristis ayti ti stigmi online
		$count = 0;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
	<?php
		if ($count > 0) {
			//Yparxei toylaxiston 1 xristis online
			echo "<strong>";
			echo ($count == 1 ? "Υπάρχει " : "Υπάρχουν ") . $count . " " . ($count == 1 ? "άτομο" : "άτομα") . " αυτή τη στιγμή στο γραφείο.<br>";
			echo "</strong>";
			foreach ($macs as $mac) {
				echo $mac . "<br>";
			}
		} else {
			//Den yparxei kanenas xristis ayti ti stigmi online
			echo "Δεν υπάρχει κανένας αυτή τη στιγμή στο γραφείο.";
		}
	?>

</body>
</html>
