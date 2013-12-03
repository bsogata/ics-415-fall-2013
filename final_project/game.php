<!DOCTYPE html>

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
  
  <script src="js/board_script.js"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css">  
</head>

<body>
  <?php include 'create_tables.php' ?>
  
  <!-- Set up a new Game -->
  
  <div class="container">
    <?php include 'navbar.php' ?>

    <table id="board">
      <tr>
        <td>
          <div id="square0" class="square"></div>
        </td>
        <td>
          <div id="square1" class="square"></div>
        </td>
        <td>
          <div id="square2" class="square"></div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="square3" class="square"></div>
        </td>
        <td>
          <div id="square4" class="square"></div>
        </td>
        <td>
          <div id="square5" class="square"></div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="square6" class="square"></div>
        </td>
        <td>
          <div id="square7" class="square"></div>
        </td>
        <td>
          <div id="square8" class="square"></div>
        </td>
      </tr>
    </table>

    <!-- Load in the data for the stats table here -->
    <?php
      $database = new mysqli("localhost", "username", "password", "tic-tac-toe");
      
      if ($database->connect_errno)
      {
        echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
      }
      else
      {        
        $username = (isset($_COOKIE['username'])) ? ($_COOKIE['username']) : ('guest');
        $current_game = $database->query("SELECT * FROM Games G WHERE G.xname=\"" . $username . "\" OR " .
                                                                     "G.oname=\"" . $username . "\" LIMIT 1");
                                                      
        foreach ($current_game as $row)
        {
          $xname = $row['xname'];
          $oname = $row['oname'];
          
          // Get records for each player as well
          $xuser_result = $database->query("SELECT U.wins, U.losses, U.draws " .
                                           "FROM Users U " .
                                           "WHERE U.username=\"" . $xname . "\" LIMIT 1")->fetch_row();
          $ouser_result = $database->query("SELECT U.wins, U.losses, U.draws " .
                                           "FROM Users U " .
                                           "WHERE U.username=\"" . $oname . "\" LIMIT 1")->fetch_row();
        }
      }
    ?>
      <table id="stats" border="1">
        <tr>
          <th>Mark</th>
          <th>Name</th>
          <th>Record (Win-Loss-Draw)</th>
        </tr>
        <tr>
          <td>X</td>
          <td id="player_x_name"><?php echo $xname; ?></td>
          <td><?php echo $xuser_result[0] . "-" . $xuser_result[1] . "-" . $xuser_result[2] ?></td>
        </tr>
        <tr>
          <td>O</td>
          <td id="player_o_name"><?php echo $oname; ?></td>
          <td><?php echo $ouser_result[0] . "-" . $ouser_result[1] . "-" . $ouser_result[2] ?></td>
        </tr>
      </table>    
  </div>
</body>
</html>