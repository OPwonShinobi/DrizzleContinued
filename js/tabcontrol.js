$(document).ready(function(){
	$('a[data-toggle="tab"]').on('shown.bs.tab', function () {
		//console.log($(this)[0].id);
		if ($(this)[0].id == "link_personal_rank_in_school") {
			getUserScore();
			getUserRankInSchool();
			getUserSchool();
		} else if ($(this)[0].id == "link_personal_rank_in_city") {
			getUserCity();
			getUserRankInCity();
		} else if ($(this)[0].id == "link_personal_rank_in_state") {
			//console.log($(this)[0].id);
			getUserState();
			getUserRankInState();
		} else if ($(this)[0].id == "link_personal_rank_in_country") {
			//console.log($(this)[0].id);
			getUserCountry();
			getUserRankInCountry();
		} else if ($(this)[0].id == "link_school_rank_in_city") {
			getShoolScore();
			getUserCity();
			getSchoolRankInCity();
		} else if ($(this)[0].id == "link_school_rank_in_state") {
			getUserState();
			getSchoolRankInState();
		} else if ($(this)[0].id == "link_school_rank_in_country") {
			getUserCountry();
			getSchoolRankInCountry();
		} else if ($(this)[0].id == "link_all_action_tab") {
			//console.log($(this)[0].id);
			get_all_actions();
		} else {
		}
	});
}); 

function get_current_time() {
	var currentdate = new Date(); 
	months = ["Jan", "Feb", "Mar", 
			  "Apr", "May", "Jun",
			  "Jul", "Aug", "Sept",
			  "Oct", "Nov", "Dec"
	];
	currentMonth = currentdate.getMonth();
	currentDate = currentdate.getDate();
	currentYear = currentdate.getFullYear();
	currentHours = currentdate.getHours();
	currentMinutes = currentdate.getMinutes();
	currentSeconds = currentdate.getSeconds();

	var currentTime = months[currentMonth] + " "  
		+ currentDate + ", "
		+ currentYear + " "  
		+ (currentHours > 9 ? "" + currentHours : "0" + currentHours) + ":"  
		+ (currentMinutes > 9 ? "" + currentMinutes : "0" + currentMinutes)  + ":" 
		+ (currentSeconds> 9 ? "" + currentSeconds: "0" + currentSeconds);
	return currentTime; 
}

$(function() {
    var navMain = $(".navbar-collapse");
    //var navMainDom = document.querySelector(".navbar-collapse")[0];

    navMain.on("click", "a:not(.leaderboard-menu)", null, function () {
        navMain.collapse("hide");
        //document.querySelector('.navbar-collapse.collapse').classList.add("hide");
        // navMainDom.style.collapse = "hide";
    });
});

