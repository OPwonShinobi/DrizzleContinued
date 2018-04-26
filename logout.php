<?php
ob_start();
session_start();

if(!isset($_SESSION['Userid'])){
    header('Location: /login.php');
}

echo "<h2>".$_SESSION['Username']." is now logged out. Thank you.</h2><p><a href='login.php'>Log in</a> again.</p>";


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
header('Location: /login.php');
?>
