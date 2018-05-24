<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Test</title>
<?php 
// visit this page to make sure email client is running
// see config.php for what these constants mean
define("SERVER_EMAIL", "yecdevnotification@gmail.com");
define("SERVER_EMAIL_PW", "yec123!Q@W#E");
define("NEWSLETTER_EMAIL", "yecdevnotification@gmail.com");
define("INFO_EMAIL", "yecdevnotification@gmail.com");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/vendor/autoload.php';
echo !extension_loaded('openssl')? "Openssl Not Available<br>":"Openssl Available<br>";

function sendAddSchoolEmail($nfname, $nlname, $nemail, $ncountry, $nstate, $ncity, $nnewschoolname, $nwithinregionlock)
{
    $nwithinregion = $nwithinregionlock ? "TRUE" : "FALSE";
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->SMTPAutoTLS = false;
    
    $mail->Username = SERVER_EMAIL;
    $mail->Password = SERVER_EMAIL_PW;
    $mail->setFrom(SERVER_EMAIL, 'Drizzle Environmental Society');
    $mail->addAddress(INFO_EMAIL);
    $mail->Subject = '[Yec Automated Add School Request]';
    $mail->Body = '<!DOCTYPE html>';
    $mail->Body .='<html>';
    $mail->Body .='<head>';
    $mail->Body .='</head>';
    $mail->Body .='<body>';
    $mail->Body .='<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">';
    $mail->Body .='<div style="width: 100%; text-align:left;">';
    $mail->Body .='<div style="display:inline-block; text-align: left; font-family: \'Roboto\', sans-serif; width: 100%;  color: black; margin: 0; padding: 0;">';

    $mail->Body .='<h1>A new user wants their school added</h1>';
    $mail->Body .="<h3>School Name: $nnewschoolname</h3>";
    $mail->Body .="<h3>Inside regionlock? $nwithinregion</h3>";
    $mail->Body .="<p>Country: $ncountry</p>";
    $mail->Body .="<p>State/Province: $nstate</p>";
    $mail->Body .="<p>City: $ncity</p>";
    $mail->Body .='<br />';
    $mail->Body .="<p>Submitted by:</p>";
    $mail->Body .="<p>First Name: $nfname</p>";
    $mail->Body .="<p>Last Name: $nlname</p>";
    $mail->Body .="<p>Email: $nemail</p>";
    $mail->Body .='<br />';
    $mail->Body .='</div>';
    $mail->Body .='</div>';
    $mail->Body .='</body>';
    $mail->Body .='</html>';

    $mail->AltBody = "[Automated message]\nA new user wants their school added\nSchool info:\nname: $nnewschoolname\ninside regionlock?: $nwithinregion\ncountry: $ncountry\nregion: $nstate\ncity: $ncity\n\nUser info:\nfirst name: $nfname\nlast name: $nlname\nemail: $nemail";
    if (!$mail->send()) {
        echo "<script>console.log('Mailer Error: " . $mail->ErrorInfo ."');</script>";
    } else {
        echo "<script>console.log('You\'ve got mail!');</script>";
    } 
}

    $newschoolname = "Test University";
    $country = "China";
    $state = "Beijin";
    $city = "Beijin City";
    $fname = "Test first";
    $lname = "Test last";
    $email = "test@test.test";
    sendAddSchoolEmail($fname,$lname,$email,$country,$state,$city,$newschoolname, false);
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <!-- <script src="js/timeout.js"></script> -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
    	body {
    		background: url("");
    	}
    </style>
</head>
<body>

</body>
</html>
