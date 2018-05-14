<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="my-page-header">
			All Actions <small>The movement for a greener future through youth action</small>
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">
					<i class="fa fa-bar-chart-o fa-fw"></i> All actions available 
		
					<button id="button_refresh_all_actions" class="btn btn-warning">
						<span class="glyphicon glyphicon-refresh"></span>
					</button>
				</h2>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-8">
						<input type="text" class="form-control" id="search_action" placeholder="Enter keywords to filter...">
					</div>
					<div class="col-sm-4">
						<div class="form-group">
						  <select class="form-control" id="filterType">
							<option value="description">Description</option>
							<option value="points">Points</option>
							<option value="category">Category</option>
						  </select>
						</div>

					</div>
				</div>

				<div class="row">
					<table class="table">
						
						
						<tbody id="action_table_content">
						

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->
</div>
