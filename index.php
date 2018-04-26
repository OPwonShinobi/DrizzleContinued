<?php
session_start();
require_once('config.php');
if (!isset($_SESSION['Userid'])){
    header('Location: login.php');
}
$now = time();
if ($now > $_SESSION['expire']) {
    header('Location: logout.php');
}


$conn = get_db_connection();
$stmt = $conn->prepare("SELECT PhotoId, Nickname FROM User WHERE ID=:theID");
$stmt->bindParam(":theID", $_SESSION['Userid']);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetch();
$_SESSION['PhotoId']=$result['PhotoId'];
$_SESSION['Username'] = $result['Nickname'];

if ($_POST) {
    $pd=$_POST['pid'];
    $nick = trim($_POST['nickname']);
    $conn = get_db_connection();
    $stmt = $conn->prepare("UPDATE User SET PhotoID=:pd,NickName=:nickn WHERE ID=:theID;");
    $stmt->bindParam(":pd", $pd);
    $stmt->bindParam(":nickn", $nick);
    $stmt->bindParam(":theID", $_SESSION['Userid']);
    $stmt->execute();
    header('Location: /index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Youth Environmental Challenge</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="/yec.ico" type="image/x-icon">
    <link rel="icon" href="/yec.ico" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/js/comparewithinschool.js"></script>`
	<script src="/js/comparewithincity.js"></script>
	<script src="/js/comparewithinstate.js"></script>
	<script src="/js/comparewithincountry.js"></script>
	<script src="/js/compareschool.js"></script>
	<script src="/js/tabcontrol.js"></script>
    <?php
    echo "<script>var Userid = $_SESSION[Userid];
              var Photoid =$_SESSION[PhotoId];

</script>
"?>
</head>

<body>
<!-- Profile -->
<div id="wrapper">
    <!-- Notification -->
    <div id="notificationbar" class="row">

    </div>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"> <span class="fontStyle"> Welcome  </span></a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">


            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo ' '.$_SESSION['Username'].' '; ?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#profileModal"><i  class="fa fa-fw fa-user" ></i> Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a id="link_dashboard_tab" data-toggle="tab" href="#row_user_dashboard"><i class="fa fa-fw fa-home"></i> Dashboard</a>
                </li>

                <li>
                    <a id="link_my_action_tab" data-toggle="tab" href="#row_user_myaction" onclick="get_myaction_table()"><i class="fa fa-fw fa-heart-o"></i> My Actions</a>
                </li>
                <li>
                    <a id="link_all_action_tab" data-toggle="tab" href="#row_user_allAction"><i class="fa fa-fw fa-tasks"></i> All Actions</a>
                </li>

                <li>
                    <a data-toggle="collapse" data-target="#indevidual_leaderboard"><i class="fa fa-fw fa-empire"></i> Individual leaderboard <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="indevidual_leaderboard" class="collapse">
                        <li>
                            <a id="link_personal_rank_in_school" data-toggle="tab" href="#row_user_compare_within_school"><i class="fa fa-fw fa-trophy"></i> School </a>
                        </li>
                        <li>
                            <a id="link_personal_rank_in_city" data-toggle="tab" href="#row_user_compare_within_city"> <i class="fa fa-fw fa-trophy"></i> City </a>
                        </li>
                        <li>
                            <a id="link_personal_rank_in_state" data-toggle="tab" href="#row_user_compare_within_state"> <i class="fa fa-fw fa-trophy"></i> State/Province </a>
                        </li>
                        <li>
                            <a id="link_personal_rank_in_country" data-toggle="tab" href="#row_user_compare_within_country"> <i class="fa fa-fw fa-trophy"></i> Country</a>
                        </li>
                    </ul>
                </li>
				<li>
                    <a data-toggle="collapse" data-target="#school_leaderboard"><i class="fa fa-fw fa-empire"></i> School leaderboard <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="school_leaderboard" class="collapse">
                        <li>
                            <a id="link_school_rank_in_city" data-toggle="tab" href="#row_user_compare_school_in_city"> <i class="fa fa-fw fa-trophy"></i> City </a>
                        </li>
                        <li>
                            <a id="link_school_rank_in_state" data-toggle="tab" href="#row_user_compare_school_in_state"> <i class="fa fa-fw fa-trophy"></i> State/Province </a>
                        </li>
                        <li>
                            <a id="link_school_rank_in_country" data-toggle="tab" href="#row_user_compare_school_in_country"> <i class="fa fa-fw fa-trophy"></i> Country </a>
                        </li>
					</ul>

				</li>
                    <a class="navbar-brand" href="index.php">
                        <img src="images/logo2.png" height="100px" width="150px" alt="logo">
                    </a>
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </nav>
    <!-- user profile popup -->
    <div class="modal fade" id="profileModal" role="dialog">
        <div class="modal-dialog modal-lg tab-content">
            <!-- show profile -->
            <div id="user_profile" class="modal-content tab-pane fade in active">
                <?php include 'dashboard-userprofile.php'?>
            </div><!-- show profile end-->
            <!-- edit profile -->
            <div id="edit_profile" class="modal-content tab-pane fade">
                <?php include 'dashboard-editprofile.php'?>
            </div><!-- edit profile end -->
            <div id="photo_profile" class="modal-content tab-pane fade">
                <?php include 'dashboard-photoprofile.php'?>
            </div>
        </div>
    </div>

    <div id="page-wrapper">
        <div class="container-fluid tab-content ">
            <!-- Dashboard -->
            <div id = "row_user_dashboard" class="row tab-pane fade in active">
                <?php include 'dashboard.php'?>
            </div>
            <!-- /.row-user-dashboard -->
            <!-- my action -->
            <div id = "row_user_myaction" class="row tab-pane fade">
                <?php include 'dashboard-myactions.php' ?>
            </div>
            <!-- all action -->
            <div id = "row_user_allAction" class="row tab-pane fade">
                <?php include 'dashboard-allactions.php' ?>
            </div>
            <!-- row_user_compare_city -->
            <div id = "row_user_compare_city" class="row tab-pane fade">
                <?php include 'dashboard-comparecity.php' ?>
            </div>
            <!-- row_user_compare_within_city -->
            <div id = "row_user_compare_within_city" class="row tab-pane fade">
                <?php include 'dashboard-comparewithincity.php' ?>
            </div>
            <!-- row_user_compare_within_school-->
            <div id = "row_user_compare_within_school" class="row tab-pane fade">
                <?php include 'dashboard-comparewithinschool.php' ?>
            </div>
            <!-- row_user_compare_within_state-->
            <div id = "row_user_compare_within_state" class="row tab-pane fade">
                <?php include 'dashboard-comparewithinstate.php' ?>
            </div>
            <!-- row_user_compare_within_country-->
            <div id = "row_user_compare_within_country" class="row tab-pane fade">
                <?php include 'dashboard-comparewithincountry.php' ?>
            </div>
            <!-- row_user_compare_school_in_city -->
            <div id = "row_user_compare_school_in_city" class="row tab-pane fade">
                <?php include 'dashboard-compareschoolincity.php' ?>
            </div>
            <!-- row_user_compare_school_in_state -->
            <div id = "row_user_compare_school_in_state" class="row tab-pane fade">
                <?php include 'dashboard-compareschoolinstate.php' ?>
            </div>
            <!-- row_user_compare_school_in_state -->
            <div id = "row_user_compare_school_in_country" class="row tab-pane fade">
                <?php include 'dashboard-compareschoolincountry.php' ?>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <!-- /#wrapper -->
    </div>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
