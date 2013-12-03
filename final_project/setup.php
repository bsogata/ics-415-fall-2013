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
  
  <script src="js/setup_script.js"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css">  
</head>

<body>
  <?php include 'create_tables.php'; ?>
  <div class="container">
    <?php include 'navbar.php'; ?>
    
    <div id="content">
      <!-- Invitations -->
      <?php 
        $database = new mysqli("localhost", "username", "password", "tic-tac-toe");
        
        if ($database->connect_errno)
        {
          echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
        }
        else
        {
          // If not already created, then set up Invitations table in database
          $database->query("CREATE TABLE IF NOT EXISTS Invitations (initiator CHAR(128), 
                                                                    recipient CHAR(128), 
                                                                    accepted BOOLEAN, 
                                                                    declined BOOLEAN)");
          $initiator = (isset($_COOKIE['username'])) ? ($_COOKIE['username']) : ('guest');

          // If a name is in $_POST, then create an entry in Invitations 
          // indicating that the current user has invited the user in $_POST to play
          if (isset($_POST['opponent_select']))
          {
            $recipient = $_POST['opponent_select'];
            
            $invite_query = "INSERT INTO Invitations (initiator, recipient, accepted, declined) " . 
                            "VALUES (\"" . $initiator . "\", " .
                                    "\"" . $recipient . "\", " . 
                                    "\"FALSE\", \"FALSE\")";
            $database->query($invite_query);
      ?>
            <form id="cancel_invitation" name="cancel_invitation" action="setup.php" method="post">
              <!-- Message to user -->
              <p>Sent invitation to <?php echo $recipient; ?> <br />
              
              <input type="hidden" id="recipient" name="recipient" value="<?php echo $recipient; ?>" />
              
              <!-- Option to retract invitation -->
              <input type="submit" id="cancel" name="cancel" value="Cancel" />
            </form>
      <?php
          }
          else
          {
            // If cancel is a parameter in $_POST, then remove the invitation from the table
            if (isset($_POST['cancel']))
            {
              $database = new mysqli("localhost", "username", "password", "tic-tac-toe");
              
              if ($database->connect_errno)
              {
                echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
              }
              else
              {        
                $database->query("DELETE FROM Invitations WHERE initiator=\"" . $initiator . "\" AND recipient=\"" . $_POST['recipient'] . "\"");
              }
              
              echo "Cancelled invitation to " . $_POST['recipient'] . '<br />';
            }
      ?>

            <form id="choose_opponent" name="choose_opponent" action="setup.php" method="post">
              <select id="opponent_select" name="opponent_select">
                <option>Select an opponent</option>
                <?php 
                  $database = new mysqli("localhost", "username", "password", "tic-tac-toe");
                  
                  if ($database->connect_errno)
                  {
                    echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
                  }
                  else
                  {        
                    $results = $database->query("SELECT U.username FROM Users U");

                    if ($results)
                    {
                      foreach ($results as $row)
                      {
                        if (((!isset($_COOKIE['username'])) || ($row['username'] != $_COOKIE['username'])) && 
                            ((!isset($_POST['username'])) || ($row['username'] != $_POST['username'])))
                        {
                          echo "<option>" . $row['username'] . "</option>";
                        }
                      }            
                    }
                  }
                ?>
              </select> <br />
              <input type="submit" id="submit" value="Send Invitation" />      
            </form>
          
      <?php
          }
        }
      ?>
    </div>
  </div>
</body>
</html>