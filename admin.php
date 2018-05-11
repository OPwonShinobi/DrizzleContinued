<?php
session_start();
require_once('config.php');
if (!isset($_SESSION['admin']))
header('Location: admin_login.php');
if ($_POST) {
    $message=$_POST['myNotification'];
    $conn = get_db_connection();
    $stmt = $conn->prepare("DELETE FROM Notification");
    $stmt->execute();
    $stmt = $conn->prepare("INSERT INTO Notification VALUES(:message, CURRENT_TIMESTAMP)");
    $stmt->bindParam(":message", $message);
    $stmt->execute();
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

		<title>Admin</title>
		<link rel="shortcut icon" href="/yec.ico" type="image/x-icon">
		<link rel="icon" href="/yec.ico" type="image/x-icon">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- Bootstrap Core CSS -->
		<!--
		<link href="css/bootstrap.min.css" rel="stylesheet">
		-->

		<!-- Custom CSS -->
		<link href="css/sb-admin.css" rel="stylesheet">
		<link href="css/admin.css" rel="stylesheet">
		<link href="css/bootstrap-switch.css" rel="stylesheet">
		<link href="jquery-ui/jquery-ui.css" rel="stylesheet">

		<!-- Morris Charts CSS -->

		<!-- Custom Fonts -->
		<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- Custom jQuery script -->
		<script src="/js/admin.js"></script>
		<script src="/js/bootstrap-confirmation.js"></script>
		<script src="/js/bootstrap-switch.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	</head>

	<body>

		<div id="wrapper">

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
					<a class="navbar-brand" href="#"> <span class="fontStyle"> Welcome  </span></a>
				</div>
				<!-- Top Menu Items -->
				<ul class="nav navbar-right top-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['admin']?><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="admin_logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
							</li>
						</ul>
					</li>
				</ul>

				<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav side-nav nav-tabs">
						<li class="active">
							<a id="tab_manage_school" data-toggle="tab" href="#row_manage_school"><i class="fa fa-fw fa-graduation-cap"></i> Manage school data</a>
						</li>
						<li>
							<a id="tab_manage_region" data-toggle="tab" href="#row_manage_region"><i class="fa fa-fw fa-graduation-cap"></i> Manage region data</a>
						</li>
						<li>
							<a id="tab_manage_action" data-toggle="tab" href="#row_manage_action"><i class="fa fa-fw fa-anchor"></i> Manage action data</a>
						</li>
						<li>
							<a id="tab_show_student" data-toggle="tab" href="#row_manage_student"><i class="fa fa-fw fa-user"></i> Show student data</a>
						</li>
						<li>
							<a id="tab_wrap_old_data" data-toggle="tab" href="#row_wrap_old_data"><i class="fa fa-fw fa-file-archive-o"></i> Wrap up old data </a>
						</li>
						<li>
							<a id="tab_show_notification" data-toggle="tab" href="#row_manage_notification"><i class="fa fa-fw fa-envelope"></i> Update Notification</a>
						</li>
						<li >
							<a id="tab_manage_admin" data-toggle="tab" href="#row_manage_admin"><i class="fa fa-fw fa-key"></i> Manage admins </a>
						</li>

					<li class="navbar-brand">
						<img src="images/logo2.png" height="100px" width="150px" alt="">
					</li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</nav>

			<div id="page-wrapper">

				<div class="container-fluid tab-content ">
					<div id="row_manage_school" class="row tab-pane fade in active">
						<div class="col-xs-12">
							<label class="h2"> Search school</label>
							<button type="button" id="button_add_school" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Select a city to show the result" disabled> Add school</button>
						</div>
						<div class="col-sm-4 col-xs-12">
							<select name="country" class="form-control countries order-alpha" id="countryId" required>
								<option value="">Select Country</option>
								<option value="" disabled>&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;</option>
							</select>
						</div>
						<div class="col-sm-4 col-xs-12">
							<select name="state" class="form-control states order-alpha" id="stateId" required>
								<option value="">Select Province/State</option>
							</select>
						</div>
						<div class="col-sm-4 col-xs-12">
							<select name="city" class="form-control cities order-alpha" id="cityId" required>
								<option value="">Select City</option>
							</select>
						</div>


						<script src="https://geodata.solutions//includes/countrystatecity.js"></script>

						<div class="col-xs-12">
							<table  class="table">
								<thead>
									<tr>
										<th>Country</th>
										<th>State/Province</th>
										<th>City</th>
										<th>School</th>
										<th>Operation</th>
									</tr>
									<tbody id="school_table_content">
									</tbody>
								</thead>
							</table>
						</div>
					</div>
					<div id="row_manage_region" class="row tab-pane fade">
						<div class="col-xs-12">
							<label class="h2"> Search region</label>
							<button type="button" id="button_add_region" class="btn btn-danger" data-toggle="tooltip" data-placement="top"> Add region</button>
						</div>
						<div class="col-sm-4 col-xs-12">
							<select name="country" class="form-control countries order-alpha" id="countryId_region" required>
								<option value="">Select Country</option>
								<option value="" disabled>&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;</option>
							</select>
						</div>
						<div class="col-sm-4 col-xs-12">
							<select name="state" class="form-control states order-alpha" id="stateId_region" required>
								<option value="">Select Province/State</option>
							</select>
						</div>

						<script src="https://geodata.solutions//includes/countrystatecity.js"></script>

						<div class="col-xs-12">
							<table  class="table">
								<thead>
									<tr>
										<th>Country</th>
										<th>State/Province</th>
										<th></th>
									</tr>
									<tbody id="region_table_content">
									</tbody>
								</thead>
							</table>
						</div>
					</div>
					<div id="row_manage_action" class="row tab-pane fade">
						<div class="col-xs-12">
							<label class="h2"> All actions</label>
							<button id="button_add_action" class="btn btn-danger">Add action</button>
							<button id="button_add_category" class="btn btn-danger">Add category</button>
						</div>
						<div class="col-xs-12">
							<table  class="table">
								<thead>
									<tr>
										<th>ID</th>
										<th>Description</th>
										<th>Category</th>
										<th>Points</th>
									</tr>
								</thead>
								<tbody id="action_table_content">
								</tbody>
							</table>
						</div>
					</div>
					<div id="row_manage_student" class="row tab-pane fade">
						<div class="col-xs-12">
							<label class="h2"> Student records</label>
							<input type="text" id="filterInput" onkeyup="filterStudentRecords()" placeholder="Search for records.." title="Type in a name">
							<!--The values here for filter corresponds to the td number, do not change it! Unless you change the table layout-->
							<select id="FilterCategory">
								<option value="4" selected="selected">School</option>
								<option value="5">LastName</option>
								<option value="6">FirstName</option>
								<option value="7">NickName</option>
								<option value="8">Email</option>
								<option value="9">Score</option>
							</select>
						</div>


						<div class="col-sm-3 col-xs-12">
							<select name="country" class="form-control order-alpha" id="yecCountryId" required>
								<option value="">Select Country</option>
								<option value="" disabled>&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;&#9473;</option>
							</select>
						</div>
						<div class="col-sm-3 col-xs-12">
							<select name="state" class="form-control order-alpha" id="yecStateId" required>
								<option value="">Select Province/State</option>
							</select>
						</div>
						<div class="col-sm-3 col-xs-12">
							<select name="city" class="form-control corder-alpha" id="yecCityId" required>
								<option value="">Select City</option>
							</select>
						</div>

						<div class="col-sm-3 col-xs-12">
							<select name="school" class="form-control order-alpha" id="yecSchoolId" required>
								<option value="">Select School</option>
							</select>
						</div>


						<div class="col-xs-12">
							<table  class="table">
								<thead>
									<tr>
										<th>Rank</th>
										<th>Country</th>
										<th>State/Province</th>
										<th>City</th>
										<th>School</th>
										<th>Last Name</th>
										<th>First Name</th> 
										<th>Nick name</th>
										<th>Email</th>
										<th>Score</th>
										<th style="display:none;">ID</th>
										<th></th>
									</tr>
									<tbody id="student_table_content">
									</tbody>
								</thead>
							</table>
						</div>
					</div>

					<div id="row_manage_notification" class="row tab-pane fade">
						<div class="col-xs-12">
							<label class="h2">Update Notification Message</label>
						</div>

						<div class="col-xs-12">
							<div class="col-xs-10 col-xs-offset-1">
									<div id="messageHistory">
							    </div>

							</div>
							<label for="notification"> Notification message </label>
							<form class = "text-center" action="admin.php" method="post">
								<textarea class = "form-control" rows="5" id="notification" name="myNotification" maxlength="255"> </textarea>
								<input type="submit" class="btn btn-success btn-block" onclick="get_myNotification_table()" value="Post">
                                <input type="button" class="btn btn-danger btn-block" onclick="deleteNotification()" value="Delete">
                            </form>
                            <!--
                            <form action="upload.php" method="post" enctype="multipart/form-data">
							    Select image to upload:
							    <input type="file" name="fileToUpload" id="fileToUpload">
							    <input type="submit" value="Upload Image" name="submit">
							</form>
							-->
							<form action="upload2.php" method="post" enctype="multipart/form-data">
								<input type="hidden" name="destination" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"/>
							    <h3 style="color:white">Select image to upload:</h3>
							    <input style="color:white" type="file" name="image"/>
							    <input type="submit" name="submit" value="UPLOAD"/>
							</form>

						<div class="col-xs-12">
							<table  class="table">
								<thead>
									<tr>
										<th>ID</th>
										<th>Image</th>
										<th>Flag</th>
										<th>Description</th>
										<th>UserID</th>
									</tr>
								</thead>
								<tbody id="action_table_images">
								</tbody>
							</table>
						</div>

						</div>
					</div>

					<div id="row_wrap_old_data" class="row tab-pane fade">
						<div class="col-xs-12">
							<label class="h2"> Archive YEC data before date</label>
						</div>

						<div class="col-xs-12">
							<div class="well">
								<label> This operation will archive the data earlier than the date you choose.</label><br>
								<label> Pack up the data earlier than: </label>
								<input type="text" id="old_data_date_picker">
								<input type="submit" id="submit_archive_old_data">
							</div>
						</div>
					</div>

					<div id="row_manage_admin" class="row tab-pane fade">
						<div class="col-xs-12">
							<label class="h2"> Admin accounts </label>
							<button id="refresh_admin_table" class="btn btn-warning">
								<span class="glyphicon glyphicon-refresh"></span>
							</button>

						</div>

						<div class="col-xs-12">
							<table  class="table">
								<thead>
									<tr>
										<th> # </th>
										<th>Admin</th>
										<th>Email</th>
										<th>Operation</th>
									</tr>
									<tbody id="admin_table_content">
									</tbody>
								</thead>
							</table>
						</div>
						<div id="admin_page_content" class="col-xs-12">
						</div>
					</div>

					<!-- add school popup modal -->
					<div id="popup_modal_add_school" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!--Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4>Add new school</h4>
								</div>
								<div class="modal-body">
									<form>
										<div class="form-group">
											<label>Country</label>
											<input id="input_country" type="text" class="form-control" disabled>
										</div>
										<div class="form-group">
											<label>State/Province</label>
											<input id="input_state_province" type="text" class="form-control" disabled>
										</div>
										<div class="form-group">
											<label>City</label>
											<input id="input_city" type="text" class="form-control" disabled>
										</div>
										<div class="form-group">
											<label>School name</label>
											<input id="input_school_name" type="text" class="form-control" required>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="submit" id="button_add_school_confirm" class="btn btn-default" data-dismiss="modal">Add</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>

					<div id="popup_modal_add_region" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!--Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4>Add new region</h4>
								</div>
								<div class="modal-body">
									<form>
										<div class="form-group">
											<label>Country</label>
											<input id="input_country_region" type="text" class="form-control" disabled>
										</div>
										<div class="form-group">
											<label>State/Province</label>
											<input id="input_state_province_region" type="text" class="form-control" disabled>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="submit" id="button_add_region_confirm" class="btn btn-default" data-dismiss="modal">Add</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>

					<!-- modify school popup modal -->
					<div id="popup_modal_edit_school" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!--Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4>Modify school</h4>
								</div>
								<div class="modal-body">
									<form>
										<div class="form-group">
											<label>Country</label>
											<input id="input_country_edit" type="text" class="form-control" disabled>
										</div>
										<div class="form-group">
											<label>State/Province</label>
											<input id="input_state_province_edit" type="text" class="form-control" disabled>
										</div>
										<div class="form-group">
											<label>City</label>
											<input id="input_city_edit" type="text" class="form-control" disabled required>
										</div>
										<div class="form-group">
											<label>School name</label>
											<input id="input_school_name_edit" type="text" class="form-control" required>
											<input type="hidden" id="school_id">
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="submit" id="button_edit_school_confirm" class="btn btn-default" data-dismiss="modal"> Modify </button>
									<button type="button" class="btn btn-default" data-dismiss="modal"> Cancel </button>
								</div>
							</div>
						</div>
					</div>

					<!-- add actions popup modal -->
					<div id="popup_modal_add_action" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!--Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4>Add new action</h4>
								</div>
								<div class="modal-body">
									<form>
										<div class="form-group">
											<label>Action desription</label>
											<textarea id="input_action_description" rows="10" class="form-control"></textarea>
										</div>
										<div class="form-group">
											<label>Points</label>
											<input id="input_action_points" type="number" min="1" class="form-control">
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="submit" id="button_add_action_confirm" class="btn btn-default" data-dismiss="modal">Add</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>

					<!-- modify actions popup modal -->
					<div id="popup_modal_edit_action" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!--Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4>Modify action</h4>
								</div>
								<div class="modal-body">
									<form>
										<div class="form-group">
											<label>Action description</label>
											<textarea id="input_edit_action_description" rows="10" required class="form-control modify-action-fields"></textarea>
										</div>
										<div class="form-group">
											<label>Points</label>
											<input id="input_edit_action_points" type="number" min="1" required class="form-control modify-action-fields">
											<input id="edit_action_id" type="hidden" class="form-control modify-action-fields">
										</div>
										<div class="form-group">
											<label>Category</label>
											<input id="input_edit_category" required class="form-control modify-action-fields">
<?php
$conn = new mysqli('localhost', 'yecuser', 'yec123!Q@W#E', 'yecdata') 
or die ('Cannot connect to db');

    $result = $conn->query("select CategoryName from ActionCategory");

    echo "<select name='category' id='action_category' requred class=\"form-control modify-action-fields\">";

    while ($row = $result->fetch_assoc()) {

                  unset($id, $name);
                  $id = 1;
                  $name = $row['CategoryName']; 
                  echo '<option class="form-control modify-action-fields" value="'.$id.'">'.$name.'</option>';

}
    echo "</select>";
?> 
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="submit" id="button_edit_action_confirm" class="btn btn-default" data-dismiss="modal" disabled>Modify</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>


					<div id="popup_modal_add_admin" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!--Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4>Add new admin</h4>
								</div>
								<div class="modal-body">
									<form>
										<div class="form-group">
											<label>Username</label>
											<input id="input_admin_username" class="form-control admin-form-values">										</div>
										<div class="form-group">
											<label>Email</label>
											<input id="input_admin_email" type="email" class="form-control admin-form-values">
										</div>
										<div class="form-group">
											<label>Password</label>
											<input id="input_admin_password" type="password" class="form-control admin-form-values">
										</div>
										<div class="form-group">
											<label>Coinfirm password</label>
											<input id="input_admin_confirm_password" type="password" class="form-control admin-form-values">
										</div>
										<div class="form-group">
											<label>Authorization</label>
											<input id="input_admin_authorization" type="number" min="0" max="8" class="form-control admin-form-values">
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="submit" id="button_add_admin_confirm" class="btn btn-default" data-dismiss="modal"disabled>Add</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>

					<div id="popup_modal_edit_admin" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!--Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4>Add new admin</h4>
								</div>
								<div class="modal-body">
									<form>
										<div class="form-group">
											<label>Username</label>
											<input id="input_edit_admin_username" class="form-control admin-form-values">										</div>
										<div class="form-group">
											<label>Email</label>
											<input id="input_edit_admin_email" type="email" class="form-control edit_admin-form-values" disabled>
										</div>
										<div class="form-group">
											<label>Password</label>
											<input id="input_edit_admin_password" type="password" class="form-control edit_admin-form-values">
										</div>
										<div class="form-group">
											<label>Confirm password</label>
											<input id="input_edit_admin_confirm_password" type="password" class="form-control edit_admin-form-values">
											<input id="edit_admin_number" type="hidden">


										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="submit" id="button_edit_admin_confirm" class="btn btn-default" data-dismiss="modal"disabled>Modify</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>

					<div id="popup_modal_add_category" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!--Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4>Add new Category</h4>
							</div>
							<div class="modal-body">
								<form>
									<div class="form-group">
										<label>Category description</label>
										<textarea id="input_category_description" rows="10" class="form-control"></textarea>
									</div>
									<div class="form-group">
										<label>Category name</label>
										<input id="input_category_name" class="form-control">
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="submit" id="button_add_category_confirm" class="btn btn-default" data-dismiss="modal">Add</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /.container-fluid -->
			</div>
			<!-- /#page-wrapper -->
		</div>
		<!-- /#wrapper -->

	</body>

</html>
