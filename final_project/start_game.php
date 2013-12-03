<?php
  echo var_dump($_POST);
  $initiator = $_POST['initiator'];
  $recipient = $_POST['recipient'];
 
  $database = new mysqli("localhost", "username", "password", "tic-tac-toe");
  
  if ($database->connect_errno)
  {
    echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
  }
  else
  {
    $database->query("UPDATE Invitations " .
                     "SET accepted=TRUE " . 
                     "WHERE initiator=\"" . $initiator . "\" AND recipient=\"" . $recipient . "\"");
    
    // Create new Game entry
    $database->query("INSERT INTO Games (xname, oname, square0, square1, square2, square3, 
                                         square4, square5, square6, square7, square8, turn) " .
                     "VALUES (\"" . $recipient . "\", \"" . $initiator . "\", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
  }  
?>
