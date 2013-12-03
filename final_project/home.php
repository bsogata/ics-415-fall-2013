<!DOCTYPE HTML>

<!-- Creates or edits the cookie containing the user name -->
<?php include 'login.php'; ?>

<html>
<head>
  <title>Tic-Tac-Toe</title>
  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.min.js"></script>
  
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
  <!-- html5.js for IE less than 9 -->
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->

  <script src="js/bootstrap.min.js"></script>
  
  <script src="js/script.js"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css">  
</head>

<body>
  <?php include 'create_tables.php'; ?>
  <div class="container">
    <?php include 'navbar.php'; ?>
    <?php 
      if (isset($_COOKIE['error']))
      {
        echo $_COOKIE['error'] . "<br />";
        setcookie('error', '', time() - 3600);
      }
    ?>
    <form id="login" name="login" action="login.php" method="post">
      Username: <input type="text" id="username" name="username" /><br />
      Password: <input type="password" id="password" name="password" /><br />
      <input type="submit" id="submit" value="Login" />
    </form>
  </div>
</body>
</html>