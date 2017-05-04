<?php
  session_start();
  if (!isset($_SESSION['valid']) || $_SESSION['valid'] == false) {
    header("Location: logout.php");
    exit("you are not logged in");
  }

	include_once('classes/db.php');

	$db = new Db();
	$db->connect();

	//SELECT DISTINCT `mac` FROM `officelog` WHERE time > '2017-04-27 13:45:00'
	//SELECT COUNT(DISTINCT `mac`) FROM `officelog` WHERE time > '2017-04-27 13:45:00'
	date_default_timezone_set('Europe/Athens');
	//set $time to 5 minutes ago
	$time = new DateTime();
	$time->modify('-50 minutes');

	$sql = "SELECT DISTINCT `officelog`.`mac`, `devices`.`user_id`, `users`.`firstname`, `users`.`lastname`, `users`.`slackid` FROM `officelog` LEFT JOIN `devices` ON `officelog`.`mac` = `devices`.`mac` LEFT JOIN `users` ON `devices`.`user_id` = `users`.`id` WHERE `officelog`.`time` > '" . $time->format("Y-m-d H:i:s") . "'";
	if ($db->sql($sql)) {
		//Yparxei toylaxiston 1 xristis online
		$count = $db->numRows();
		$data = $db->getResult();
/*		$devices = array();
		foreach ($data as $device) {
			$devices['mac'] = $device['mac'];
			$devices['user_id'] = $device['user_id'];
		} */
		$devices = $data;
	} else {
		//Den yparxei kanenas xristis ayti ti stigmi online
		$count = 0;
	}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="jquery/jquery-ui.min.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script type="text/javascript" src="jquery/jquery.min.js"></script>
  <script type="text/javascript" src="jquery/jquery.md5.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="jquery/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/viewusers.js"></script>

</head>
<body>

<?php
  include('menu.php');
?>

  <div class="container">
    <div class="page-header">
      <h1>Προβολή Παρόντων Χρηστών</h1>
    </div>

      <table class="table table-striped table-hover table-bordered" id="users-table">
        <thead>
          <tr>
            <th>MAC</th>
            <th>Επώνυμο</th>
            <th>Όνομα</th>
            <th>SlackID</th>
          </tr>
        </thead>
        <tbody>

          <?php
            foreach ($devices as $device) {
          ?>
          <tr>
            <th scope="row"><?php echo $device['mac']; ?></th>
            <td><?php echo $device['lastname']; ?></td>
            <td><?php echo $device['firstname']; ?></td>
            <td><?php echo $device['slackid']; ?></td>
          </tr>
          <?php
          	}
          ?>
        </tbody>
      </table>
		<?php
			if ($count == 0) {
				echo "Κανένας χρήστης αυτή τη στιγμή παρών.";
			}
		?>

   </div>

</body>
</html>