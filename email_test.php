<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link type="text/css" href="css/login.css" rel="stylesheet" media="screen">
<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer-master/vendor/autoload.php';

    $mail = new PHPMailer; 
    $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
//Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "yecdevnotification2@gmail.com";
//Password to use for SMTP authentication
    $mail->Password = "yec123!Q@W#E";
//Set who the message is to be sent from
    $mail->setFrom('yecdevnotification2@gmail.com', 'Drizzle Environmental Society');
    $mail->addAddress("xiaalex1998@gmail.com");
//Set the subject line
    $mail->Subject = 'Test Email';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

    $mail->IsHTML(true);
    $content=
        '<html>'
        .'<div style="width: 100%;background-color:black;text-align: center;margin:10px;">'
        .'<div style="color:white">'
        .'<img style="width:200px" src="https://static1.squarespace.com/static/53f3ac53e4b02d7a9a62a7a2/t/5521b927e4b0562b85263cf2/1493590962286/">'
        .'<h1>Line 1.</h1>'
        .'<h2>Line 2</h2>'
        .'<p>Pararagi</p>'
        .'<a href="#" style="color:#2ecc71">info@drizzlesociety.org</a>'
        .'</div>'
        .'</div>'
        .'</html>';
    $mail->Body = $content;
    $mail->AltBody = 'Alt body????';
//Attach an image file

    if (!$mail->send()) {
        echo "<script>console.log('Mailer Error: " . $mail->ErrorInfo ."');</script>";
    } else {
        echo "<script>console.log('You\'ve got mail!');</script>";
    }
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <!-- <script src="js/timeout.js"></script> -->
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
                <p>You will be redirected to the Login page in 5 seconds, or click <a href='/login.php'>here</a> if not redirected.</p>
            </div>

        </div>
    </div>
</div>

</body>
</html>
