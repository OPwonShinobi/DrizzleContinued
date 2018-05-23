<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Successful</title>
    <link type="text/css" href="css/login.css" rel="stylesheet" media="screen">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <script src="js/timeout.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        h1, p{
            color: white;
            text-align: center;
        }

        h1 {
            font-family: 'Open Sans' , sans-serif;
            font-size: 50px;
            font-weight: 600;
            text-align: center;
            color: #FFFFFF;
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        p {
            font-size: 16px;}

        .wrap {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <img class="logo" src="images/logo2.png" draggable="false" width="20%" >
    </div>
    <div class="row">
        <div class="col-xs-offset-1 col-xs-10">
            <div class="wrap" id="welcome">
                <h1>Welcome to the <br />Youth Environmental Challenge</h1>
                <p>Your account has been successfully created! An email will be sent to you to as confirmation of your registration.</p>
                <br />
                <p>You will be redirected to the Login page in 5 seconds, or click <a href='/index.php'>here</a> if not redirected.</p>
            </div>

        </div>
    </div>
</div>

</body>
</html>
