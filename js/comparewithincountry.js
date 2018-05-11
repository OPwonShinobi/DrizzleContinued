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
		//console.log("student rank: " + student['Rank']);
		var imageStr = student['Rank'];
		if (parseInt(student['Rank']) >10) {
			imageStr = "default";
			//break;
		}
		var image = '/images/rank/' + imageStr + '.png'

			$("#personal_rank_in_country").append('<tr class="rank-row">'
					+ '<td align="center" class="col-xs-2 rankCell"><img src="'
					+ image
					+ '">'
					+ student['Rank']
					+ '</td>'
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
	//$(".rank-row").hide().slice(0, 10).show();
    if ( $.fn.dataTable.isDataTable('#personal_rank_in_country_table')) {
	    $("#personal_rank_in_country_table").DataTable();
	}
	else {
	    $("#personal_rank_in_country_table").DataTable({
	    	"sDom": 'lrtip'
	    });
	}
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

function showNextTen() {
	console.log("Show More clicked!");
	$(".rank-row td:hidden").slice(0, 10).show();
	console.log("Current length: " + $(".rank-row td:hidden").length);
	if ($(".rank-row td").length == $(".rank-row td:visible").length) {
		console.log("No more to show");
		$(".show-next-10").hide();
	}
}