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
        <p class="text-justify">Enter the details below to register the User.</p>
    </div>
    <form action="insres.php" method="post">
      <div class="form-group row">
        <label for="firstName" class="col-sm-2 form-control-label">First Name</label>
        <div class="col-sm-10 input-group">
          <input type="text" class="form-control" name="firstName" required="required" placeholder="Enter First Name">
        </div>
      </div>
      <div class="form-group row">
        <label for="lastName" class="col-sm-2 form-control-label">Last Name</label>
        <div class="col-sm-10 input-group">
          <input type="text" class="form-control" name="lastName" required="required" placeholder="Enter Last Name">
        </div>
      </div>
      <div class="form-group row">
        <label for="type" class="col-sm-2 form-control-label">User Type</label>
        <div class="col-sm-1 input-group">
            <select name="type" class = "form-control">
                <option value="User">User</option>
                <option value="Coach">Coach</option>
            </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="gender" class="col-sm-2 form-control-label">Gender</label>
        <div class="col-sm-10 input-group">
          <div class="radio-inline">
            <label>
              <input type="radio" name="gender" id="gender1" value="Male">Male
            </label>
          </div>
          <div class="radio-inline">
            <label>
              <input type="radio" name="gender" id="gender2" value="Female">Female
            </label>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label for="age" class="col-sm-2 form-control-label">Age</label>
        <div class="col-sm-1 input-group">
            <select name="age" id="age" class = "form-control">
            </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="phone" class="col-sm-2 form-control-label">Phone</label>
        <div class="col-sm-2 input-group">
            <input type="tel" name="phone" class="form-control" value="" size="10" maxlength="10" required="required" placeholder="Enter Phone Number">
        </div>
      </div>
      <div class="form-group row">
        <label for="programName" class="col-sm-2 form-control-label">Program Name</label>
        <div class="col-sm-10 input-group">
            <select name="programName" id="actualProg" class = "form-control">
                <option disabled selected value> - Select a Program Name - </option>
                <?php
                $query = "select distinct program prog_name
                            from user
                        order by user_id desc";
                $result = db_query($query);
                while ($row = mysqli_fetch_array($result)) {
                  echo '<option value="' . $row['prog_name'] . '">' . $row['prog_name'] . '</option>';
                }?>
            </select>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" data-toggle="modal" data-target="#newProgram">Create New</button>
            </span>
        </div>
      </div>
      <div class="form-group row">
        <label for="programStart" class="col-sm-2 form-control-label">Program Start Date</label>
        <div class="col-sm-10 input-group">
          <input type="date" class="form-control" name="programStart" required="required">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-offset-2 col-sm-10 input-group">
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </div>
    </form>
    <?php echo get_footer(); ?>
</div>

<!-- New Program Creation Modal -->
<div id="newProgram" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New Program</h4>
      </div>
      <div class="modal-body">
        <p>Please enter the new program name you want to create.</p>
        <form role="form">
            <div class="form-group">
              <label for="progName">Program Name</label>
              <input type="text" class="form-control" id="progName" placeholder="Enter Program Name">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-success" data-dismiss="modal" onclick="transferProg()">Create</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
    function transferProg(){
        var progValue = document.getElementById("progName").value,
             mainProg = document.getElementById("actualProg"),
                  opt = document.createElement('option');
        opt.value = progValue;
        opt.innerHTML = progValue;
        mainProg.appendChild(opt);
        $('#actualProg option:last').prop('selected', true);
    }
</script>
<script> var sel = '<option disabled selected value> - Age - </option>';
         for (i=1;i<=100;i++){
            sel += '<option val=' + i + '>' + i + '</option>';}
         $('#age').html(sel);</script>
<?php echo get_modal($_SESSION['id'], $_SESSION['name']); ?>
</body>
</html>
