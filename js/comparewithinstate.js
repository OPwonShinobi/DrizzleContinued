$(document).ready(function(){
	$("#button_refresh_personal_rank_in_state").click(function(){
		getUserRankInState();
		$(this).prop('disabled',true);
		setTimeout(function(){
			$("#button_refresh_personal_rank_in_state").prop('disabled',false);
		}, 10000);
	});
});


function getUserState(){
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getUserState'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			update_User_State(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function getUserRankInState() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getUserRankInState'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			update_personal_rank_in_state_table(data);
			updateUserRankInState(data);
		},
		error: function(data){
			console.log(data);
		}
	});

}

function update_personal_rank_in_state_table(data){
	//console.log(data);
	$("#personal_rank_in_state").empty();

	for (student of data) {
		//console.log(rank);
		if (parseInt(student['Rank']) >10)
			break;
		var image = '/images/rank/' + student['Rank']+ '.png'

			$("#personal_rank_in_state").append('<tr>'
					+ '<td class="col-xs-2"><img src="'
					+ image
					+ '"></td>'
					+ '<td class="col-xs-2">'
					+ student['NickName']
					+ '</td>'
					+ '<td class="col-xs-2">'
					+ student['City']
					+ '</td>'
					+ '<td class="col-xs-4">'
					+ student['SchoolName']
					+ '</td>'
					+ '<td class="col-xs-2">'
					+ student['Score']
					+ '</td>'
					+ '</tr>'
					); 
	}

	$("#time_update_personal_rank_in_state").text(get_current_time());

}

function updateUserRankInState(data) {
	//console.log(data);

	var myRecord = data.filter(function(student){
		return student.ID == student.MyId;
	});

	$("#span_personal_rank_in_state").text(myRecord[0]['Rank']);

}

function update_User_State(data){
	//console.log(data);
	$(".span_user_state").text(data[0]['StateProvince']);
}
