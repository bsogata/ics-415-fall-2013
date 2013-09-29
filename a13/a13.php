<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Assignment 13</title>
  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.min.js"></script>
</head>
<body>
  <ul id="comment-list">
    <?php
      // Open the comments file
      $file = fopen("comments.txt", "a+");
      
      // Write each of the existing comments
      foreach (file("comments.txt") as $comment)
      {
        echo "<li>" . $comment . "</li>";
      }
      
      // If any data was sent through POST, write to the list and add to the file
      if (isset($_POST["comment"]))
      {
        echo "<li>" . $_POST["comment"] . "</li>";
        fwrite($file, $_POST["comment"] . "\n");
      }
    ?>
  </ul>
  <form id="input-form" name="input-form" action="a13.php" method="post" >
    Comment: <input type="text" id="comment" name="comment" /><br />
    <input type="submit" id="submit" value="Submit" />
  </form>  
</body>
</html>