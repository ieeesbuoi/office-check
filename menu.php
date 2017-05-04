<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if (!isset($_SESSION['valid']) || $_SESSION['valid'] == false) {
    header("Location: logout.php");
    exit("you are not logged in");
  }
?>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
              <li><a href="viewusers.php">Προβολή Χρηστών</a></li>
	      <li><a href="whosonline.php">Προβολή Παρόντων Χρηστών</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="logout.php">Έξοδος</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

