$(document).ready(function() {
	// compare with country
	filterLeaderboard("nameFilter", "personalInCountryTable", 1);
	filterLeaderboard("stateFilter", "personalInCountryTable", 2);
	filterLeaderboard("cityFilter", "personalInCountryTable", 3);
	filterLeaderboard("schoolFilter", "personalInCountryTable", 4);
	filterLeaderboard("scoreFilter", "personalInCountryTable", 5);
});

function filterLeaderboard(inputFilter, tableId, colNum) {
	var input, filter, table, tr, td, i;
	input = document.getElementById(inputFilter);
	filter = input.value.toUpperCase();
	table = document.getElementById(tableId);
	tr = table.getElementsByTagName("tr");

	for (i = 0; i < tr.length; i++) {
	td = tr[i].getElementsByTagName("td")[Number(colNum)];
		if (td) {
			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}   
	}
}
