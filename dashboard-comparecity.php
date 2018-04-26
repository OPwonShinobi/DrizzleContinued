<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Comparison-City <small>The movement for a greener future through youth action</small>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-home"></i><a href="index.php">Dashboard</a>
			</li>
			<li class="active">
				<i class="fa fa-fighter-jet"></i> Comparison-School
			</li>
		</ol>
	</div>
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> My Status</h2>
			</div>
			<div class="panel-body">

				<div class="row">
					<div class="col-lg-4 text-center">
						<div class="panel panel-default">
							<div  class ="challenge_box">
								<p class ="challenge_name"> Action one <br><br> Point: 10</p>
							</div>
						</div>
					</div>

					<div class="col-lg-4 text-center">
						<div class="panel panel-default">
							<div  class ="challenge_box">
								<p class ="challenge_name"> Action two <br><br> Point: 5</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 text-center">
						<div class="panel panel-default">
							<div  class ="challenge_box">
								<p class ="challenge_name"> Action Three <br><br> Point: 2</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->
</div>
