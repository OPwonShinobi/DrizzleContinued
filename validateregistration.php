<?php
session_start();
require_once('config.php');
/*This page is used by welcome.php for checking user input. It's the only file besides querydata that runs sql, mainly for things like checking if email is taken or adding a new user. */

if(isset($_GET['success']) && $_GET['success'] == true) {
    header("Location: welcome.php");
    exit;
}

$redirect = '/register.php?';
$errorredirect = $redirect;
$error = false;
$withinRegion = false;
$sendNewsletter=false;
$newSchoolToAdd=false;

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
    //specific query, see if specific region added to db regionlock table
    $stmt = $conn->prepare("SELECT CountryName, RegionName FROM RegionLock WHERE CountryName=:userCountry AND RegionName=:userState" );
    $stmt->bindParam(":userCountry", $country);
    $stmt->bindParam(":userState", $state);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetch();
    //specific region been added to table
    if( isset($result['RegionName']) ) {
        $withinRegion = true;
    //specific region not been added to table
    } else {
        //general query, see if specific region added to db regionlock table
        $stmt = $conn->prepare("SELECT CountryName FROM RegionLock WHERE CountryName=:userCountry AND RegionName = 'ALL'" );
        $stmt->bindParam(":userCountry", $country);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        //general country been added to regionlock 
        if( isset($result['CountryName']) ) {
            $withinRegion = true;
        } else {
            //world-wide regionlock, added at client request
            $stmt = $conn->prepare("SELECT * FROM RegionLock WHERE CountryName='ALL'" );
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();
            //all countries are added as region lock
            if( isset($result['CountryName']) )
                $withinRegion = true;
        }
    }

    // originally school checking was only for within region lock
    // but since the option to add a school exists for all schools, the new user might expect an email
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
            } else {
                // new school means outside region lock, but need actual region 
                // lock status for email to admin
                // $withinRegion = false;
                $newSchoolToAdd = true;
            }
        }
    }
    if( $withinRegion ) {
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
        // regardless if new school in regionlock, dont add account
        if( $newSchoolToAdd ) {
            sendAddSchoolEmail($firstname, $lastname, $email, $country, $state, $city, $_POST['NewSchoolName'], $withinRegion);
            $withinRegion = false;
        }
        if ( $withinRegion ) {
            $options=['cost'=>12];
            $password=password_hash($password,PASSWORD_BCRYPT,$options);
            // register as user
            $stmt = $conn->prepare("INSERT INTO User(Password, Email, FirstName, LastName, NickName, SchoolID) VALUES (:password, :theEmail, :firstName, :lastName, :nickName ,(SELECT ID FROM School WHERE ID=:schoolID))");
            $stmt->bindParam(":theEmail", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":firstName", $firstname);
            $stmt->bindParam(":lastName", $lastname);
            $nickName = $firstname." ".$lastname;
            $stmt->bindParam(":nickName", $nickName);
            $stmt->bindParam(":schoolID", $schoolId);
            $stmt->execute();

            sendEmail($email);
            $stmt = $conn->prepare("SELECT ID FROM User WHERE Email=:theEmail");
            $stmt->bindParam(":theEmail", $email);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();
            $_SESSION['Userid'] = $result['ID'];
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (60 * 60);

            header('Location: /validateregistration.php?success=true');
        }
        // outside of region lock or school wasnt added in db yet
        if( !$withinRegion ) {
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