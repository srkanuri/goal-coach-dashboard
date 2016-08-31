<!DOCTYPE html>
<?php
    require 'utilities.php';
    echo get_head();
?>
<style>
    body { width: 90%;
            height:100%;
            background-color: #333;}
    .login {position: absolute;
            top: 45%;
            left: 43%;
            margin: -150px 0 0 -150px;
            width:550px;
            height:300px;}
    .login h1 { color: #fff; text-shadow: 0 .05rem .1rem rgba(0,0,0,.5); letter-spacing:1px;}
    .login p { color: #fff; text-shadow: 0 .05rem .1rem rgba(0,0,0,.5); letter-spacing:1px;}
    .login label {font-size: 15px; color: #fff; letter-spacing:1px;}
</style>
</head>
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
                <li><a class="nav-link disabled" href="#">Home</a></li>
                <li><a class="nav-link disabled" href="#">Register</a></li>
                <li><a class="nav-link disabled" href="#">Contact</a></li>
            </ul>
        </div>
    </div>
    </nav>
    <div class="login">
        <div class="container">
            <h1 class="display-3">GOAL: Login for Coaches</h1>
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (!isset($_POST["inpuid"]) || !isset($_POST["inpfn"])){
                        echo '<script>
                                location.reload();
                              </script>';
                    }
                    $query = "select count(user_id) cnt
                                from user
                               where user_id    =   ". $_POST["inpuid"] ."
                                 and type       =   'User'
                                 and lower(first_name)      =   lower('". $_POST["inpfn"] ."')";
                    $result = db_query($query);
                    $row = mysqli_fetch_array($result);
                    if($row['cnt'] == 1){
                        session_start();
                        $userInfo = "select first_name,
                                            last_name
                                       from user
                                      where user_id = ". $_POST["inpuid"];
                        $resUserInfo = db_query($userInfo);
                        $userRow = mysqli_fetch_array($resUserInfo);
                        $_SESSION['name']=ucwords(strtolower($userRow["first_name"] . ', ' . $userRow["last_name"])) .' ';
                        $_SESSION['id']=$_POST["inpuid"];
                        echo '<script>
                                window.location="home.php"
                              </script>';
                    }else{
                        echo '<p class="lead"><span class="label label-danger">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                Wrong Firstname/User ID combination used to login. Please try again.</span></p>';
                    }
                }else{
                    echo '<p class="lead">Enter your First Name and User ID to login:</p>';
                }
            ?>
            <form class="form-signin" action="login.php" method="post">
                <div class="form-group row">
                    <label for="inpfn" class="col-sm-2 form-control-label">First Name</label>
                    <div class="col-sm-3 input-group">
                        <input type="text" name="inpfn" class="form-control" placeholder="First Name" required autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inpuid" class="col-sm-2 form-control-label">User ID</label>
                    <div class="col-sm-3 input-group">
                        <input type="password" name="inpuid" class="form-control" placeholder="User ID" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-2 col-sm-2">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php echo get_footer(); ?>
</body>
</html>
