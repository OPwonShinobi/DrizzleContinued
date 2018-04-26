<?php
ob_start();
session_start();

if(!isset($_SESSION['admin'])){
    die('You are not currently login as admin, please <a href="admin_login.php">log in</a> the system to continue');
}
echo "<h2>".$_SESSION['admin']." is now logged out. Thank you.</h2><p><a href='admin_login.php'>Log in as administrator</a> again. 
	<br/>or <br/> <a href='login.php'>Log in as user</a></p>";


$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}


session_destroy();
ob_end_flush();

?>
