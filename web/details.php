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
<script> $(document).ready( function() { $('table.table').DataTable({
                                                "language": {
                                                      "lengthMenu": "Display _MENU_ records per page",
                                                      "zeroRecords": "No records found",
                                                      "info": "Showing page _PAGE_ of _PAGES_",
                                                      "infoEmpty": "No records available",
                                                      "infoFiltered": "(filtered from _MAX_ total records)"
                                            }});});</script>

<script>
  function toggle(event) {
    if (event == 'activity'){
      var elem = document.getElementById("acthr");
    }else{
      var elem = document.getElementById("nuthr")
    }
    if(elem.style.display == "none") {
      elem.style.display = "block";
    }else {
      elem.style.display = "none";
    }
  }
</script>
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
<hr>
<div class="container">
  <div class="jumbotron">
    <div class="row">
        <?php
          //Step2
          $query = "select  first_name,
                            last_name,
                            age,
                            phone,
                            gender,
                            program,
                            program_start_date,
                            program_length,
                            rewards_count
                      from  user
                     where  user_id = " . $_GET['p_uid'];
          $result = db_query($query);
          while ($row = mysqli_fetch_array($result)) {
          echo '<h2> Goal details for ' . $row['first_name'] . ', ' . $row['last_name'] . '</h2>';
          echo '<dl>
                  <dt class="col-md-2">User Name</dt>
                  <dd class="col-md-10">' . $row['first_name'] . ', ' . $row['last_name'] . '</dd>
                  <dt class="col-md-2">Age</dt>
                  <dd class="col-md-10">' . $row['age'] . '</dd>
                  <dt class="col-md-2">Gender</dt>
                  <dd class="col-md-10">' . $row['gender'] . '</dd>
                  <dt class="col-md-2">Phone</dt>
                  <dd class="col-md-10">' . $row['phone'] . '</dd>
                  <dt class="col-md-2">Program</dt>
                  <dd class="col-md-10">' . $row['program'] . '</dd>
                  <dt class="col-md-2">Start Date</dt>
                  <dd class="col-md-10">' . $row['program_start_date'] . '</dd>
                  <dt class="col-md-2">Program Length</dt>
                  <dd class="col-md-10">' . $row['program_length'] . ' weeks</dd>
                </dl>';}
        ?>
    </div>
    </div>
    <div class="row">
      <div class="btn-group" data-toggle="buttons">
        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#activity" onclick="toggle('activity')">Activity Details</button>
        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#nutrition" onclick="toggle('nutrition')">Nutrition Details</button>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="panel-group" >
        <div class="panel panel-info">
          <div class="panel-heading"><h4 >Goal Details</h4></div>
          <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Goal Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Goal</th>
                    <th>Comments</th>
                    <th>Reward Type</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      //Step2
                      $query = "select  type,
                                        start_date,
                                        end_date,
                                        (weekly_count*if(times=0, 1,times)) goal,
                                        reward_type,
                                        text
                                  from  user_goal
                                 where  goal_id in (" . $_GET['p_act_gid'] . ", " . $_GET['p_nut_gid'] . ")";
                      $result = db_query($query);
                      while ($row = mysqli_fetch_array($result)) {
                        echo '<tr>
                                <td>' . $row['type'] . '</td>
                                <td>' . $row['start_date'] . '</td>
                                <td>' . $row['end_date'] . '</td>
                                <td>' . $row['goal'] . '</td>
                                <td>' . $row['text'] . '</td>
                                <td>' . $row['reward_type'] . '</td>
                              </tr>';
                              } ?>
                </tbody>
          </table>
        </div>
        <hr id="nuthr" style="display:none;">
        <div id="nutrition" class="panel panel-success collapse">
          <div class="panel-heading"><h4 >Nutrition Details</h4></div>
        	  <table class="table table-hover">
              <thead>
                <tr>
                  <th>Nutrition Type</th>
                  <th>Date</th>
                  <th>Goal Qty</th>
                  <th>Comments</th>
            		  <th>Attic Food</th>
             		  <th>Dairy</th>
             		  <th>Vegetable</th>
             		  <th>Fruit</th>
             		  <th>Grain</th>
             		  <th>Protein</th>
             		  <th>Water Intake</th>
                  <th>Image</th>
                </tr>
              </thead>
            <tbody>
              <?php
                //Step2
                $query = "select  nutrition_type,
                                  date,
                                  towards_goal,
                                  notes comments,
                                  attic_food,
                                  dairy,
                                  vegetable,
                                  fruit,
                                  grain,
                                  protein,
                                  water_intake,
                                  SUBSTRING(image,9) nimg
                            from  nutrition_entry ne
                           where  ne.date between (select start_date from user_goal where goal_id = " . $_GET['p_nut_gid'] . ")
                                              and (select end_date from user_goal where goal_id = " . $_GET['p_nut_gid'] . ")
                             and  exists (select 1
                                            from user_goal
                                           where goal_id = ne.goal_id
                                             and type = 'Nutrition'
                                             and user_id = " . $_GET['p_uid'] . "
                                             and ne.date between start_date
                                                             and end_date)";
                $result = db_query($query);
                while ($row = mysqli_fetch_array($result)) {
                  echo '<tr>
                        <td>' . $row['nutrition_type'] . '</td>
                        <td><nobr>' . $row['date'] . '</nobr></td>
                        <td>' . $row['towards_goal'] . '</td>
                        <td>' . $row['comments'] . '</td>
                        <td>' . $row['attic_food'] . '</td>
                        <td>' . $row['dairy'] . '</td>
                        <td>' . $row['vegetable'] . '</td>
                        <td>' . $row['fruit'] . '</td>
                        <td>' . $row['grain'] . '</td>
                        <td>' . $row['protein'] . '</td>
                        <td>' . $row['water_intake'] . '</td>
                        <td>';?> <img class="img-responsive" src="<?php echo $row['nimg']; ?>" width="100" height="100">
                        <?php echo '</td>
                        </tr>';
                }?>
            </tbody>
        	</table>
    	  </div>
        <hr id="acthr" style="display:none;">
        <div id="activity" class="panel panel-warning collapse">
          <div class="panel-heading"><h4>Activity Details</h4></div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Activity</th>
                <th>Date</th>
                <th>Count for Goal</th>
                <th>Comments</th>
                <th>Activity Length</th>
                <th>RPE</th>
              </tr>
            </thead>
            <tbody>
              <?php
                //Step2
                $query = "select  (select name from activity where activity_id = ae.activity_id) act,
                                  ae.rpe,
                                  ae.activity_length,
                                  if(ae.count_towards_goal = 1, 'Yes', 'No') cnt_goal,
                                  ae.date,
                                  ae.notes comments
                            from  activity_entry ae
                           where  ae.date between (select start_date from user_goal where goal_id = " . $_GET['p_act_gid'] . ")
                                              and (select end_date from user_goal where goal_id = " . $_GET['p_act_gid'] . ")
                             and  exists (select 1
                                            from user_goal
                                           where goal_id = ae.goal_id
                                             and type = 'Activity'
                                             and user_id = " . $_GET['p_uid'] . "
                                             and ae.date between start_date
                                                             and end_date)";
                          $result = db_query($query);
                          while ($row = mysqli_fetch_array($result)) {
                            echo '<tr>
                                <td>' . $row['act'] . '</td>
                                <td><nobr>' . $row['date'] . '</nobr></td>
                                <td>' . $row['cnt_goal'] . '</td>
                                <td>' . $row['comments'] . '</td>
                                <td>' . $row['activity_length'] . '</td>
                                <td>' . $row['rpe'] . '</td>
                          </tr>';
                          }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <hr>
    <?php echo get_footer(); ?>
</div>
<?php echo get_modal($_SESSION['id'], $_SESSION['name']); ?>
</body>
</html>
