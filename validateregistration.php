<?php
session_start();
require 'PHPMailer-master/PHPMailerAutoload.php';

require_once('config.php');

if(isset($_GET['success']) && $_GET['success'] == true) {
    include "welcome.php";
    header("refresh:5;url=/login.php");
    die();
}

$redirect = '/register.php?';
$errorredirect = $redirect;
$error = false;
$regionRestriction = "British Columbia";
$withinRegion = false;
$sendNewsletter=false;

if ($_POST) {
    $conn = get_db_connection();
    //first name validation
    $firstname = "";
    if (!isset($_POST['firstname'])) {
        $errorredirect = $errorredirect . "ferror=Missing&";
        $error = true;
    } else {
        $firstname = trim($_POST['firstname']);
        if (detectTags($firstname) || detectSpChar($firstname) || detectSpChar($firstname)) {
            $errorredirect = $errorredirect . "ferror=Invalid&";
            $error = true;
        } else {
            if(detectInvalidLength($firstname, 0, 30)) {
                $errorredirect = $errorredirect . "ferror=Length%20Invalid&";
                $error = true;
            }
        }
    }
    //last name validation
    $lastname = "";
    if (!isset($_POST['lastname'])) {
        $errorredirect = $errorredirect . "lerror=Missing&";
        $error = true;
    } else {
        $lastname = trim($_POST['lastname']);
        if (detectTags($lastname) || detectSpChar($lastname)) {
            $errorredirect = $errorredirect . "lerror=Invalid&";
            $error = true;
        } else {
            if(detectInvalidLength($lastname, 0, 30)) {
                $errorredirect = $errorredirect . "lerror=Length%20Invalid&";
                $error = true;
            }
        }
    }

    //Newsletter validation
    $newsletter = "";
    if (isset($_POST['newsletter'])) {
        $newsletter = trim($_POST['newsletter']);
        if (detectTags($newsletter) || detectSpChar($newsletter)) {
            $errorredirect = $errorredirect . "error=Invalid&";
            $error = true;
        } else {
            if (strcmp($newsletter, "yes") === 0) {
                $sendNewsletter = true;
            }
        }
    }
    //email validation
    $email = "";
    if (!isset($_POST['email'])) {
        $errorredirect = $errorredirect . "emailerror=Missing&";
        $error = true;
    } else {
        $email = trim($_POST['email']);
        if (detectTags($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorredirect = $errorredirect . "emailerror=Invalid&";
            $error = true;
        } else {
            /* IF EMAIL EXIST IN DATABASE DO SOMETHING*/


            $stmt = $conn->prepare("SELECT Email FROM User WHERE Email=:theEmail");
            $stmt->bindParam(":theEmail", $email);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if(isset($result->Email)) {
                $errorredirect = $errorredirect . "emailerror=Email%20Used&";
                $error = true;
            }

            if(detectInvalidLength($email, 0, 64)) {
                $errorredirect = $errorredirect . "emailerror=Length%20Invalid&";
                $error = true;
            }
        }
    }

    if(!isset($_POST['country'])) {
        $errorredirect = $errorredirect . "country=Missing&";
        $error = true;
    } else {
        $country = trim($_POST['country']);
        if(detectTags($country)) {
            $errorredirect = $errorredirect . "country=Invalid&";
            $error = true;
        }
    }

    if(!isset($_POST['state'])) {
        $errorredirect = $errorredirect . "state=Missing&";
        $error = true;
    } else {
        $state = trim($_POST['state']);
        if(detectTags($state)) {
            $errorredirect = $errorredirect . "state=Invalid&";
            $error = true;
        }
    }

    if(!isset($_POST['city'])) {
        $errorredirect = $errorredirect . "city=Missing&";
        $error = true;
    } else {
        $city = trim($_POST['city']);
        if(detectTags($city)) {
            $errorredirect = $errorredirect . "city=Invalid&";
            $error = true;
        }
    }

    if($regionlock == false || (isset($state) && strcmp($state, $regionRestriction) === 0)) {
        $withinRegion = true;
        if(!isset($_POST['password'])) {
            $errorredirect = $errorredirect . "password=Missing&";
            $error = true;
        } else {
            $password = $_POST['password'];
            if(detectTags($password) && detectInvalidPwd($password)) {
                $errorredirect = $errorredirect . "password=Invalid&";
                $error = true;
            } else {
                if(detectInvalidLength($password, 0, 64)) {
                    $errorredirect = $errorredirect . "password=Length%20Invalid&";
                    $error = true;
                }
            }
        }

        if(!isset($_POST['cpassword'])) {
            $errorredirect = $errorredirect . "cpassword=Missing&";
            $error = true;
        } else {
            $cpassword = $_POST['cpassword'];
            if(detectTags($password) && detectInvalidPwd($password) && strcmp($password, $cpassword) !== 0) {
                $errorredirect = $errorredirect . "cpassword=Invalid&";
                $error = true;
            }
        }

        if(isset($_POST['password']) && isset($_POST['cpassword'])) {
            if(strcmp($password, $cpassword) !== 0) {
                $errorredirect = $errorredirect . "cpassword=Password%20Not%20Matching&";
                $error = true;
            }
        }
        $schoolId = 0;
        if(!isset($_POST['school']) || empty($_POST['school'])) {
            $errorredirect = $errorredirect . "school=Missing&";
            $error = true;
        } else {
            $school = $_POST['school'];
            if(detectTags($school)) {
                $errorredirect = $errorredirect . "school=Invalid&";
                $error = true;
            } else {
                $stmt = $conn->prepare("SELECT ID FROM School WHERE SchoolName=:school AND City=:city AND StateProvince=:state AND Country=:country");
                $stmt->bindParam(":school", $school);
                $stmt->bindParam(":city", $city);
                $stmt->bindParam(":state", $state);
                $stmt->bindParam(":country", $country);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $result = $stmt->fetch(PDO::FETCH_OBJ);
                if (isset($result->ID)) {
                    $schoolId=$result->ID;
                }
            }

        }
    }



    $captcha = $_POST['captcha_code'];
    include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
    $securimage = new Securimage();

    if ($securimage->check($captcha) == false) {
        $errorredirect = $errorredirect . 'captcha_code=UEJNRKRMF&';
        $error = true;
    }

    if($error == true) {
        header('Location: ' . $errorredirect . 'firstname=' . $firstname . '&lastname=' . $lastname . '&email=' . $email);
    } else {
        if($sendNewsletter) {
            sendNewsletterEmail($firstname, $lastname, $email, $country, $state, $city);
        }
        if($regionlock == false || $withinRegion) {
            $options=[
                'cost'=>12,];
            $password=password_hash($password,PASSWORD_BCRYPT,$options);
            // register as user
            $stmt = $conn->prepare("INSERT INTO User(Password, Email, FirstName, LastName, SchoolID) VALUES (:password,
                                    :theEmail, :firstName, :lastName, (SELECT ID FROM School WHERE ID=:schoolID))");
            $stmt->bindParam(":theEmail", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":firstName", $firstname);
            $stmt->bindParam(":lastName", $lastname);
            $stmt->bindParam(":schoolID", $schoolId);
            $stmt->execute();

            //TODO send email to user telling them they successfully registered
            sendEmail($email);
            header('Location: /validateregistration.php?success=true');
        } else {
            echo $email . " " . $firstname . " " . $lastname . " " . $city . " " . $state . " " . $country;
            $stmt = $conn->prepare("INSERT INTO OutsideBC(FirstName, LastName, Country, State, City, Email) VALUES (:firstName,
                                    :lastName, :country, :state, :city, :theEmail)");
            $stmt->bindParam(":theEmail", $email);
            $stmt->bindParam(":firstName", $firstname);
            $stmt->bindParam(":lastName", $lastname);
            $stmt->bindParam(":city", $city);
            $stmt->bindParam(":state", $state);
            $stmt->bindParam(":country", $country);
            $stmt->execute();

            header('Location: /welcomeinfo.php');
        }
    }
} else {
    header('Location: ' . $errorredirect);
}

function detectSpChar($string) {
    if(preg_match('/[~`!#$%\^&*+=\-\[\]\\;,\/{}|\":<>\?]/', $string) == 1) {
        return true;
    }
    return false;
}

function detectInvalidPwd($string) {
    if(preg_match('/^[ !#$%&*+\-0-9@-Z_a-z]+$/', $string) != 1) {
        return false;
    }
    return true;
}

function detectInvalidLength($string, $min, $max) {
    if(strlen($string) > $max) {
        return true;
    }
    if(strlen($string) < $min) {
        return true;
    }
    return false;
}

function detectTags($string) {
    if($string != strip_tags($string)) {
        echo "script detected";
        return true;
    }
    return false;
}
?>