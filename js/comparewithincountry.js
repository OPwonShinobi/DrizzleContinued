$(document).ready(function(){
	$("#button_refresh_personal_rank_in_country").click(function(){
		getUserRankInCountry();
		$(this).prop('disabled',true);
		setTimeout(function(){
			$("#button_refresh_personal_rank_in_country").prop('disabled',false);
		}, 10000);
	});
});


function getUserCountry(){
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getUserCountry'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			update_User_Country(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function getUserRankInCountry() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getUserRankInCountry'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			update_personal_rank_in_country_table(data);
			updateUserRankInCountry(data);
		},
		error: function(data){
			console.log(data);
		}
	});

}

function update_personal_rank_in_country_table(data){
	//console.log(data);
	$("#personal_rank_in_country").empty();

	for (student of data) {
		//console.log(rank);
		if (parseInt(student['Rank']) >10)
			break;
		var image = '/images/rank/' + student['Rank']+ '.png'

			$("#personal_rank_in_country").append('<tr>'
					+ '<td class="col-xs-2 rankCell"><img src="'
					+ image
					+ '"></td>'
					+ '<td class="col-xs-2 nameCell">'
					+ student['NickName']
					+ '</td>'
					+ '<td class="col-xs-2 stateCell">'
					+ student['StateProvince']
					+ '</td>'
					+ '<td class="col-xs-2 cityCell">'
					+ student['City']
					+ '</td>'
					+ '<td class="col-xs-2 schoolCell">'
					+ student['SchoolName']
					+ '</td>'
					+ '<td class="col-xs-2 scoreCell">'
					+ student['Score']
					+ '</td>'
					+ '</tr>'
					); 
	}

	$("#time_update_personal_rank_in_country").text(get_current_time());

}

function updateUserRankInCountry(data) {
	//console.log(data);

	var myRecord = data.filter(function(student){
		return student.ID == student.MyId;
	});

	$("#span_personal_rank_in_country").text(myRecord[0]['Rank']);

}

function update_User_Country(data){
	//console.log(data);
	$(".span_user_country").text(data[0]['Country']);
}
