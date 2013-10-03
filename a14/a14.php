<!DOCTYPE HTML>
<html>
  <head>
    <title>Assignment 14</title>
    <meta charset="utf-8">
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.min.js"></script>
  </head>
  <body>
    <ul id="comment-list">
      <?php
        $database = new mysqli("localhost", "username", "password", "ics415");

        if ($database->connect_errno)
        {
          echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
        }
        else
        {
          $result = $database->query("CREATE TABLE IF NOT EXISTS Comments (comment CHAR(128) NOT NULL)");
          
          if ($result)
          {
            // If any data was passed through POST, add it to the database    
            if (isset($_POST["comment"]))
            {
              if (!$database->query("INSERT INTO Comments (comment) VALUES (\"" . $_POST['comment'] . "\")"))
              {
                echo "Error when inserting value " . $_POST['comment'] . "<br />";
              }
            }
            
            // Create a list entry for each row in the Comments table
            $result = $database->query("SELECT * FROM Comments");
            
            foreach ($result as $row)
            {
              echo "<li>" . $row['comment'] . "</li>";
            }
          }
          else
          {
            echo "Error when attempting to create table (" . $database->errno . ") " . $database->error;
          }
        }

      ?>
    </ul>
    <form id="input-form" name="input-form" action="a14.php" method="post" >
      Comment: <input type="text" id="comment" name="comment" /><br />
      <input type="submit" id="submit" value="Submit" />
    </form>
  </body>
</html>