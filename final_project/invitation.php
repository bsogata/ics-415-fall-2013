<?php
  header('Content-Type: text/event-stream');
  header('Cache-Control: no-cache');

  function sendMsg($id, $msg) 
  {
    echo "id: $id" . PHP_EOL;
    echo "data: $msg" . PHP_EOL;
    echo PHP_EOL;
    ob_flush();
    flush();
  }

  $database = new mysqli("localhost", "username", "password", "tic-tac-toe");
  
  if ($database->connect_errno)
  {
    echo "Failed to connect to MySQL: (" . $database->connect_errno . ")" . $database->connect_error . "<br />";
  }
  else
  {        
    $username = (isset($_COOKIE['username'])) ? ($_COOKIE['username']) : ('guest');
    $initiator_query = $database->query("SELECT * " . 
                                        "FROM Invitations I " . 
                                        "WHERE I.initiator=\"" . $username . "\"");
    $recipient_query = $database->query("SELECT * " . 
                                        "FROM Invitations I " . 
                                        "WHERE I.recipient=\"" . $username . "\"");
    $message = "";
    
    // Check invitations that this user sent
    if (($initiator_query) && ($initiator_query->num_rows > 0))
    {
      foreach ($initiator_query as $row)
      {
        // If the invitation was accepted
        if ($row['accepted'] == TRUE)
        {
          $message = "Accepted:" . $row['recipient'];
          
          // Remove the corresponding invitation from the database
          $database->query("DELETE FROM Invitations WHERE initiator=\"" . $username . "\" AND " .
                                                         "recipient=\"" . $row['recipient'] . "\";");
        } 
        // If the invitation was declined
        else if ($row['declined'] == TRUE)
        {
          $message = "Declined:" . $row['recipient'];
          
          // Remove the corresponding invitation from the database
          $database->query("DELETE FROM Invitations WHERE initiator=\"" . $username . "\" AND " .
                                                         "recipient=\"" . $row['recipient'] . "\";");
        }
      }
    }
    // Check invitations sent to this user
    else if (($recipient_query) && ($recipient_query->num_rows > 0))
    {
      foreach ($recipient_query as $row)
      {
        // If the invitation has not already been accepted or declined
        if ($row['accepted'] != TRUE && $row['declined'] != TRUE)
        {
          if (strlen($message) == 0)
          {
            $message .= "Invitation:";
          }
          
          $message .= $row['initiator'] . ";";
        }
      } 
    }
    
    $serverTime = time();
    sendMsg($serverTime, $message);
    
    sleep(1); 
  }
?>