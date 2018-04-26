<?php 
session_start();
require_once('config.php');
$check_auth = false;
if ($_POST) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$conn = get_db_connection();

	$stmt = $conn->prepare("SELECT Username, Password FROM Admin WHERE Email=:theEmail");
	$stmt->bindParam(":theEmail", $email);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC); 
	$result = $stmt->fetch();
	$username = $result['Username'];
	$hash = $result['Password'];

	if (password_verify($password, $hash)){
		$_SESSION['admin'] = $username;
		$check_auth = true;
		$auth = true;
		header('Location: /admin.php');
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
		<title>Title</title>
		<link type="text/css" href="css/login.css" rel="stylesheet" media="screen">
        <link rel="shortcut icon" href="/yec.ico" type="image/x-icon">
        <link rel="icon" href="/yec.ico" type="image/x-icon">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<img class="logo" src="images/logo2.png" draggable="false" width="20%" >
			</div>
				<div class="row">
					<div class="col-md-12">
						<div class="wrap">
							<p class="form-title">
							Admin Login</p>
							<form class="login" action="admin_login.php"  method="POST">
<?php
if ($check_auth && !$auth)
	echo '<div class="row accounterror"><p>Incorrect id or password.</p></div>';
?>
						 <input type="email" placeholder="Email" name="email"/>
						 <input type="password" placeholder="Password" name="password"/>

						 <input type="submit" value="Login" class="btn btn-success btn-sm" />
						 <div class="remember-forgot">
							 <div class="row">
								 <div class="col-md-6">
									 <div class="checkbox">
										 <label>
											 <input type="checkbox" />
											 Remember Me
										 </label>
									 </div>
								 </div>
								 <div class="col-md-6 forgot-pass-content">
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
</html>
