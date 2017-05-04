<?php
  session_start();
  if (!isset($_SESSION['valid']) || $_SESSION['valid'] == false) {
    header("Location: logout.php");
    exit("you are not logged in");
  }

  if ((!isset($_GET['foruser'])) || (!is_numeric($_GET['foruser']))) {
    header("Location: viewusers.php");
    exit("you haven't selected any user");
  }

  $user_id = $_GET['foruser'];
  //include_once('classes/db.php');
  include_once('classes/user.php');
  include_once('classes/device.php');

  $user = new User();
  $user->loadFromDBwithID($user_id);

  $devices = array();
  $db = new Db();
  $db->connect();
  //select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null)
  $db->select('devices', 'mac', null, "user_id = " . $user_id );
  if ($db->numRows() > 0){
    $data = $db->getResult();
    $i = 0;
    foreach ($data as $device) {
      $devices[$i] = new Device();
      $devices[$i]->loadFromDBwithMAC($device["mac"]);
      $i++;
    }
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
  <!-- Latest compiled and minified JavaScript -->
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="jquery/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/viewdevices.js"></script>

</head>
<body>

<?php
  include('menu.php');
?>

<div id="dialog-form" title="Προσθήκη νέας συσκευής">
  <form id="add-device-form">
      <div class="container-fluid">
        
    <fieldset>
      <div class="row">
      <div class="form-group">
        <label class="control-label col-xs-4" for="mac">MAC Address</label>
        <div class="col-xs-8"><input type="text" name="mac" id="mac" class="text ui-widget-content ui-corner-all"></div>
      </div>
      </div>
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input id="add-device-button" type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </div>
  </form>
  <div id="ajax_response" class="alert"></div>
</div>


  <div class="container">
    <div class="page-header">
      <h1>Προβολή Συσκευών για τον <?php echo $user->getFirstname() . " " . $user->getLastname() . " (" . $user->getSlackid() . ")"; ?></h1>
    </div>
    <div id="user_id" style="display: none;"><?php echo $user_id; ?></div>
      <table class="table table-striped table-hover table-bordered" id="devices-table">
        <thead>
          <tr>
            <th>#</th>
            <th>MAC Address</th>
            <th>Vendor</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>

          <?php
            $i = 0;
            foreach ($devices as $device) {
              $i++;
          ?>
          <tr>
            <th scope="row"><?php echo $i; ?></th>
            <td><?php echo $device->getMac(); ?></td>
            <td><?php echo $device->getVendor(); ?></td>
            <td><div><img src="images/delete.png" class="delDevice"><span></span></div><div></div></td>
          </tr>
          <?php
            } //foreach
          ?>

        </tbody>
      </table>

      <button type="button" id="btnAddNewDevice" class="btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Προσθήκη</button>

  </div>
  <p></p>
</body>
</html>
