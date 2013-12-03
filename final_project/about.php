<!DOCTYPE HTML>

<?php include 'login.php' ?>

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
  <div class="container">
    <!-- Navbar; use on all pages -->
    <?php include 'navbar.php'; ?>

    <p>
      Designed and created by [insert clever team name here].
    </p>
    <p>
      This application uses the following technologies:
    </p>
    <ul>
      <li>HTML</li>
      <li>JavaScript
        <ul>
          <li>jQuery</li>
          <li>AJAX</li>
        </ul>
      </li>
      <li>PHP</li>
      <li>Twitter Bootstrap</li>
      <li>XAMPP
        <ul>
          <li>Apache</li>
          <li>MySQL</li>
        </ul>
      </li>
      <li>Server-Side Events</li>
    </ul>
    
    <p>
      In particular, AJAX sends user invitations and moves to the server while server-side events 
      allow the server to communicate invitation responses and opponent moves.  This project also
      abuses the PHP keyword <b>include</b> to insert the same code in different locations.  For
      example, the navbar is stored in its own PHP file, then <b>include</b>d in all of the pages
      so that it appears at the top of every page.
    </p>
  </div>
</body>
</html>