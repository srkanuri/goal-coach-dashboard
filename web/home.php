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
<script> $(document).ready( function() { $('#summary').dataTable({"order": [[ 3, "desc" ]], "stateSave": true}); } );</script>
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
                <li class="active"><a href="home.php">Home</a></li>
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
<div class="container">
    <div class="jumbotron">
        <h1>GOAL: Dashboard for Coaches</h1>
        <p class="text-justify"></p>
        <p><a href="register.php" class="btn btn-success btn-lg">Register User</a></p>
    </div>
    <div class="panel panel-default">
  	<nav class="navbar navbar-inverse"><a class="navbar-brand">Goal Summary</a></nav>
    	   <table id="summary" class="table table-hover">
              <thead class="thead-inverse">
                <tr>
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Program</th>
		              <th>Start Date</th>
            		  <th>Nutrition Goal</th>
                  <th>Comments</th>
                  <th>Recorded Nutrition</th>
            		  <th>Activity Goal</th>
                  <th>Comments</th>
            		  <th>Recorded Activity</th>
            		  <th>Details</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    //Step2
                    $query = "select  u.first_name,
                                      u.last_name,
                                      u.age,
                                      u.gender,
                                      u.program,
                                      u.user_id,
                                      aug.goal_id agoal_id,
                                      nug.goal_id ngoal_id,
                                      date_format(aug.start_date, '%m-%d-%y') start_date,
                                      date_format(aug.end_date, '%m-%d-%y') end_date,
                                      aug.weekly_count*(if(aug.times = 0,1,aug.times)) agoal,
                                      aug.text atext,
                                      nug.weekly_count*(if(nug.times = 0,1,nug.times)) ngoal,
                                      nug.text ntext,
                                      ifnull((select sum(if(count_towards_goal = 1, ifnull(activity_length,0), 0)) from activity_entry ae where u.user_id = (select distinct ug1.user_id from user_goal ug1 where ug1.goal_id = ae.goal_id and ug1.type = 'Activity') and date between aug.start_date and aug.end_date),0) act_cnt,
                                      ifnull((select sum(ifnull(towards_goal,0)) from nutrition_entry ne where u.user_id = (select distinct ug1.user_id from user_goal ug1 where ug1.goal_id = ne.goal_id) and date between nug.start_date and nug.end_date), 0) nut_cnt
                                from  user u,
                                      (select * from user_goal ug where ug.type = 'Activity' and ug.goal_id in (select max(goal_id) from user_goal where type = ug.type and ug.user_id = user_id and start_date <= ug.start_date and end_date >= ug.end_date)) aug,
                                      (select * from user_goal ug where ug.type = 'Nutrition' and ug.goal_id in (select max(goal_id) from user_goal where type = ug.type and ug.user_id = user_id and start_date <= ug.start_date and end_date >= ug.end_date)) nug
                               where  u.user_id = aug.user_id
                                 and  aug.user_id = nug.user_id
                                 and  aug.start_date = nug.start_date
                                 and  aug.end_date = nug.end_date
                                 and  u.type = 'User'";
                    $result = db_query($query);
                    while ($row = mysqli_fetch_array($result)) {
                    	echo '<tr>
                  				<td>' . $row['first_name'] . ', ' . $row['last_name'] . '</td>
                  				<td>' . $row['gender'] . '</td>
                          <td>' . $row['program'] . '</td>
                  				<td><nobr>' . $row['start_date'] . '</nobr></td>
                  				<td>' . $row['ngoal'] . '</td>
                          <td>' . $row['ntext'] . '</td>
                          <td>' . $row['nut_cnt'] . '</td>
                          <td>' . $row['agoal'] . '</td>
                          <td>' . $row['atext'] . '</td>
                  				<td>' . $row['act_cnt'] . '</td>
						              <td><a href="details.php?p_act_gid=' . $row['agoal_id'] .'&p_nut_gid=' . $row['ngoal_id'] .'&p_uid=' . $row['user_id'] .'">
                              <span class="glyphicon glyphicon-list-alt" aria-hidden="true"/></a></td>
              			</tr>';
                    }?>
              </tbody>
    	 </table>
	</div>
    </div>
    <hr>
    <?php echo get_footer(); ?>
</div>
<?php echo get_modal($_SESSION['id'], $_SESSION['name']); ?>
</body>
</html>
