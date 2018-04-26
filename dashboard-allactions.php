<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<script src="/js/all_action.js"></script>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			All Actions <small>The movement for a greener future through youth action</small>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
			</li>
			<li class="active">
				<i class="fa fa-wrench"></i> All Actions
			</li>
		</ol>
	</div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> All actions available 
		
					<button id="button_refresh_all_actions" class="btn btn-warning">
						<span class="glyphicon glyphicon-refresh"></span>
					</button>
				</h2>
			</div>
			<div class="panel-body">
				<div class="row">
					<input type="text" class="form-control" id="search_action" placeholder="Enter keywrods to filter...">
				</div>

				<div class="row">
					<table  class="table">
						<tbody id="action_table_content">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->
</div>
