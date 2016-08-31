<?php
  function conn_db(){
    static $db;
    if(!isset($db)){
      $dbconfig = parse_ini_file("../db-config.ini");
      $db = mysqli_connect($dbconfig['host'],$dbconfig['username'],$dbconfig['password'],$dbconfig['dbname'])
              or die('Error connecting to MySQL server: ' . mysqli_connect_error());
    }
    return $db;
  }

  function db_query($query) {
    $con = conn_db();
    $result = mysqli_query($con, $query) or die('Error querying database.');
    return $result;
  }

  function get_head(){
    return '<html lang="en">
            <head>
              <meta charset="UTF-8">
              <title>GOAL: Dashboard for Coaches</title>
              <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
              <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
              <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

              <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
              <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
              <script src="https://code.jquery.com/jquery-1.12.3.js"></script>
              <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
              <script src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
            </head>';
  }

  function get_footer(){
    return '<div class="row">
                <div class="col-sm-12">
                    <footer>
                        <p><a href="https://www.iu.edu/copyright/index.html" target="_blank">Copyright</a> © 2016 The Trustees of <a href="https://www.indiana.edu" target="_blank">Indiana University</a></p>
                    </footer>
                </div>
            </div>';
  }

  function get_modal($p_id, $p_name){
    $userQuery = "select  first_name,
                          last_name,
                          age,
                          phone,
                          gender,
                          program,
                          program_start_date,
                          program_length,
                          rewards_count
                    from  user
                   where  user_id = " . $p_id;
    $userDetais = db_query($userQuery);
    $userRow = mysqli_fetch_array($userDetais);
    return '<!-- Modal -->
            <div class="modal fade" id="myProfile" tabindex="-1" role="dialog" aria-labelledby="myProfile">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title" id="myProfile">' . $p_name . 's Profile</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                          <dl>
                                <dt class="col-md-2">Full Name</dt>
                                <dd class="col-md-10">' . $userRow['first_name'] . ', ' . $userRow['last_name'] . '</dd>
                                <dt class="col-md-2">Age</dt>
                                <dd class="col-md-10">' . $userRow['age'] . '</dd>
                                <dt class="col-md-2">Gender</dt>
                                <dd class="col-md-10">' . $userRow['gender'] . '</dd>
                                <dt class="col-md-2">Phone</dt>
                                <dd class="col-md-10">' . $userRow['phone'] . '</dd>
                                <dt class="col-md-2">Program</dt>
                                <dd class="col-md-10">' . $userRow['program'] . '</dd>
                                <dt class="col-md-2">Start Date</dt>
                                <dd class="col-md-10">' . $userRow['program_start_date'] . '</dd>
                          </dl>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" onclick="window.location=logout.php">Logout</button>
                  </div>
                </div>
              </div>
            </div>';
  }
?>
