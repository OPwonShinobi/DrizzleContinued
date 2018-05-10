$(document).ready(function() {
	// compare with country
	//filterLeaderboard("nameFilter", "personal_rank_in_country", 1);
	//filterLeaderboard("stateFilter", "personal_rank_in_country", 2);
	//filterLeaderboard("cityFilter", "personal_rank_in_country", 3);
	//filterLeaderboard("schoolFilter", "personal_rank_in_country", 4);
	//filterLeaderboard("scoreFilter", "personal_rank_in_country", 5);
});

var nameFilVal, stateFilVal, cityFilVal, schoolFilVal, scoreFilVal;

function updateFilters() {
	$('.rank-row').hide().filter(function() {
		var self = $(this)
		var result = true;

		console.log("In updateFilters! " + schoolFilVal);

		if (nameFilVal && nameFilVal != "") {
			console.log("Name filter value: " + nameFilVal);
			result = result && filterLeaderboard(self, nameFilVal, "nameCell");
		}
		if (stateFilVal && stateFilVal != "") {
			console.log("State filter value: " + stateFilVal);
			result = result && filterLeaderboard(self, stateFilVal, "stateCell");
		}
		if (cityFilVal && cityFilVal != "") {
			result = result && filterLeaderboard(self, cityFilVal, "cityCell");
		}
		if (schoolFilVal && schoolFilVal != "") {
			result = result && filterLeaderboard(self, schoolFilVal, "schoolCell");
		}
		if (scoreFilVal && scoreFilVal != "") {
			result = result && filterLeaderboard(self, scoreFilVal, "scoreCell");
		}

		return result;
	}).show();
}

function filterLeaderboard(self, filterValue, tdClass) {
	var td = self.find("td." + tdClass);
	console.log("Class is: " + tdClass);
	if (td) {
		var tdText = td.text().toUpperCase();
		console.log(tdText);
		console.log(filterValue);
		if (tdText.indexOf(filterValue) > -1) {
			return true;
		} else {
			return false;
		}
	}
}

function nameOnkeyup(inputFilter) {
	var input = document.getElementById(inputFilter);
	nameFilVal = input.value.toUpperCase();
	console.log("Name on keyup: " + nameFilVal);
	updateFilters();
}

function stateOnkeyup(inputFilter) {
	var input = document.getElementById(inputFilter);
	stateFilVal = input.value.toUpperCase();
	updateFilters();
}

function cityOnkeyup(inputFilter) {
	var input = document.getElementById(inputFilter);
	cityFilVal = input.value.toUpperCase();
	updateFilters();
}

function schoolOnkeyup(inputFilter) {
	var input = document.getElementById(inputFilter);
	schoolFilVal = input.value.toUpperCase();
	updateFilters();
}

function scoreOnkeyup(inputFilter) {
	var input = document.getElementById(inputFilter);
	scoreFilVal = input.value.toUpperCase();
	updateFilters();
}