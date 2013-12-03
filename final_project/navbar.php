<!-- Navbar; use on all pages -->
<nav class="navbar navbar-default" role="navigation">
  <a class="navbar-brand" href="home.php">Tic-Tac-Toe</a>
  <ul class="nav navbar-nav">
    <li><a href="setup.php">Games</a></li>
    <li><a href="about.php">About</a></li>
    <?php
      if ((isset($_COOKIE['username'])))
      {
        echo '<li><a href="logout.php">Sign Out</a></li>';
      }
    ?>
  </ul>
</nav>
