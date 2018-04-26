<?php
if (!isset($_SESSION['Userid']))
header('Location: login.php');
?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Comparison <small>The movement for a greener future through youth action</small>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-home"></i><a href="#">Dashboard</a>
			</li>
			<li class="active">
				<i class="fa fa-trophy"></i> Personal ranking in school
			</li>
		</ol>
	</div>
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Ranking </h2>
			</div>
			<div class="panel-body">

				<div class="row">
					<div class="col-xs-12">
						<div class="panel panel-green text-center">
							<span class="h1" id="span_my_school"> My School </span> 
							<br>
							<span><b> Last updated:</b> </span>
							<span id="time_update_personal_rank_in_school"> </span>
							<button id="button_refresh_personal_rank_in_school" class="btn btn-warning"><span class="glyphicon glyphicon-refresh"></span></button>
						</div>
					</div>
					<div class="col-xs-10 col-xs-offset-1">
						<table class="table">
							<thead>
								<tr>
									<th>Rank</th>
									<th>Name</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody id="personal_rank_in_school">
							</tbody>
						</table>
					</div>
					<div class="col-xs-12">
						<div class="well">
							<span class="h3">Your position: </span>
							<span id="span_personal_rank_in_school" class="h1"></span>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.row -->
