<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <script type="text/javascript" src="jquery/jquery.min.js"></script>
  <script type="text/javascript" src="jquery/jquery.validate.min.js"></script>
  <script type="text/javascript" src="jquery/additional-methods.min.js"></script>
  <script type="text/javascript" src="jquery/jquery.md5.js"></script>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap/css/signin.css" rel="stylesheet">
  <script type="text/javascript" src="js/login.js"></script>

</head>
<body>

  <div class="container">
      <form class="form-signin" id="signin-form">
        <h2 class="form-signin-heading">Είσοδος</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="password" required>
      
        <button class="btn btn-lg btn-primary btn-block" type="submit">Είσοδος</button>
        <div class="alert" id="ajax_response" role="alert"></div>
      </form>
  </div>

</body>
</html>
