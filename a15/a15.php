<!DOCTYPE HTML>

<!-- Creates or edits the cookie containing the user name -->
<?php
  if ((isset($_POST["username"])) && ($_POST["username"] != ""))
  {
    setcookie("username", $_POST["username"]);
  }
?>

<html>
  <head>
    <title>Assignment 15</title>
    <meta charset="utf-8">
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.min.js"></script>    
  </head>
  <body>
    <ul id="comment-list">
      <?php
        // Greets the user, using a name if one was provided
        // Note that $_COOKIE["username"] is not set until the page load after the user submits
        // the form with text entered for the Name field, so the check on $_POST["username"]
        // takes precedence and serves as the value the first submit after the username change
        // Also note that this is a deliberate design decision to treat a blank username
        // as "guest" in order to avoid any potential issues with empty strings
        $user = ((isset($_POST["username"]) && $_POST["username"] != "") ? 
                 ($_POST["username"]) : ((isset($_COOKIE["username"])) ? 
                                           ($_COOKIE["username"]) : ("guest")));
        echo "Welcome, " . $user . "<br />";
        
        $database = new mysqli("localhost", "username", "password", "ics415");

        if ($database->connect_errno)
        {
          echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
        }
        else
        {
          $result = $database->query("CREATE TABLE IF NOT EXISTS Comments (comment CHAR(128) NOT NULL,
                                                                           username CHAR(64))");
          
          if ($result)
          {
            // If any data was passed through POST, add it to the database    
            if ((isset($_POST["comment"])) && ($_POST["comment"] != ""))
            {
              if (!$database->query("INSERT INTO Comments (comment, username) VALUES (\"" . $_POST['comment'] . "\"," .
                                                                                      "\"" . $user . "\")"))
              {
                echo "Error when inserting value " . $_POST['comment'] . "," . $user . "<br />";
              }
            }
            
            // Create a list entry for each row in the Comments table
            $result = $database->query("SELECT * FROM Comments");
            
            foreach ($result as $row)
            {
              echo "<li>" . $row['username'] . ": " . $row['comment'] . "</li>";
            }
          }
          else
          {
            echo "Error when attempting to create table (" . $database->errno . ") " . $database->error;
          }
        }

      ?>
    </ul>
    <form id="input-form" name="input-form" action="a15.php" method="post" >
      User: <input type="text" id="username" name="username" /><br />
      Comment: <input type="text" id="comment" name="comment" /><br />
      <input type="submit" id="submit" value="Submit" />
    </form>
    
    <!-- Statistics go here -->
    <?php
      if (!$database->connect_errno)
      {
        // Yay for ICS 321
        $stat_results = $database->query("SELECT C.username, COUNT(C.comment) AS comment_count FROM Comments C GROUP BY username");
        
        if ($stat_results)
        {
     ?>
     <!-- This is where being OCD about indentation alignment causes problems -->
          <table border="1">
            <tr>
              <th><b>User</b></th>
              <th><b>Comment Count</b></th>
            </tr>
            <?php
              foreach ($stat_results as $row)
              {
                ?>
                <tr>
                <?php
                  echo "<td>" . (($row['username'] == "") ? ("guest") : ($row['username'])) . "</td>";
                  echo "<td>" . $row['comment_count'] . "</td>";
                ?>
                </tr>
                <?php
              }
            ?>
          </table>
      <?php              
        }
        else
        {
          echo "Error when attempting to gather statistics";
        }
      }
    ?>
  </body>
</html>