<?php
/* Change these constants when Drizzle emails update */
//all emails sent from this address
define("SERVER_EMAIL", "yecdevnotification@gmail.com");
//pw for above email
define("SERVER_EMAIL_PW", "yec123!Q@W#E");
//newsletter subscriber requests are sent here
define("NEWSLETTER_EMAIL", "yecdevnotification@gmail.com");
//add school requests requests are sent here
define("INFO_EMAIL", "yecdevnotification@gmail.com");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/vendor/autoload.php';
define("DB_HOST", "localhost");
define("DB_USER", "yecuser");
define("DB_PASSWORD", "yec123!Q@W#E");
define("DB_DATABASE", "yecdata");
// '$2y$12$ZdrjTKpRo0UnQ6wyYBYZmOo5dW5ZZQZJTTfd4M9ulvyWt57J3fLMi' pw hash used for badword dict

function get_db_connection() {
	try {
		$conn = new PDO("mysql:host=".DB_HOST .";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
}

//call this to send welcome email to newly created user
function sendEmail($toemail)
{
//Create a new PHPMailer instance
    $mail = new PHPMailer;
//Tell PHPMailer to use SMTP
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
    //$mail->Username = "notetomecomp3975@gmail.com";
    $mail->Username = "yecdevnotification@gmail.com";
//Password to use for SMTP authentication
    //$mail->Password = "comp3975";
    $mail->Password = "yec123!Q@W#E";
//Set who the message is to be sent from
    $mail->setFrom('yecdevnotification@gmail.com', 'Drizzle Environmental Society');
    $mail->addAddress("$toemail");
//Set the subject line
    $mail->Subject = 'Welcome to the Youth Environmental Challenge';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

    $mail->Body = '<!DOCTYPE html>';
    $mail->Body .='<html>';
    $mail->Body .='<head>';
        $mail->Body .='</head>';
        $mail->Body .='<body>';
          $mail->Body .='<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">';
          $mail->Body .='<div style="width: 100%; text-align:center; background: #222222;">';
            $mail->Body .='<div style="display:inline-block; text-align: center; font-family: \'Roboto\', sans-serif; width: 400px;  color: white; margin: 0 auto;">';
              $mail->Body .='<img style="width:200px" src="https://static1.squarespace.com/static/53f3ac53e4b02d7a9a62a7a2/t/5521b927e4b0562b85263cf2/1493590962286/">';
              $mail->Body .='<h1>Thank You For Joining The Movement For A Greener Future Led By Youth Action!</h1>';
              $mail->Body .='<p>Your account has now been created!</p>';
              $mail->Body .='<p>You can now log in with your new account to track your environmental impact online!</p>';
              $mail->Body .='<br />';
              $mail->Body .='<p>If you did not create an account for the Youth Environmental Challenge, please contact Drizzle Environmental Society at info@drizzlesociety.org</p>';
              $mail->Body .='<br />';
            $mail->Body .='</div>';
          $mail->Body .='</div>';
        $mail->Body .='</body>';
    $mail->Body .='</html>';

$mail->AltBody = 'Thank You For Registering To Youth Environmental Challenge. Your account has now been created! You can now log in with your new account to track your environmental impact online!';
//Attach an image file

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        header('Location: /login.php');
    }
}

/*
This function sends a pw retrieval code to a user 
trying to reset pw. It should only be called right after
generating the pw retrieval code.
*/
function forgotPass($toemail,$code)
{
//Create a new PHPMailer instance
    $mail = new PHPMailer;
//Tell PHPMailer to use SMTP
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
    $mail->Username = "yecdevnotification@gmail.com";
//Password to use for SMTP authentication
    $mail->Password = "yec123!Q@W#E";
//Set who the message is to be sent from
    $mail->setFrom('yecdevnotification@gmail.com', 'Drizzle Environmental Society');
    $mail->addAddress("$toemail");
//Set the subject line
    $mail->Subject = 'Drizzle Environmental Society Account Password Reset';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

    $mail->IsHTML(true);
    $content=
        '<html>'
		.'<div style="width: 100%;background-color:black;text-align: center;margin:10px;">'
        .'<div style="color:white">'
        .'<img style="width:200px" src="https://static1.squarespace.com/static/53f3ac53e4b02d7a9a62a7a2/t/5521b927e4b0562b85263cf2/1493590962286/">'
        .'<h1>Please use this Reset Code to reset your password.</h1>'
        .'<h2>This is your temporary reset code '.'<b style="color:#2ecc71">'.$code.'</b>'.'</h2>'
        .'<p>If you have any questions, please contact us.</p>'
        .'<a href="#" style="color:#2ecc71">info@drizzlesociety.org</a>'
        .'</div>'
        .'</div>'
        .'</html>';
    $mail->Body = $content;
    $mail->AltBody = 'This is your temporary reset code '.'<b>'.$code.'</b>';
//Attach an image file

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        header('Location: /password-reset.php');
    }
}

/*
Sends a email to the admin alerting them a new user
has requested to be added to the newsletter mailing list.
Email sent to admin will include all important user information.

*Note: the user need not be in region lock / have a YEC account
to receive newsletters.
*/
function sendNewsletterEmail($nfname, $nlname, $nemail, $ncountry, $nstate, $ncity)
{
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "yecdevnotification@gmail.com";
    $mail->Password = "yec123!Q@W#E";
    $mail->setFrom('yecdevnotification@gmail.com', 'Drizzle Environmental Society');
    $mail->addAddress('xiaalex1998@gmail.com');
    $mail->Subject = '[Yec Automated Newsletter Subscriber Request]';
    $mail->Body = '<!DOCTYPE html>';
    $mail->Body .='<html>';
    $mail->Body .='<head>';
    $mail->Body .='</head>';
    $mail->Body .='<body>';
    $mail->Body .='<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">';
    $mail->Body .='<div style="width: 100%; text-align:left;">';
    $mail->Body .='<div style="display:inline-block; text-align: left; font-family: \'Roboto\', sans-serif; width: 100%; color: black;">';
    $mail->Body .='<h1>Add User To Newsletter</h1>';
    $mail->Body .="<p>First Name: $nfname</p>";
    $mail->Body .="<p>Last Name: $nlname</p>";
    $mail->Body .="<p>Email: $nemail</p>";
    $mail->Body .="<p>Country: $ncountry</p>";
    $mail->Body .="<p>State/Province: $nstate</p>";
    $mail->Body .="<p>City: $ncity</p>";
    $mail->Body .='<br />';
    $mail->Body .='</div>';
    $mail->Body .='</div>';
    $mail->Body .='</body>';
    $mail->Body .='</html>';

    $mail->AltBody = "[Automated message]\nPlease add this person to newsletter mailing list:\n firstname: $nfname\n lastname: $nlname\n email: $nemail\n country: $ncountry\n state: $nstate\n city: $ncity";

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } /*else {
        header('Location: /index.php');
    }*/
}

/*
Sends a email to the admin alerting them a new user
has requested their school to be added to the database
(admin can do this from admin.php)
Email sent to admin will include all important user information,
including if user is in region lock.

*Note: the user will not have an YEC account as their school isn't
in the database.
*/
function sendAddSchoolEmail($nfname, $nlname, $nemail, $ncountry, $nstate, $ncity, $nnewschoolname, $nwithinregionlock)
{
    $nwithinregion = $nwithinregionlock ? "TRUE" : "FALSE";
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "yecdevnotification@gmail.com";
    $mail->Password = "yec123!Q@W#E";
    $mail->setFrom('yecdevnotification@gmail.com', 'Drizzle Environmental Society');
    $mail->addAddress('xiaalex1998@gmail.com');
    $mail->Subject = '[Yec Automated Add School Request]';
    $mail->Body = '<!DOCTYPE html>';
    $mail->Body .='<html>';
    $mail->Body .='<head>';
    $mail->Body .='</head>';
    $mail->Body .='<body>';
    $mail->Body .='<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">';
    $mail->Body .='<div style="width: 100%; text-align:left;">';
    $mail->Body .='<div style="display:inline-block; text-align: left; font-family: \'Roboto\', sans-serif; width: 100%px;  color: black; margin: 0; padding: 0;">';

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
        echo "Mailer Error: " . $mail->ErrorInfo;
    }/* else {
        header('Location: /index.php');
    }*/
}


?>
