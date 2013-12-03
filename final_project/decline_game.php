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
                     "SET declined=TRUE " . 
                     "WHERE initiator=\"" . $initiator . "\" AND recipient=\"" . $recipient . "\"");
    sleep(4);
  }  
?>
