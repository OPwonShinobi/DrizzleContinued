<html>
<?php
session_start();
require_once('config.php');

?>
<head>
    <title>YEC Registration</title>
    <script
            src="http://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <link type="text/css" href="css/login.css" rel="stylesheet" media="screen">
    <script src="js/switch.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="js/registervalidation.js"></script>
    <script src="http://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
    <link rel="shortcut icon" href="/yec.ico" type="image/x-icon">
    <link rel="icon" href="/yec.ico" type="image/x-icon">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <a href="login.php">
            <img class="logo" src="images/logo2.png" draggable="false" width="200px">
        </a>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="wrap">
                <p id="register-title">Registration</p>
                <!--START OF THE FORM-->
                <form method="post" class="registration" action="validateregistration.php" onsubmit="return validateregistration();">
                    <!--FIRST NAME START-->
                    <div class="form-group">
                        <?php
                        if (isset($_GET)) {
                            if(isset($_GET['firstname'])) {
                                echo '<input type="text" name="firstname" id="firstname" class="form-control nospchar flname" placeholder="First Name" value="' . $_GET['firstname']. '">';
                            } else {
                                echo '<input type="text" name="firstname" id="firstname" class="form-control nospchar flname" placeholder="First Name">';
                            }
                            if(isset($_GET['ferror'])) {
                                echo '<p id="firstnameerror" class="errormessage" style="color: red; display: block;">' . $_GET['ferror'] . '</p>';
                            } else {
                                echo '<p id="firstnameerror" class="errormessage" style="color: red; display: none;"></p>';
                            }
                        }
                        ?>
                    </div>
                    <!--FIRST NAME END-->
                    <!--LAST NAME START-->
                    <div class="form-group">
                        <?php
                        if (isset($_GET)) {
                            if(isset($_GET['lastname'])) {
                                echo '<input type="text" name="lastname" id="lastname" class="form-control nospchar flname" placeholder="Last Name" value="' . $_GET['lastname']. '">';
                            } else {
                                echo '<input type="text" name="lastname" id="lastname" class="form-control nospchar flname" placeholder="Last Name">';
                            }
                            if(isset($_GET['lerror'])) {
                                echo '<p id="lastnameerror" class="errormessage" style="color: red; display: block;">' . $_GET['lerror'] . '</p>';
                            } else {
                                echo '<p id="lastnameerror" class="errormessage" style="color: red; display: none;"></p>';
                            }
                        }
                        ?>
                    </div>
                    <!--LAST NAME END-->
                    <!--EMAIL START-->
                    <div class="form-group">
                        <?php
                        if(isset($_GET['email'])) {
                            echo '<input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" value="' . $_GET['email']. '">';
                        } else {
                            echo '<input type="email" class="form-control" id="email" name="email" placeholder="email@example.com">';
                        }
                        if (isset($_GET)) {
                            if(isset($_GET['emailerror'])) {
                                echo '<p id="emailerror" class="errormessage" style="color: red; display: block;">' . $_GET['emailerror'] . '</p>';
                            } else {
                                echo '<p id="emailerror" class="errormessage" style="color: red; display: none;"></p>';
                            }
                        }
                        ?>
                    </div>
                    <!--EMAIL END-->
                    <!--COUNTRY START-->
                    <div class="form-group">
                        <select name="country" class="form-control countries order-alpha" id="countryId" required>
                            <option value="">Select Country</option>
                            <option value="" disabled>&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;</option>
                        </select>
                    </div>
                    <!--COUNTRY END-->
                    <!--STATE START-->
                    <div class="form-group">
                        <select name="state" class="form-control states order-alpha" id="stateId" required>
                            <option value="">Select Province/State</option>
                        </select>
                    </div>
                    <!--STATE END-->
                    <!--City START-->
                    <div class="form-group">
                        <select name="city" class="form-control cities order-alpha" id="cityId" required>

                            <option value="">Select City</option>
                        </select>
                    </div>
                    <!--CITY END-->
                    <script src="https://geodata.solutions//includes/countrystatecity.js"></script>
                    <script type="text/javascript">

                    $(document).ready(function(){
                        var pwd = $('#password');
                        var cpwd = $('#cpassword');
                        var schooldiv = $('.school');
                        var schoolselect = $('#schoolid');

                        // if ($('select[name=state]').val() == 'British Columbia')
                        // {
                        pwd.attr('type', 'password');
                        pwd.prop("required", true);
                        cpwd.attr('type', 'password');
                        cpwd.prop("required", true);
                        schoolselect.prop("required", true);
                        schooldiv.css("display", "block");
                        // } else {
                        //     pwd.attr('type', 'hidden');
                        //     pwd.prop("required", false);
                        //     $("#passworderror").css("display", "none");
                        //     cpwd.attr('type', 'hidden');
                        //     cpwd.prop("required", false);
                        //     $("#cpassworderror").css("display", "none");
                        //     schooldiv.css("display", "none");
                        //     schoolselect.prop("required", false);
                        schoolselect.change(
                            function()
                            {
                                $('#NewSchoolName').css("display", "none");
                                if (schoolselect.val() == 'unsupported') 
                                {
                                    $('#NewSchoolName').css("display", "block");
                                }
                            }    
                        )
                    });
                    </script>
                    <!--PASSWORD START-->
                    <div class="form-group pwd" >
                        <input type="hidden" class="form-control pwd_allowedchar" id="password"
                               placeholder="Enter password (a-Z, 0-9, _!#$%&*+-@)"
                               name="password">
                        <?php
                        if (isset($_GET)) {
                            if(isset($_GET['password'])) {
                                echo '<p id="passworderror" class="errormessage" style="color: red; display: none;">' . $_GET['password'] . '</p>';
                            } else {
                                echo '<p id="passworderror" class="errormessage" style="color: red; display: none;"></p>';
                            }
                        }
                        ?>
                    </div>
                    <!--PASSWORD END-->
                    <!--CONFIRM PASSWORD START-->
                    <div class="form-group pwd" >
                        <input type="hidden" class="form-control" id="cpassword"
                               placeholder="Confirm your password"
                               name="cpassword">
                        <?php
                        if (isset($_GET)) {
                            if(isset($_GET['cpassword'])) {
                                echo '<p id="cpassworderror" class="errormessage" style="color: red; display: none;">' . $_GET['cpassword'] . '</p>';
                            } else {
                                echo '<p id="cpassworderror" class="errormessage" style="color: red; display: none;"></p>';
                            }
                        }
                        ?>
                    </div>
                    <!--CONFIRM PASSWORD END-->
                    <!--SCHOOL START-->
                    <div class="form-group school" style="display:none">
                        <select name="school" class="form-control" id="schoolid">
                            <option value="">Select School</option>
                            <script>
                                function refresh_school_table(){
                                    $.ajax({
                                        type: "POST",
                                        url: "/querydata.php",
                                        data: {
                                            QueryData: 'getAllSchoolsByCity',
                                            Country: $("#countryId option:selected").text(),
                                            StateProvince: $("#stateId option:selected").text(),
                                            City: $("#cityId option:selected").text()
                                        },
                                        dataType: 'JSON',
                                        success: function(data){
                                            //console.log(data);
                                            if (data != "undefined" && data != null)
                                            {
                                                update_school_table(data);
                                            }
                                        },
                                        error: function(data){
                                            console.log(data);
                                        }
                                    });
                                }

                                function update_school_table(data) {
                                    $("#schoolid").empty();
                                    $("#schoolid").append($('<option>', {
                                        value: '',
                                        text: 'Select School'
                                    }));
                                    for (school of data) {
                                        //console.log(school);
                                        $("#schoolid").append($('<option>', {
                                                value: school['SchoolName'],
                                                text: school['SchoolName']
                                            }));
                                    }
                                    $("#schoolid").append($('<option>', 
                                    {
                                        value: 'unsupported',
                                        text: 'Choose this if your school isn\'t in the list'
                                    }));
                                }
                            </script>
                        </select>
                        <input type="text" id="NewSchoolName" class="form-control" name="NewSchoolName" placeholder="Enter your school's full name here" style="display: none">
                        <!-- legacy code, this p not needed but will break stuff if left out -->
                        <p id="NewSchoolNameerror"></p>
                    <br/>
                    <p style="color:white"><small>If your school is not listed, please enter it above and click register, or find us on social media to have it added to our system. You can also email us at <?php echo INFO_EMAIL;?>.</small></p>
                    </div>
                    <!--SCHOOL END-->
                    <hr/>
                    <!--CAPTCHA START-->
                    <div class="form-group text-center">
                        <input type="text" class="form-control" name="captcha_code" id="captcha_code" size="10" maxlength="6" placeholder="Insert CAPTCHA"/>
                        <p id="captcha_codeerror" class="errormessage" style="color: red; display: none;">CAPTCHA incorrect</p>
                        <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Try a Different Image ]</a>
                        <p><br></p>
                        <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                    </div>
                    <!--CAPTCHA END-->
                    <!--NEWSLETTER START-->
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="newsletter" name="newsletter" value="yes">
                            <big>Sign up for our Newsletter</big>
                            <p id="newslettererror"></p>
                        </label>
                    </div>
                    <!--NEWSLETTER END-->
                    <!--SUBMIT BUTTON-->
                    <input type="submit" value="Sign Up" class="btn btn-success btn-sm" />
                    <!--END OF SUBMIT BUTTON-->
                    <script src="js/registervalidation.js"></script>
                    <!-- <input type="button" id="login-page" value="Login" class="btn  btn-default btn-sm reg" /> -->
                </form>
            <!--END OF FORM-->
            </div>
        </div>
    </div>

</div>
</body>
<?php
if(isset($_GET['captcha_code'])) {
    echo "<script>";

    echo "var captchafield = document.getElementById('captcha_codeerror');";
    echo "captchafield.style.display='block';";

    echo "</script>";
}
?>
<script>
    $(document).ready(function () {
        $('#cityId').change(function () {
            refresh_school_table();
        });
        var get = document.getElementsByTagName('input');
        for (i = 0; i < get.length; i++) {
            get[i].addEventListener('change', errorReset, false);
        }
    });
    function errorReset() {
        this.style.borderColor='#FFFFFF';
        var inputfield = this.getAttribute('name');
        var errorp = document.getElementById(inputfield + "error");
        errorp.style.display='none';
    }
</script>

</html>
