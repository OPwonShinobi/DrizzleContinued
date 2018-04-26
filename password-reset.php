<?php
session_start();
require_once('config.php');
$resetcorrect=true;
if ($_POST) {

    $email = trim($_POST['email']);
    $resetcode = trim($_POST['resetcode']);
    $newpass = trim($_POST['password']);
    $confirmpass = trim($_POST['cpassword']);

    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT selector, Email FROM Forgot WHERE Email=:theEmail;");

    $stmt->bindParam(":theEmail", $email);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetch();

    $dbcode = $result['selector'];
    $dbemail = $result['Email'];

    $hashreset=hash('sha256', $resetcode);

    if (strcmp($hashreset, $dbcode)==0){
        $options=[
            'cost'=>12,];
        $passwordhash=password_hash($newpass,PASSWORD_BCRYPT,$options);
        $stmt = $conn->prepare("UPDATE User SET Password=:password WHERE Email=:thisEmail;");
        $stmt->bindParam(":password",$passwordhash );
        $stmt->bindParam(":thisEmail", $email);
        $stmt->execute();

        $stmt= $conn->prepare("DELETE FROM Forgot WHERE Email=:thisEmail");
        $stmt->bindParam(":thisEmail", $email);
        $stmt->execute();
        header('Location: /login.php');
    }
    else{
        $resetcorrect=false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password Code</title>
    <link type="text/css" href="css/login.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" href="/yec.ico" type="image/x-icon">
    <link rel="icon" href="/yec.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <script src="js/switch.js"></script>
    <!-- Latest compiled and minified CSS -->
    <script src="http://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
    <script src="js/registervalidation.js"></script>
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
                    Reset Password</p>
                <form class="registration" action="password-reset.php"  method="POST">
                    <div class="form-group">
                        <input type="email" class="form-control" id="email"
                               name="email" placeholder="email@example.com">
                        <p id="emailerror" class="errormessage" style="color: red; display: none;"></p>
                    </div>
                    <div class="form-group pwd" >
                        <input type="password" class="form-control" id="password"
                               placeholder="Enter your password"
                               name="password">
                        <p id="passworderror" class="errormessage" style="color: red; display: none;"></p>
                    </div>
                    <div class="form-group pwd" >
                        <input type="password" class="form-control" id="cpassword"
                               placeholder="Confirm your password"
                               name="cpassword">
                        <p id="cpassworderror" class="errormessage" style="color: red; display: none;"></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="reset"
                               name="resetcode" placeholder="Enter your reset code">
                        <?php
                        if (!$resetcorrect)
                            echo'
                                <p id="reset-code" class="errormessage" style="color: red">Incorrect reset code.</p>
                                ';
                        ?>
                    </div>
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