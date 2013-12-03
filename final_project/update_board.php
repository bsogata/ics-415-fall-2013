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

    $game_results = $database->query("SELECT * FROM Games G " .
                                     "WHERE G.xname=\"" . $username . "\" OR G.oname=\"" . $username . "\" LIMIT 1");

    $message = "";
    
    foreach ($game_results as $row)
    {
      $message = "square0: " . $row['square0'] . "; " .
                 "square1: " . $row['square1'] . "; " .
                 "square2: " . $row['square2'] . "; " .
                 "square3: " . $row['square3'] . "; " .
                 "square4: " . $row['square4'] . "; " .
                 "square5: " . $row['square5'] . "; " .
                 "square6: " . $row['square6'] . "; " .
                 "square7: " . $row['square7'] . "; " .
                 "square8: " . $row['square8'] . "; " .
                 "turn: " . $row['turn'];
    }
    
    $serverTime = time();
    sendMsg($serverTime, $message);
    
    sleep(1);     
  }    
  
?>