<?php
session_start();
require_once('config.php');
$check_auth = false;

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = get_db_connection();

    $stmt = $conn->prepare("SELECT ID, Nickname, Password FROM User WHERE Email=:theEmail");
    $stmt->bindParam(":theEmail", $email);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $result = $stmt->fetch();

    // uses php's built-in hashing function to check pw hash & db-stored hash is same
    if (password_verify($password, $result['Password'])) {
        $_SESSION['Userid'] = $result['ID'];
		$_SESSION['Username'] = $result['Nickname'];
        $check_auth = true;
        $auth = true;
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (60 * 60);
        header('Location: /index.php');
    } else {
        $check_auth = true;
        $auth = false;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Youth Environmental Challenge</title>
    <link type="text/css" href="css/login.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" href="/yec.ico" type="image/x-icon">
    <link rel="icon" href="/yec.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <script src="js/switch.js"></script>
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <a href="welcomeinfo.php">
        <img class="logo" src="images/logo2.png" draggable="false" width="200px" >
        </a>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="wrap">
                <p class="form-title">
                    Login and Registration</p>
                <form class="login" action="login.php"  method="POST">
                    <?php
                    if ($check_auth && !$auth)
                        echo '<div class="row accounterror"><p>Incorrect id or password.</p></div>';
                    ?>
                    <input type="email" placeholder="Email" name="email" />
                    <input type="password" placeholder="Password" name="password" />
                    <input type="submit" value="Login" class="btn btn-success btn-sm" />
                    <input type="button" id="registration-page" value="Register" class="btn  btn-default btn-sm reg" />
                    <div class="remember-forgot">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" />
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 forgot-pass-content">
                                <a href="password-forgot.php" class="forgot-pass">Forgot Password</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

</body>
<footer>
    <div class="container">
        <div class="row">
            <ul id="share-button">
                <li><a href="https://twitter.com/DrizzleOrg"><i class="fa fa-twitter-square fa-3x"></i></a></li>
                <li><a href="https://www.facebook.com/drizzleorg?_rdr=p"><i class="fa fa-facebook-square fa-3x"></i></a></li>
                <li><a href="https://www.instagram.com/drizzlesociety/"><i class="fa fa-instagram fa-3x"></i></a></li>
            </ul>
            <p>© 2017<a style="color:#0a93a6; text-decoration:none;" href="#"> Drizzle Environmental Society</a>, All rights reserved 2017.</p>

        </div>
    </div>
</footer>
</html>
