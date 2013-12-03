<?php
  $database = new mysqli("localhost", "username", "password", "tic-tac-toe");
  
  if ($database->connect_errno)
  {
    echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
  }
  else
  {
    // Remove the game from the database
    $database->query("DELETE FROM Games WHERE xname=\"" . $_POST['xname'] . "\" OR " .
                                             "oname=\"" . $_POST['oname'] . "\";");
                                           
    // Update the records for both players
    $x_user = $database->query("UPDATE Users " . 
                               "SET " . (($_POST['winner'] == " ") ? 
                                         ("draws = draws + 1") : 
                                         (($_POST['winner'] == "X") ? ("wins = wins + 1") : 
                                                                      ("losses = losses + 1"))) . " " .
                               "WHERE username=\"" . $_POST['xname'] . "\";");
    $o_user = $database->query("UPDATE Users " . 
                               "SET " . (($_POST['winner'] == " ") ? 
                                         ("draws = draws + 1") : 
                                         (($_POST['winner'] == "O") ? ("wins = wins + 1") : 
                                                                      ("losses = losses + 1"))) . " " .
                               "WHERE username=\"" . $_POST['oname'] . "\";");    
  }
?>