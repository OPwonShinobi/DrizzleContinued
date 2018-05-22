var school_score = 0;
$(document).ready(function(){
	getSchoolScore();
	$("#button_refresh_school_rank_in_city").click(function(){
		getSchoolRankInCity();
		$(this).prop('disabled',true);
		setTimeout(function(){
			$("#button_refresh_school_rank_in_city").prop('disabled',false);
		}, 10000);
	});

});

function getSchoolScore() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getSchoolScore'},
		dataType: 'JSON',
		success: function(data){
			console.log(data);
			// only parse if json data defined, previously set school_score to 0
			if (data[0])
				school_score = parseInt(data[0]['Score']);
			//console.log(school_score);
			display_school_score();
			//console.log(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

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
		var imageStr = school['Rank'];
		if (parseInt(school['Rank']) >10) {
			imageStr = "default";
			//break;
		}
		var image = '/images/rank/' + imageStr + '.png'

		$("#school_rank_in_city").append('<tr class="rank-row">'
				+ '<td align="center" class="col-xs-2 rankCell"><img src="'
				+ image
				+ '">'
				+ school['Rank']
				+ '</td>'
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
	if ($.fn.dataTable.isDataTable('#school_rank_in_city_table')) {
	    $("#school_rank_in_city_table").DataTable();
	}
	else {
	    $("#school_rank_in_city_table").DataTable({
	    	"sDom": 'lrtip'
	    });
	}
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
		var imageStr = school['Rank'];
		if (parseInt(school['Rank']) >10) {
			imageStr = "default";
			//break;
		}
		var image = '/images/rank/' + imageStr + '.png'

		$("#school_rank_in_state").append('<tr class="rank-row">'
				+ '<td align="center" class="col-xs-2 rankCell"><img src="'
				+ image
				+ '">'
				+ school['Rank']
				+ '</td>'
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
	if ($.fn.dataTable.isDataTable('#school_rank_in_state_table')) {
	    $("#school_rank_in_state_table").DataTable();
	}
	else {
	    $("#school_rank_in_state_table").DataTable({
	    	"sDom": 'lrtip'
	    });
	}
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
		var imageStr = school['Rank'];
		if (parseInt(school['Rank']) >10) {
			imageStr = "default";
			//break;
		}
		var image = '/images/rank/' + imageStr + '.png'

		$("#school_rank_in_country").append('<tr class="rank-row">'
				+ '<td align="center" class="col-xs-2 rankCell"><img src="'
				+ image
				+ '">'
				+ school['Rank']
				+ '</td>'
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
	if ( $.fn.dataTable.isDataTable('#school_rank_in_country_table')) {
	    $("#school_rank_in_country_table").DataTable();
	}
	else {
	    $("#school_rank_in_country_table").DataTable({
	    	"sDom": 'lrtip'
	    });
	}
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
