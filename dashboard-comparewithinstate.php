<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="my-page-header">
			Comparison <small>The movement for a greener future through youth action</small>
		</h1>
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
						<div class="well">
							<span class="h3">Your position: </span>
							<span id="span_personal_rank_in_state" class="h1"></span>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="panel panel-green text-center">
						<span class="h1 span_user_state"> My State/Province</span><br>
							<span><b> Last updated:</b> </span>
						<span id="time_update_personal_rank_in_state"> </span>
						<button id="button_refresh_personal_rank_in_state" class="btn btn-warning"><span class="glyphicon glyphicon-refresh"></span></button>
						</div>
					</div>
					<!-- Filter divs -->
					<div class="leaderboard-filter col-xs-12">
						<div class="col-sm-2">
							<input type="text" class="form-control order-alpha" id="rankFilter-state" onkeyup="rankOnkeyup(this.id)" placeholder="Rank" title="Type in rank number">
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control order-alpha" id="nameFilter-state" onkeyup="nameOnkeyup(this.id)" placeholder="Name" title="Type in a name">
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control order-alpha" id="cityFilter-state" onkeyup="cityOnkeyup(this.id)" placeholder="City" title="Type in a city">
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control order-alpha" id="schoolFilter-state" onkeyup="schoolOnkeyup(this.id)" placeholder="School" title="Type in a school">
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control order-alpha" id="scoreFilter-state" onkeyup="scoreOnkeyup(this.id)" placeholder="Score" title="Type in a score">
						</div>
					</div> <!-- End of filter divs -->
					<div class="col-xs-10 col-xs-offset-1 table-div">
						<table id="personal_rank_in_state_table" class="table">
							<thead>
								<tr>
									<th>Rank</th>
									<th>Name</th>
									<th>City</th>
									<th>School</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody id="personal_rank_in_state">
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
</div>
<!-- row_user_compare_within_school -->;
