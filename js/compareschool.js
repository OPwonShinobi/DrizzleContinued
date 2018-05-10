$(document).ready(function(){
	$("#button_refresh_school_rank_in_city").click(function(){
		getSchoolRankInCity();
		$(this).prop('disabled',true);
		setTimeout(function(){
			$("#button_refresh_school_rank_in_city").prop('disabled',false);
		}, 10000);
	});

});
function getSchoolRankInCity(){
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getSchoolRankInCity'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			//update_User_City(data);
			update_school_rank_in_city_table(data);
			update_my_school_rank_in_city(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function update_school_rank_in_city_table(data){
	//console.log(data);

	$("#school_rank_in_city").empty();

	for (school of data) {
		//console.log(rank);
		if (parseInt(school['Rank']) >10)
			break;
		var image = '/images/rank/' + school['Rank']+ '.png';

		$("#school_rank_in_city").append('<tr class="rank-row">'
				+ '<td class="col-xs-2 rankCell"><img src="'
				+ image
				+ '"></td>'
				+ '<td class="col-xs-5 schoolCell">'
				+ school['SchoolName']
				+ '</td>'
				+ '<td class="col-xs-5 scoreCell">'
				+ school['Score']
				+ '</td>'
				+ '</tr>'
				); 
	}

	$("#time_update_school_rank_in_city").text(get_current_time());
}

function update_my_school_rank_in_city(data) {
	//console.log(data);
	var mySchoolRecord = getMySchoolRecord(data);

	//console.log(mySchoolRecord);
	$("#span_school_rank_in_city").text(mySchoolRecord[0]['Rank']);
}


function getSchoolRankInState(){
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getSchoolRankInState'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			//update_User_City(data);
			update_school_rank_in_state_table(data);
			update_my_school_rank_in_state(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function update_school_rank_in_state_table(data){
	//console.log(data);

	$("#school_rank_in_state").empty();

	for (school of data) {
		//console.log(rank);
		if (parseInt(school['Rank']) >10)
			break;
		var image = '/images/rank/' + school['Rank']+ '.png';

		$("#school_rank_in_state").append('<tr class="rank-row">'
				+ '<td class="col-xs-2 rankCell"><img src="'
				+ image
				+ '"></td>'
				+ '<td class="col-xs-6 schoolCell">'
				+ school['SchoolName']
				+ '</td>'
				+ '<td class="col-xs-2 cityCell">'
				+ school['City']
				+ '</td>'
				+ '<td class="col-xs-2 scoreCell">'
				+ school['Score']
				+ '</td>'
				+ '</tr>'
				); 
	}

	$("#time_update_school_rank_in_state").text(get_current_time());
}

function update_my_school_rank_in_state(data) {
	//console.log(data);

	var mySchoolRecord = getMySchoolRecord(data);
	//console.log(mySchoolRecord);

	$("#span_school_rank_in_state").text(mySchoolRecord[0]['Rank']);
}

function getSchoolRankInCountry(){
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getSchoolRankInCountry'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			//update_User_City(data);
			update_school_rank_in_country_table(data);
			update_my_school_rank_in_country(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function update_school_rank_in_country_table(data){
	//console.log(data);

	$("#school_rank_in_country").empty();

	for (school of data) {
		//console.log(rank);
		if (parseInt(school['Rank']) >10)
			break;
		var image = '/images/rank/' + school['Rank']+ '.png';

		$("#school_rank_in_country").append('<tr class="rank-row">'
				+ '<td class="col-xs-2 rankCell"><img src="'
				+ image
				+ '"></td>'
				+ '<td class="col-xs-2 schoolCell">'
				+ school['SchoolName']
				+ '</td>'
				+ '<td class="col-xs-3 stateCell">'
				+ school['StateProvince']
				+ '</td>'
				+ '<td class="col-xs-3 cityCell">'
				+ school['City']
				+ '</td>'
				+ '<td class="col-xs-2 scoreCell">'
				+ school['Score']
				+ '</td>'
				+ '</tr>'
				); 
	}

	$("#time_update_school_rank_in_country").text(get_current_time());
}

function update_my_school_rank_in_country(data) {
	//console.log(data);
	var mySchoolRecord = getMySchoolRecord(data);
	//console.log(mySchoolRecord);

	$("#span_school_rank_in_country").text(mySchoolRecord[0]['Rank']);
}

function getMySchoolRecord(data) {
	return data.filter(function(record){
		return record.SchoolID==record.MySchoolId;
	});
}
