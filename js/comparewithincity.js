$(document).ready(function(){
	$("#button_refresh_personal_rank_in_city").click(function(){
		getUserRankInCity();
		$(this).prop('disabled',true);
		setTimeout(function(){
			$("#button_refresh_personal_rank_in_city").prop('disabled',false);
		}, 10000);
	});
});


function getUserCity(){
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getUserCity'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			update_User_City(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function getUserRankInCity() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getUserRankInCity'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			update_personal_rank_in_city_table(data);
			updateUserRankInCity(data);
		},
		error: function(data){
			console.log(data);
		}
	});

}

function update_personal_rank_in_city_table(data){
	//console.log(data);
	$("#personal_rank_in_city").empty();

	for (student of data) {
		//console.log(rank);
		if (parseInt(student['Rank']) >10)
			break;
		var image = '/images/rank/' + student['Rank']+ '.png'

			$("#personal_rank_in_city").append('<tr>'
					+ '<td class="col-xs-2 rankCell"><img src="'
					+ image
					+ '"></td>'
					+ '<td class="col-xs-3 nameCell">'
					+ student['NickName']
					+ '</td>'
					+ '<td class="col-xs-3 schoolCell">'
					+ student['SchoolName']
					+ '</td>'
					+ '<td class="col-xs-2 scoreCell">'
					+ student['Score']
					+ '</td>'
					+ '</tr>'
					); 
	}

	$("#time_update_personal_rank_in_city").text(get_current_time());

}

function updateUserRankInCity(data) {
	//console.log(data);

	var myRecord = data.filter(function(student){
		return student.ID == student.MyId;
	});

	$("#span_personal_rank_in_city").text(myRecord[0]['Rank']);

}

function update_User_City(data){
	//console.log(data);
	//$("#span_my_city").text(data[0]['City']);
	$(".span_user_city").text(data[0]['City']);
}
