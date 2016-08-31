<!DOCTYPE html>
<?php
  session_start();
  if (!isset($_SESSION['id'])){
    echo '<script>
            window.location="login.php"
          </script>';
  }
  require 'utilities.php';
  echo get_head();
?>
<body>
<nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">GOAL</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
                <li><a href="register.php">Register</a></li>
                <li class="active"><a href="contact.php">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['name']; ?><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#myProfile">My Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="logout.php">Logout</a></li>
                  </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="jumbotron">
        <h1>GOAL: Dashboard for Coaches</h1>
        <p class="text-justify">Enter the contact details needed here. To be completed.</p>
    </div>
    <?php echo get_footer(); ?>
</div>
<?php echo get_modal($_SESSION['id'], $_SESSION['name']); ?>
</body>
</html>
