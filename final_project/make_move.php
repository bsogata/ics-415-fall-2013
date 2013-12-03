<?php
  $database = new mysqli("localhost", "username", "password", "tic-tac-toe");
  
  if ($database->connect_errno)
  {
    echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
  }
  else
  {
    $database->query("UPDATE Games " .
                     "SET " . $_POST['square'] . "=" . $_POST['mark'] . " , turn=turn+1 " . 
                     "WHERE xname=\"" . $_POST['mover'] . "\" OR oname=\"" . $_POST['mover'] . "\"");
  }
?>