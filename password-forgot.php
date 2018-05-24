<?php
//require 'PHPMailer-master/PHPMailerAutoload.php';

session_start();
require_once('config.php');
$check_auth = false;

if ($_POST) {
    $email = $_POST['email'];
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT ID, Email FROM User WHERE Email=:theEmail");
    $stmt->bindParam(":theEmail", $email);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetch();
    $userid = $result['ID'];
    $emailToBeSent = $result['Email'];
    if ($emailToBeSent  ==  $email){
        $check_auth = true;
        $auth = true;
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $urlToEmail = 'http://example.com/reset.php?'.http_build_query([
                'selector' => $selector,
                'validator' => bin2hex($token)
            ]);
        $expires = new DateTime('NOW');
        $expires->add(new DateInterval('PT01H')); // 1 hour
        $stmt = $conn->prepare("INSERT INTO Forgot (Email, selector,  expires) VALUES (:email, :selector, :expires)
                                ON DUPLICATE KEY UPDATE selector=:selector, expires=:expires;");
        $stmt->bindParam(":email", $email);
        $selector = hash('sha256', $selector);
        $stmt->bindParam(":selector", $selector);
        $expires = $expires->format('Y-m-d\TH:i:s');
        $stmt->bindParam(":expires", $expires);
        $stmt->execute();

        forgotPass($email, $selector);
    }else{
        $check_auth = true;
        $auth = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link type="text/css" href="css/login.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" href="/yec.ico" type="image/x-icon">
    <link rel="icon" href="/yec.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <script src="js/forgot.js"></script>
    <script src="js/switch.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <img src="images/logo2.png" width="20%">
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="wrap">
                <p class="form-title">
                    Forgot Password</p>
                <form class="registration" action="password-forgot.php" onsubmit="return validateForm()" method="POST" name="forgotform">
                    <?php
                    if ($check_auth && !$auth)
                        echo '<div class="row accounterror"><p>Invalid Email.</p></div>';
                    ?>
                    <div id="forgot-empty" class="row accounterror" style="display: none"><p>Empty Input.</p></div>
                    <input id="email-input" type="email" name="email" class="form-control" placeholder="Enter your email" />
                    <input type="submit" value="Reset" class="btn btn-success btn-sm" />
                    <a href="login.php"><input type="button" value="Login" class="btn  btn-default btn-sm reg" /></a>
                    <a href="register.php"><input type="button"value="Register" class="btn  btn-default btn-sm reg" /></a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>