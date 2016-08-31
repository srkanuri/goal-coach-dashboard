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
<script> $(document).ready( function() { $('#summary').dataTable({"stateSave": true}); } );</script>
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
                <li class="active"><a href="register.php">Register</a></li>
                <li><a href="contact.php">Contact</a></li>
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
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo "<p>";
                $query = "insert into user (first_name,last_name,type,age,phone,gender,program,program_start_date,program_length,rewards_count,server_push)
                                 values ('". $_POST[firstName] ."', '". $_POST[lastName] ."', '". $_POST[type] ."', '". $_POST[age] ."', '". $_POST[phone] ."', '". $_POST[gender] ."', '". $_POST[programName] ."', STR_TO_DATE('". $_POST[programStart] ."', '%Y-%m-%d') , 1200, 0, 0)";
                $lastInsertId = "select last_insert_id() uid";
                $res = db_query($query);
                $lastId = mysqli_fetch_array(db_query($lastInsertId));
                if ($res){
                    echo $_POST[type]." ". $_POST[firstName] .", ". $_POST[lastName] ." is registered with ID " . $lastId['uid'] . ".";
                } else {
                    die("Error: ". mysqli_error());
                }
                echo "</p>";
            }
        ?>
        <p class="text-justify">Please remember the 'First Name' and 'User ID' to login from the app</p>
        <p><a href="register.php" class="btn btn-success btn-lg">Register Another User</a></p>
    </div>
    <?php echo get_footer(); ?>
</div>
<?php echo get_modal($_SESSION['id'], $_SESSION['name']); ?>
</body>
</html>
