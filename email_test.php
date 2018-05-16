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
	echo !extension_loaded('openssl')? "Openssl Not Available":"Openssl Available";
function sendNewsletterEmail($nfname, $nlname, $nemail, $ncountry, $nstate, $ncity)
{
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "yecdevnotification2@gmail.com";
    $mail->Password = "yec123!Q@W#E";
    $mail->setFrom('yecdevnotification2@gmail.com', 'Drizzle Environmental Society');
    $mail->addAddress('yecdevnotification2@gmail.com');
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
        echo "<script>console.log('Mailer Error: " . $mail->ErrorInfo ."');</script>";
    } else {
        echo "<script>console.log('You\'ve got mail!');</script>";
    }
}

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
    $mail->Username = "yecdevnotification2@gmail.com";
    $mail->Password = "yec123!Q@W#E";
    $mail->setFrom('yecdevnotification2@gmail.com', 'Drizzle Environmental Society');
    $mail->addAddress('yecdevnotification2@gmail.com');
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
    // sendNewsletterEmail($fname,$lname,$email,$country,$state,$city); 
    sendAddSchoolEmail($fname,$lname,$email,$country,$state,$city,$newschoolname, false);
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
