<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<script src="js/dashboard.js"></script>
<script src="js/myaction.js"></script>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h1 class="panel-title"><i class="fa fa-home"></i> Dashboard</h1>
			</div>
			<div class="panel-body">

				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-book fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge" id = "myActions"></div>
										<div>Actions I've Picked Up</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6">
						<div class="panel panel-yellow">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-trophy fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge" id = "myScore"></div>
										<div>Points I've Earned</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Actions Currently Picked Up</h2>
			</div>
			<div class="panel-body" id ="current_pick">

			</div>
		</div>
	</div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-history fa-fw"></i> Activity History</h2>
			</div>
			<div class="panel-body">

				<div class="col-xs-10 col-xs-offset-1">
					<table class="table">
						<thead>
							<tr>
								<th>Eco-Friendly Actions</th>
								<th>Date Accomplished</th>
							</tr>
						</thead>
						<tbody id="finish_history">
						</tbody>
					</table>

				</div>

			</div>
		</div>
	</div>
</div>
<!-- /.row -->
