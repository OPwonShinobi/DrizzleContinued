var all_actions = [];

$(document).ready(function(){
	get_all_actions();
	$("#search_action").on('input', function(){
		filter_actions($(this).val());

	});
	$("#button_refresh_all_actions").click(function(){
		get_all_actions();
	});
});

$(document).on('click', '.pickup-action-button', function(){
	pickup_action($(this).val(), $(this).parent());
});

$(document).on('click', '.remove-action-button', function(){
	remove_action($(this).val(), $(this).parent());
});


function get_all_actions() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getAllActionsWithUserIndication'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			all_actions = data;
			update_action_pickup_table(data);
		},
		error: function(data){
			//console.log(data);
		}
	});
}

function pickup_action(actionId, parentElement) {
	console.log(actionId);
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'addUerAction',
			ActionId:  actionId
		},
		dataType: 'JSON',
		success: function(data){
			console.log(data);
			parentElement.empty();
			parentElement.append('<button value="'
					+ actionId
					+ '" class="btn btn-danger remove-action-button"><span class="glyphicon glyphicon-trash"></span></button>')
			actionCounter = actionCounter + 1;
			get_num_action();
		},
		error: function(data){
			console.log(data);
		}
	});
}

function remove_action(actionId, parentElement) {
	console.log(actionId);
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'deleteUerAction',
			ActionId:  actionId
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			parentElement.empty();
			parentElement.append('<button value="'
					+ actionId
					+ '" class="btn btn-success pickup-action-button"><span class="glyphicon glyphicon-plus"></span></button>')
			actionCounter = actionCounter - 1;
			get_num_action();
		},

		error: function(data){
			console.log(data);
		}
	});

}

function update_action_pickup_table(data) {
	//console.log("refreshed action table");
	$("#action_table_content").empty();
	for (action of data) {
		var buttonClass = (action['UserID'] == null)
			? 'btn btn-success pickup-action-button' : 'btn btn-danger remove-action-button';

		var buttonText  = '<span class="glyphicon '
			+ ((action['UserID'] == null)? 'glyphicon-plus' : 'glyphicon-trash')
			+ '"></span>';
		var actionImage = parseInt(action['Points']) > 5 ? '0' : action['Points']

		$("#action_table_content").append('<tr>'
				+ '<td class="col-xs-2"><img src="/images/points/'
				+ actionImage + '.png"></td>'
				+ '<td class="col-xs-8"><div class="well well-lg"><span class="label label-danger">' 
				+ action['Points']
				+ ' points </span><br><span>'
				+ action['Description'] 
				+ '</span></div></td>'
				+ '<td class="col-xs-2 vcenter"><button value="'
				+ action['ID']
					+ '" class="'
					+ buttonClass + '">'
					+ buttonText + '</button></td>'
				+ '</tr>'
			);
	}
}


function filter_actions(keyword) {
	console.log(keyword);
	//console.log(all_actions.filter());

	var filtered_actions = all_actions.filter(function(action){
		var regex= new RegExp(keyword, 'i');
		return action.Description.match(regex) != null;
	});

	console.log(filtered_actions);
	update_action_pickup_table(filtered_actions);
}
