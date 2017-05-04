<?php
  session_start();
  if (!isset($_SESSION['valid']) || $_SESSION['valid'] == false) {
    header("Location: logout.php");
    exit("you are not logged in");
  }

  //include_once('classes/db.php');
  include_once('classes/user.php');

  $users = array();
  $db = new Db();
  $db->connect();
  //select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null)
  $db->select('users', 'id' );
  if ($db->numRows() > 0){
    $data = $db->getResult();
    $i = 0;
    foreach ($data as $id) {
      $users[$i] = new User();
      $users[$i]->loadFromDBwithID($id["id"]);
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

<div id="dialog-form" title="Προσθήκη νέου Χρήστη">
  <form id="add-user-form">
      <div class="container-fluid">
        
    <fieldset>
      <div class="row">
      <div class="form-group">
        <label class="control-label col-xs-4" for="last-name">Επώνυμο</label>
        <div class="col-xs-8"><input type="text" name="last-name" id="last-name" class="text ui-widget-content ui-corner-all"></div>
      </div>
      </div>
      <div class="row">
      <div class="form-group">
        <label class="control-label col-xs-4" for="first-name">Όνομα</label>
        <div class="col-xs-8"><input type="text" name="first-name" id="first-name" class="text ui-widget-content ui-corner-all"></div>
      </div>
      </div>
      <div class="row">
      <div class="form-group">
        <label class="control-label col-xs-4" for="slackid">SlackID</label>
        <div class="col-xs-8"><input type="text" name="slackid" id="slackid" class="text ui-widget-content ui-corner-all"></div>
      </div>
      </div>
      <div class="row">
      <div class="form-group">
        <label class="control-label col-xs-4" for="email">e-mail</label>
        <div class="col-xs-8"><input type="text" name="email" id="email" class="text ui-widget-content ui-corner-all"></div>
      </div>
      </div>
      <div class="row">
      <div class="form-group">
        <label class="control-label col-xs-4" for="username">Username</label>
        <div class="col-xs-8"><input type="text" name="username" id="username" class="text ui-widget-content ui-corner-all"></div>
      </div>
      </div>
      <div class="row">
      <div class="form-group">
        <label class="control-label col-xs-4" for="password">Password</label>
        <div class="col-xs-8"><input type="text" name="password" id="password" class="text ui-widget-content ui-corner-all"></div>
      </div>
      </div>
      <div class="row">
      <div class="form-group">
        <label class="control-label col-xs-4" for="admin">Admin</label>
        <div class="col-xs-8">
          <label class="radio-inline">
            <input type="radio" name="admin" value="adminYes">Ναι
          </label>
          <label class="radio-inline">
            <input type="radio" name="admin" value="adminNo" checked>Όχι
          </label>
        </div>
      </div>
      </div> 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input id="add-user-button" type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </div>
  </form>
  <div id="ajax_response" class="alert"></div>
</div>


  <div class="container">
    <div class="page-header">
      <h1>Προβολή Χρηστών</h1>
    </div>

      <table class="table table-striped table-hover table-bordered" id="users-table">
        <thead>
          <tr>
            <th>id</th>
            <th>Επώνυμο</th>
            <th>Όνομα</th>
            <th>SlackID</th>
            <th>e-mail</th>
            <th>Username</th>
            <th>Password</th>
            <th>isAdmin</th>
            <th>Devices</th>
          </tr>
        </thead>
        <tbody>

          <?php
            foreach ($users as $user) {
          ?>
          <tr>
            <th scope="row"><?php echo $user->getId(); ?></th>
            <td><?php echo $user->getLastname(); ?></td>
            <td><?php echo $user->getFirstname(); ?></td>
            <td><?php echo $user->getSlackid(); ?></td>
            <td><?php echo $user->getEmail(); ?></td>
            <td><?php echo $user->getUsername(); ?></td>
            <td><div><img src="images/password.png" class="editPassword">&nbsp;<span>&bull;&bull;&bull;&bull;&bull;&bull;&bull;</span></div><div></div></td>
            <td><div><img src="images/edit.png" class="editAdmin">&nbsp;<span><?php echo ($user->getIsAdmin() ? "ΝΑΙ" : "ΟΧΙ"); ?></span></div><div></div></td>
            <td><a href="viewdevices.php?foruser=<?php echo $user->getId(); ?>">Devices</a></td>
          </tr>
          <?php
            } //foreach
          ?>

        </tbody>
      </table>

      <button type="button" id="btnAddNewUser" class="btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Προσθήκη</button>

  </div>
  <p></p>
</body>
</html>
