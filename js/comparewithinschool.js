var user_score = 0;
$(document).ready(function(){

	getUserScore();
	$("#button_refresh_personal_rank_in_school").click(function(){
		getUserRankInSchool();
		$("#time_update_personal_rank_in_school").text(get_current_time());
		$(this).prop('disabled',true);
		setTimeout(function(){
			$("#button_refresh_personal_rank_in_school").prop('disabled',false);
		}, 10000);
	});
});


function getUserScore() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getUserScore'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			user_score = parseInt(data[0]['Score']);
			//console.log(user_score);
			display_score();
			//console.log(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}



function getUserSchool() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getUserSchool'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			updateUserSchool(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function updateUserSchool(data) {
	//console.log(data);
	$("#span_my_school").text(data[0]['SchoolName']);
}

function getUserRankInSchool() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getUserRankInSchool'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			update_personal_rank_in_school_table(data);
			updateUserRankInSchool(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function updateUserRankInSchool(data) {
	//console.log(data);

	var myRecord = data.filter(function(student){
		return student.ID == student.MyId;
	});

	//console.log(myRecord);
	$("#span_personal_rank_in_school").text(myRecord[0]['Rank']);
}

function update_personal_rank_in_school_table(data) {
	//console.log(data);
	$("#personal_rank_in_school").empty();

	for (student of data) {
		//console.log(rank);
		if (parseInt(student['Rank']) >10)
			break;
		var image = '/images/rank/' + student['Rank']+ '.png'

			$("#personal_rank_in_school").append('<tr>'
					+ '<td class="col-xs-2"><img src="'
					+ image
					+ '"></td>'
					+ '<td class="col-xs-5">'
					+ student['NickName']
					+ '</td>'
					+ '<td class="col-xs-5">'
					+ student['Score']
					+ '</td>'
					+ '</tr>'
					); 
	}
	$("#time_update_personal_rank_in_school").text(get_current_time());
}
