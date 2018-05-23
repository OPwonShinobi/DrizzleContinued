var schoolsInSelectedCity;
var actions;
var students;
var images;
var admins;
var categories;

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	get_myNotification_table();

	/* Handle "Add school" button  */
	$("#button_add_school").click(function(){
		$("#popup_modal_add_school").modal({backdrop: "static"});
		$("#input_country").val($("#countryId option:selected").text());
		$("#input_state_province").val($("#stateId option:selected").text());
		$("#input_city").val($("#cityId option:selected").text());
	});

	$("#button_add_region").click(function(){
		$("#popup_modal_add_region").modal({backdrop: "static"});
		var country = $("#countryId_region option:selected").text();
		var province = $("#stateId_region option:selected").text();
		if (province == "Select State" || province == "Select Province/State" || province == "")
		{
			province = "ALL";
		}
		if (country == "Select Country")
		{
			country = "ALL";
		}
		$("#input_country_region").val(country);
		$("#input_state_province_region").val(province);
	});

	/* Handle "Add action" button  */
	$("#button_add_action").click(function(){
		$("#popup_modal_add_action").modal({backdrop: "static"});
	});

	$("#button_add_category").click(function(){
		$("#popup_modal_add_category").modal({backdrop: "static"});
	});

	/* Handle confirm adding new action */
	$("#button_add_action_confirm").click(function(){
		request_add_action();
	});

	$("#button_add_category_confirm").click(function(){
		request_add_category();
	});

	/* Handle "Delete category" button  */
	$("#button_delete_category").click(function(){
		$("#popup_modal_delete_category").modal({backdrop: "static"});
		populate_delete_category_dropdown();
	});

	$("#button_delete_category_confirm").click(function(){
		request_delete_category();
	});

	/* Enable "Add school" button only if a city has been selected. */
	$("#cityId").change(function(){
		refresh_school_table();
		$("#button_add_school").prop('disabled', false);
	});

	/* Clean the school table and disable "Add school" button if country and/or state changed. */
	$("#countryId").change(function(){
		$("#school_table_content").empty();
		$("#button_add_school").prop('disabled', true);
	});

	$("#stateId").change(function(){
		$("#school_table_content").empty();
		$("#button_add_school").prop('disabled', true);
	});

	/* Handle the event when seleting a country in the students table. */
	$("#yecCountryId").change(function(){
		var selectedCountry = $(this).val();
		//console.log(selectedCountry);
		states = getStatesFromStudentRecord(students, selectedCountry);
		update_select_list($("#yecStateId"), states ,"State/province");

		emptyData = [];
		update_select_list($("#yecCityId"), emptyData, "City");
		update_select_list($("#yecSchoolId"), emptyData, "School");
	});

	/* Handle the event when seleting a state / province in the students table. */
	$("#yecStateId").change(function(){
		var selectedCountry = $("#yecCountryId").val();
		var selectedState = $(this).val();

		cities = getCitiesFromStudentRecord(students, selectedCountry, selectedState);

		console.log(cities);
		update_select_list($("#yecCityId"), cities, "City");

		emptyData = [];
		update_select_list($("#yecSchoolId"), emptyData, "School");
	});

	/* Handle the event when seleting a city in the students table. */
	$("#yecCityId").change(function(){
		var selectedCountry = $("#yecCountryId").val();
		var selectedState = $("#yecStateId").val();
		var selectedCity = $(this).val();

		schools = getschoolsFromStudentRecord(students, selectedCountry, selectedState, selectedCity);
		//console.log(schools);
		update_select_list($("#yecSchoolId"), schools, "school");
	});

	/* Handle the event when seleting a school in the students table. */
	$("#yecSchoolId").change(function(){
		var selectedCountry = $("#yecCountryId").val();
		var selectedState = $("#yecStateId").val();
		var selectedCity = $("#yecCityId").val();
		var selectedSchool = $(this).val();

		selectedStudents = getStudentsFromStudentRecord(students, selectedCountry, selectedState, selectedCity, selectedSchool);

		update_students_table(selectedStudents);
		console.log(schools);
	});


	/* Submit adding new school data. */
	$("#button_add_school_confirm").click(function(){
		request_add_school();
	});

	$("#button_add_region_confirm").click(function(){
		request_add_region();
	});

	/* Submit modifying school data */
	$("#button_edit_school_confirm").click(function(){
		request_modify_school();
	});

	/* Submit modifying action data */
	$("#button_edit_action_confirm").click(function(){
		request_modify_action();
	});

	$(".modify-action-fields").on('input', function(){
		//console.log("changed");
		if(validate_edit_action_form()) {
			$("#button_edit_action_confirm").prop('disabled',false);
		} else {
			$("#button_edit_action_confirm").prop('disabled',true);
		}
	});

	/* Change checkbox to be switch*/
	$("[name='switch']").bootstrapSwitch();

	/* Get sutdent data when the student record tab clicked. */
	$("#tab_show_student").click(function(){
		getAllStudentScore();
	});

	$("#tab_manage_region").click(function(){
		refresh_region_table();
	});

	$("#tab_show_notification").click(function(){
		getAllImages();
	});

	/* Get all action data when the manage action tab clicked. */
	$("#tab_manage_action").click(function(){
		refresh_action_table();
	});

	/* Get all the admin data*/
	$("#tab_manage_admin").click(function(){
		refresh_admin_table();
	});
	$("#refresh_admin_table").click(function(){
		refresh_admin_table();
	});

	/* Enable datepicker*/
	$( function() {
		$("#old_data_date_picker").datepicker();
	} );

	/* Archive old data */
	$("#submit_archive_old_data").click(function(){
		var date = $("#old_data_date_picker").val();
		console.log(date);
		if (confirm("The operation will clear all the scores earlier than " 
					+ date + ".\nContinue?")) {
			request_archive_old_data();
		}
	});

	/* Validate the add admin form*/
	$(".admin-form-values").on('input', function() {
		if (is_add_admin_form_valid()){
			$("#button_add_admin_confirm").prop('disabled', false);
		} else {
			$("#button_add_admin_confirm").prop('disabled', true);
		}
	});

	/* Validate the edit admin form*/
	$(".edit_admin-form-values").on('input', function() {
		if (is_edit_admin_form_valid()){
			$("#button_edit_admin_confirm").prop('disabled', false);
		} else {
			$("#button_edit_admin_confirm").prop('disabled', true);
		}
	});

	/* Submitting add admin*/
	$("#button_add_admin_confirm").click(function(){
		request_add_admin();
	});

	/* Submitting modify admin */
	$("#button_edit_admin_confirm").click(function(){
		request_edit_admin();
	});
	
});

/* Handle dynamically generated "modify school" buttons  */
$(document).on('click', '.edit_school_buttons', function(){
	var modifiedId = this.value;

	var school = schoolsInSelectedCity.filter(function(school){
		return school.ID == modifiedId;
	});

	//console.log(school[0].SchoolName);
	$("#popup_modal_edit_school").modal({backdrop: "static"});
	$("#input_country_edit").val($("#countryId option:selected").text());
	$("#input_state_province_edit").val($("#stateId option:selected").text());
	$("#input_city_edit").val($("#cityId option:selected").text());
	$("#input_school_name_edit").val(school[0].SchoolName);
	$("#school_id").val(school[0].ID);
});

/* Handle dynamically generated "delete school" buttons */

$(document).on('click', '.remove_school_buttons', function(){
	var deleteId = this.value;
	var school = schoolsInSelectedCity.filter(function(school){
		return school.ID == deleteId;
	});
	//console.log(school);

	if (confirm("School \"" + school[0].SchoolName + "\" will be deleted \ncontinue?")) {
		request_delete_school(deleteId);
	}
});

$(document).on('click', '.remove_region_buttons', function(){
	var regionName = this.getAttribute("data-region");
	var countryName = this.getAttribute("data-country");
	if (confirm("Region will be deleted \ncontinue?")) {
		request_delete_region(countryName, regionName);
	}
});

/* Handle dynamically generated "modify action" buttons*/
$(document).on('click', '.modify_action_links', function(){
	var modifyId = this.name;

	var action = actions.filter(function(action){
		return action.ID == modifyId;
	});

	refresh_Category();
	//console.log(action);

	$("#popup_modal_edit_action").modal({backdrop: "static"});
	$("#input_edit_action_description").val(action[0].Description);
	$("#input_edit_action_points").val(action[0].Points);
	$("#input_edit_category").val(action[0].Category);
	$("#edit_action_id").val(action[0].ID);

});

$(document).on('click','#button_add_admin', function(){
	$("#popup_modal_add_admin").modal({backdrop: "static"});
	$("#button_add_admin_confirm").prop('disabled', true);
});

$(document).on('click', '.edit_admin_buttons', function(){
	$("#popup_modal_edit_admin").modal({backdrop: "static"});
	var modifyAdmin = admins[this.value];

	//console.log(modifyAdmin);

	$("#input_edit_admin_username").val(modifyAdmin.Username);
	$("#input_edit_admin_email").val(modifyAdmin.Email);
	$("#input_edit_admin_password").val("");
	$("#input_edit_admin_confirm_password").val("");
	$("#edit_admin_number").val(this.value);
});

$(document).on('click', '.delete_admin_buttons', function(){
	var deleteRn = this.value;
	if (confirm("Your are going to delete \"" + admins[deleteRn].Email +"\",\nContinue?")) {
		request_delete_admin(deleteRn);
	}
});

function filterStudentRecords() {
	var input, filter, table, tr, td, i;
	input = document.getElementById("filterInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("student_table_content");
	tr = table.getElementsByTagName("tr");

	var e = document.getElementById("FilterCategory");
	var strUser = e.options[e.selectedIndex].value;

	for (i = 0; i < tr.length; i++) {
	td = tr[i].getElementsByTagName("td")[Number(strUser)];
		if (td) {
			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}   
	}
}

function request_add_school() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'addSchool',
			Country: $("#countryId option:selected").text(),
			StateProvince: $("#stateId option:selected").text(),
			City: $("#cityId option:selected").text(),
			SchoolName: $("#input_school_name").val()
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != "undefined" && data != null) {
				schoolsInSelectedCity = data;
				update_school_table(schoolsInSelectedCity);
			}
			// data retrieved from server
			// Use the data to change the elements here

		},
		error: function(data){
			console.log(data);
		}
	});

}

function request_add_region() {
	var province = $("#stateId_region option:selected").text();
	var country = $("#countryId_region option:selected").text();
	if (province == "Select State" || province == "Select Province/State" || province == "")
	{
		province = "ALL";
	}
	if (country == "Select Country")
	{
		country = "ALL";
	}

	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'addRegion',
			Country: country,
			StateProvince: province,
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != "undefined" && data != null) {
				regionInSelectedCity = data;
				update_region_table(regionInSelectedCity);
			}
			// data retrieved from server
			// Use the data to change the elements here

		},
		error: function(data){
			console.log(data);
		}
	});
}

function request_modify_school() {
	var schoolId = $("#school_id").val();
	var schoolName = $("#input_school_name_edit").val();
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'modifySchool',
			SchoolId: schoolId,
			SchoolName: schoolName
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != "undefined" && data != null && data.Result=="Success") {
				//console.log(data);
				for (var i = 0; i < schoolsInSelectedCity.length; ++i) {
					if (schoolsInSelectedCity[i].ID == schoolId){
						schoolsInSelectedCity[i].SchoolName = schoolName;
						break;
					}
				}
				//schoolsInSelectedCity = data;
				update_school_table(schoolsInSelectedCity);
			}
			// data retrieved from server
			// Use the data to change the elements here
		},
		error: function(data){
			console.log(data);
		}
	});
}

function request_delete_school(deleteId) {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'deleteSchool',
			SchoolId: deleteId
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != "undefined" && data != null && data.Result=="Success") {
				//console.log(data);
				schoolsInSelectedCity = jQuery.grep(schoolsInSelectedCity, function(school){
					return school.ID != deleteId;
				})
				update_school_table(schoolsInSelectedCity);
			}
		},
		error: function(data){
			console.log(data);
			alert("School contains student data. \n"
					+ "Please delete the students data in this school before deleting it.");
		}
	});
}

function request_delete_region(countryName, regionName) {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'deleteRegion',
			CountryName: countryName,
			RegionName: regionName
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != "undefined" && data != null) {
				regionInSelectedCity = data;
				update_region_table(regionInSelectedCity);
			}
		},
		error: function(data){
			console.log(data);
		}
	});
}

function refresh_school_table(){
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'getAllSchoolsByCity',
			Country: $("#countryId option:selected").text(),
			StateProvince: $("#stateId option:selected").text(),
			City: $("#cityId option:selected").text()
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != "undefined" && data != null) {
				schoolsInSelectedCity = data;
				update_school_table(schoolsInSelectedCity);
			}
			// data retrieved from server
			// Use the data to change the elements here

		},
		error: function(data){
			console.log(data);
		}
	});
}

function refresh_region_table(){
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'getAllRegion',
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != "undefined" && data != null) {
				regionInSelectedCity = data;
				update_region_table(regionInSelectedCity);
			}
			// data retrieved from server
			// Use the data to change the elements here

		},
		error: function(data){
			console.log(data);
		}
	});
}

function update_school_table(schoolsInSelectedCity) {
	$("#school_table_content").empty();
	for (school of schoolsInSelectedCity) {
		//console.log(school);
		$("#school_table_content").append('<tr>'
				+ '<td class="col-xs-2">' + school['Country'] + '</td>'
				+ '<td class="col-xs-3">' + school['StateProvince'] + '</td>'
				+ '<td class="col-xs-2">' + school['City'] + '</td>'
				+ '<td class="col-xs-3">' + school['SchoolName'] + '</td>'
				+ '<td class="col-xs-2"><div class="row"><div class="col-xs-6"><button value="' + school['ID']
				+ '" class= "btn btn-warning edit_school_buttons"><span class="glyphicon glyphicon-edit"></span></button></div>'
				+ '<div class="col-xs-6"><button data-toggle="confirmation" value="' + school['ID']
				+ '" class= "btn btn-danger remove_school_buttons"><span class="glyphicon glyphicon-trash"></span></button></div></div></td>'
				+ '</tr>'
				);
	}
}

function update_region_table(regionInSelectedCity) {
	$("#region_table_content").empty();
	for (region of regionInSelectedCity) {
		//console.log(school);
		$("#region_table_content").append('<tr>'
				+ '<td class="col-xs-2">' + region['CountryName'] + '</td>'
				+ '<td class="col-xs-3">' + region['RegionName'] + '</td>'
				+ '<td class="col-xs-2">'
				+ '<div class="col-xs-6"><button data-toggle="confirmation" data-region="' + region['RegionName'] + '" data-country="' + region['CountryName']
				+ '" class= "btn btn-danger remove_region_buttons"><span class="glyphicon glyphicon-trash"></span></button></div></td>'
				+ '</tr>'
				);
	}
}

function request_add_action() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'addAction',
			Description: $("#input_action_description").val(),
			Points: $("#input_action_points").val()
		},
		dataType: 'JSON',
		success: function(data){
			console.log(data);
			if (data != "undefined" && data != null) {
				actions = data;
				update_action_table(actions);
			}
			// data retrieved from server
			// Use the data to change the elements here

		},
		error: function(data){
			console.log(data);
		}
	});

}

function request_add_category() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'addCategory',
			Description: $("#input_category_description").val(),
			Name: $("#input_category_name").val()
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null) {
				console.log("success");
				actions = data;
				update_action_table(actions);
			}
			// data retrieved from server
			// Use the data to change the elements here

		},
		error: function(data){
			console.log(data);
		}
	});

}

function request_modify_action() {
	modifyId = $("#edit_action_id").val();
	modifyDescription = $("#input_edit_action_description").val();
	modifyPoints = $("#input_edit_action_points").val();
	modifyCategory = $("#action_category option:selected").html();

	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'modifyAction',
			ActionId: modifyId,
			Description: modifyDescription,
			Points: modifyPoints,
			Category: modifyCategory
		},
		dataType: 'JSON',
		success: function(data){
			console.log(data);
			if (data != "undefined" && data != null && data.Result=="Success") {
				console.log(data);
				for (var i = 0; i < actions.length; ++i) {
					if (actions[i].ID == modifyId){
						actions[i].Description = modifyDescription;
						actions[i].Points = modifyPoints;
						actions[i].Category = modifyCategory;
						break;
					}
				}
				// data retrieved from server
				// Use the data to change the elements here

				update_action_table(actions);
			}
		},
		error: function(data){
			console.log(data);
		}
	});
}


function request_toggle_action(toggleActionId) {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'toggleAction',
			ActionId: toggleActionId
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != "undefined" && data != null && data.Result=="Success") {
				//console.log(data);
				//actions = jQuery.grep(actions, function(action){
				//	return action.ID != toggleActionId;
				//});
				for (var i = 0; i < actions.length; ++i) {
					if (actions[i].ID == toggleActionId) {
						actions[i].Active == '1' ? '0' : '1';
					}
				}

				// update_action_table(actions);
			}
		},
		error: function(data){
			console.log(data);
			alert("data not updated, please try again later.");
			update_action_table(actions);
		}
	});

}

function refresh_action_table(){
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getAllActions'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			actions = data;
			update_action_table(actions);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function update_action_table(data) {
	$("#action_table_content").empty();
	var count = 0;
	for (action of data) {
		//console.log(action);
		checkflag = parseInt(action['Active']) == 1 ? 'checked' : 'unchecked';
		//console.log(checkflag);
		$("#action_table_content").append('<tr>'
				+ '<td>' + ++count + '</td>'
				+ '<td><a name=' + action['ID'] + ' class="modify_action_links">' + action['Description'] + '</a></td>'
				+ '<td>' + action['Category'] + '</td>'
				+ '<td>' + action['Points'] + '</td>'
				+ '<td><input value="' + action['ID']
				+ '" type="checkbox" name="switch" data-on-color="success" data-off-color="danger" '
				+ checkflag + '></td>'
				+ '</tr>'
				);
	}

	$("[name='switch']").bootstrapSwitch();
	$('input[name="switch"]').on('switchChange.bootstrapSwitch', function(event, state) {
		var toggleActionId = this.value;
		//console.log(toggleActionId);
		request_toggle_action(toggleActionId);
	});
}

function validate_edit_action_form() {
	return $("#input_edit_action_description").val() != ""
		&& $("#input_edit_action_points").val() != "";
}

function getAllStudentScore() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getAllStudentScore'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != undefined && data != null) {
				students = data;
				update_students_table(students);
				all_yec_countries = getCountriesFromStudentRecord(students);
				//console.log(all_yec_countries);
				update_select_list($("#yecCountryId"), all_yec_countries, "country");
			}
			//update_action_table(actions);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function ShowAllStudentRecords() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getAllStudentInfo'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != undefined && data != null) {
				students = data;
				update_students_table_all(students);
				all_yec_countries = getCountriesFromStudentRecord(students);
				//console.log(all_yec_countries);
				update_select_list($("#yecCountryId"), all_yec_countries, "country");
			}
			//update_action_table(actions);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function getAllImages() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getAllImages'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			if (data != undefined && data != null) {
				images = data;
				update_images(images);
			}
			//update_action_table(actions);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function update_images(images) {
	$("#action_table_images").empty();
	for (image of images)
	{
		$("#action_table_images").append('<tr>'
				+ '<td class="image_id">' + image.id +'</td>'
				+ '<td><img src=\"' + window.location.protocol + "//" + window.location.host + "/" + 'retrieveImage.php?id=' + image.id +'\" height=\"100\" width=\"100\" onclick="window.open(\'' + window.location.protocol + "//" + window.location.host + "/" + 'retrieveImage.php?id=' + image.id +'\')\"></td>'
				+ '<td class="image_flag"><div contenteditable>' + image.favflag + '</td>'
				+ '<td class="image_description"><div contenteditable>' + image.description + '</td>'
				+ '<td>' + (image.userID==-1?"admin":image.userID) + '</td>'
				+ '<td> <button style="height:30px;width:80px" class="update_image_btn">Update</button> </td>'
				+ '<td> <button style="height:30px;width:80px" class="delete_image_btn">Delete</button> </td>'
				+ '</tr>');
	}

	$(".update_image_btn").click(function() {
    	var $row = $(this).closest("tr");   // Find the row
		if (confirm('Are you sure you want to save ' + $row.find('.image_id').text() + '\'s record?')) {
		    update_image_record($row);
		} else {
		    // Do nothing!
		}
	});

	$(".delete_image_btn").click(function() {
    	var $row = $(this).closest("tr");   // Find the row
		if (confirm('Are you sure you want to delete ' + $row.find('.image_id').text() + '\'s record?')) {
		    delete_image_record($row);
		} else {
		    // Do nothing!
		}
	});
}

function update_image_record(row){
	var idt = row.find('.image_id').text();
	var id = Number(idt);
	var idflag = row.find('.image_flag').text();
	var idflagnum = Number(idflag);
	var descrip = row.find('.image_description').text();

	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'modifyImageRecord',
			ImageID:id,
			FavFlagID:idflagnum,
			Description:descrip
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null && data.Result=="Success") {
				getAllImages();
			}
		},
	 	error: function(data){
			console.log(data);
		}
	});
}

function delete_image_record(row){
	var idt = row.find('.image_id').text();
	var id = Number(idt);

	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'deleteImageRecord',
			ImageID:id,
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null && data.Result=="Success") {
				getAllImages();
			}
		},
	 	error: function(data){
			console.log(data);
		}
	});
}

function update_students_table_all(students) {
	var rank = 0;
	var sameScoreCount = 1;
	var previousScore = 0;

	$("#student_table_content").empty();
	console.log(students);
	for (student of students) {
		currentScore = parseInt(student.Score);
		if (currentScore == previousScore) {
			++sameScoreCount;
		} else {
			rank+=sameScoreCount;
			sameScoreCount = 1;
		}


		previousScore = currentScore;

		$("#student_table_content").append('<tr>'
				+ '<td>' + rank +'</td>'
				+ '<td>' + student.Country +'</td>'
				+ '<td>' + student.StateProvince + '</td>'
				+ '<td>' + student.City +'</td>'
				+ '<td>' + student.SchoolName +'</td>'
				+ '<td class="student_table_ln"><div contenteditable>' + student.LastName + '</td>' 
				+ '<td class="student_table_fn"><div contenteditable>' + student.FirstName +'</td>'
				+ '<td class="student_table_NickName"><div contenteditable>' + student.NickName + '</td>'
				+ '<td class="student_table_Email"><div contenteditable>' + student.Email + '</td>'
				+ '<td class="student_table_UserID" style="display:none;">' + student.UserID + '</td>'
				+ '<td> <button style="height:30px;width:60px" class="update_students_btn">Update</button> </td>'
				+ '<td> <button style="height:30px;width:60px" class="delete_students_btn">Delete</button> </td>'
				+ '</tr>');
	}

	$(".update_students_btn").click(function() {
    	var $row = $(this).closest("tr");   // Find the row
		if (confirm('Are you sure you want to save ' + $row.find('.student_table_ln').text() + ' ' + $row.find('.student_table_fn').text() + '\'s record?')) {
		    update_students_record_all($row);
		} else {
		    // Do nothing!
		}
	});

	$(".delete_students_btn").click(function() {
    	var $row = $(this).closest("tr");   // Find the row
		if (confirm('Are you sure you want to delete ' + $row.find('.student_table_ln').text() + ' ' + $row.find('.student_table_fn').text() + '\'s record?')) {
		    delete_students_record_all($row);
		} else {
		    // Do nothing!
		}
	});

}

function update_students_table(students) {
	var rank = 0;
	var sameScoreCount = 1;
	var previousScore = 0;

	$("#student_table_content").empty();
	console.log(students);
	for (student of students) {
		currentScore = parseInt(student.Score);
		if (currentScore == previousScore) {
			++sameScoreCount;
		} else {
			rank+=sameScoreCount;
			sameScoreCount = 1;
		}


		previousScore = currentScore;

		$("#student_table_content").append('<tr>'
				+ '<td>' + rank +'</td>'
				+ '<td>' + student.Country +'</td>'
				+ '<td>' + student.StateProvince + '</td>'
				+ '<td>' + student.City +'</td>'
				+ '<td>' + student.SchoolName +'</td>'
				+ '<td class="student_table_ln"><div contenteditable>' + student.LastName + '</td>' 
				+ '<td class="student_table_fn"><div contenteditable>' + student.FirstName +'</td>'
				+ '<td class="student_table_NickName"><div contenteditable>' + student.NickName + '</td>'
				+ '<td class="student_table_Email"><div contenteditable>' + student.Email + '</td>'
				+ '<td>' + student.Score + '</td>'
				+ '<td class="student_table_UserID" style="display:none;">' + student.UserID + '</td>'
				+ '<td> <button style="height:30px;width:60px" class="update_students_btn">Update</button> </td>'
				+ '<td> <button style="height:30px;width:60px" class="delete_students_btn">Delete</button> </td>'
				+ '</tr>');
	}

	$(".update_students_btn").click(function() {
    	var $row = $(this).closest("tr");   // Find the row
		if (confirm('Are you sure you want to save ' + $row.find('.student_table_ln').text() + ' ' + $row.find('.student_table_fn').text() + '\'s record?')) {
		    update_students_record($row);
		} else {
		    // Do nothing!
		}
	});

	$(".delete_students_btn").click(function() {
    	var $row = $(this).closest("tr");   // Find the row
		if (confirm('Are you sure you want to delete ' + $row.find('.student_table_ln').text() + ' ' + $row.find('.student_table_fn').text() + '\'s record?')) {
		    delete_students_record($row);
		} else {
		    // Do nothing!
		}
	});

}

//Roger
function update_students_record(row){
	var idt = row.find('.student_table_UserID').text();
	var id = Number(idt);
	var fn = row.find('.student_table_fn').text();
	var ln = row.find('.student_table_ln').text();
	var nickName = row.find('.student_table_NickName').text();
	var email = row.find('.student_table_Email').text();

	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'modifyStudentRecord',
			UserID: id,
			FirstName: fn,
			LastName: ln,
			NickName: nickName,
			Email:email
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null && data.Result=="Success") {
				getAllStudentScore();
			}
			// data retrieved from server
			// Use the data to change the elements here
		},
 		error: function(data){
			console.log(data);
		}
	});
}

function update_students_record_all(row){
	var idt = row.find('.student_table_UserID').text();
	var id = Number(idt);
	var fn = row.find('.student_table_fn').text();
	var ln = row.find('.student_table_ln').text();
	var nickName = row.find('.student_table_NickName').text();
	var email = row.find('.student_table_Email').text();

	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'modifyStudentRecord',
			UserID: id,
			FirstName: fn,
			LastName: ln,
			NickName: nickName,
			Email:email
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null && data.Result=="Success") {
				ShowAllStudentRecords();
			}
			// data retrieved from server
			// Use the data to change the elements here
		},
 		error: function(data){
			console.log(data);
		}
	});
}

function delete_students_record(row) {
	var id = row.find('.student_table_UserID').text();
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'deleteStudentRecord',
			UserID: id
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null && data.Result=="Success") {
				getAllStudentScore();
			}
		},
 		error: function(data){
			console.log(data);
		}
	});
}

function delete_students_record_all(row) {
	var id = row.find('.student_table_UserID').text();
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'deleteStudentRecord',
			UserID: id
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null && data.Result=="Success") {
				ShowAllStudentRecords();
			}
		},
 		error: function(data){
			console.log(data);
		}
	});
}

function getCountriesFromStudentRecord(students) {
	var countries = [];
	for (student of students) {
		countries.push(student.Country);
	}

	//console.log(countries);
	return unique(countries);
}

function getStatesFromStudentRecord(students, selectedCountry) {
	var states = [];
	var studentsInTheCountry = students.filter(function(student){
		return student.Country == selectedCountry;
	});

	update_students_table(studentsInTheCountry);

	for (student of studentsInTheCountry) {
		states.push(student.StateProvince);
	}

	//console.log(states);

	return unique(states);
}

function getCitiesFromStudentRecord(students, selectedCountry, selectedState) {
	var cities = [];
	var studentsInTheState = students.filter(function(student){
		return student.Country == selectedCountry && student.StateProvince == selectedState;
	});

	update_students_table(studentsInTheState);

	for (student of studentsInTheState) {
		cities.push(student.City);
	}

	//console.log(cities);

	return unique(cities);
}

function getschoolsFromStudentRecord(students, selectedCountry, selectedState, selectedCity) {
	var schools = [];
	var studentsInTheCity = students.filter(function(student){
		return student.Country == selectedCountry
			&& student.StateProvince == selectedState
			&& student.City == selectedCity;
	});

	console.log(studentsInTheCity);

	update_students_table(studentsInTheCity);

	for (student of studentsInTheCity) {
		schools.push(student.SchoolName);
	}

	return unique(schools)
}

function getStudentsFromStudentRecord(students, selectedCountry, selectedState, selectedCity, selectedSchool) {
	return students.filter(function(student){
		return student.Country == selectedCountry
			&& student.StateProvince == selectedState
			&& student.City == selectedCity
			&& student.SchoolName == selectedSchool;
	});
}

function unique(array) {
	//console.log(array);
	array.sort();
	var previous;

	for (var i = 0; i < array.length; ++i) {
		if (array[i] == previous) {
			array[i] = "";
		} else {
			previous = array[i];
		}
	}
	return jQuery.grep(array, function(val){
		return val != "";
	});
}

function update_select_list(select, data, itemName) {
	select.empty();
	select.append('<option>Select ' + itemName + '</option>');
	select.append('<option disabled>  ---------- </option>');
	for (var i = 0; i < data.length; ++i) {
		select.append('<option>' + data[i] + '</option>');
	}
}

function get_myNotification_table() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'myNotification'},
		dataType: 'JSON',
		success: function(data){
			showUpMessage(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function showUpMessage(data) {
	$(messageHistory).empty();
	$(messageHistory).append(
			'<p class="text-justify" style="  word-break: break-all;word-wrap: break-word;">' + data[0]["Message"] + '</p>'
			+'<p class="text-justify" style="  word-break: break-all;word-wrap: break-word;">'+ data[0]["PostTime"]+'</p>'
			);
}

function deleteNotification() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'deleteMyNotification'},
		dataType: 'JSON',
		success: function(data){
			get_myNotification_table();
		},
		error: function(data){
			// console.log(data);
		}
	});
}

function request_archive_old_data() {
	var date = $("#old_data_date_picker").val()
			.replace(/(\d\d)\/(\d\d)\/(\d{4})/, "$3-$1-$2");
	
	console.log(date);

	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'archiveOldAccomplishment',
			Date: date
		},
		dataType: 'JSON',
		success: function(data){
			alert("Data archived.");
		},
		error: function(data){
			console.log(data);
		}
	});
}

function refresh_admin_table() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'getAllAdmins'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			admins = data;
			update_admin_table(admins);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function uploadImage() {
    var imageHtml = document.getElementById('imageToUpload').files[0];
    var descriptionContent = document.getElementById('imageDescription').value;
    var formData = new FormData();
    var reader = new FileReader();
    reader.onload = function(){
        var imageContent = reader.result;
        formData.append('QueryData', 'saveUploadedImage');
        formData.append("image", imageContent);
        formData.append("description", descriptionContent);

        $.ajax({
            type: "POST",
            url: "/querydata.php",
            success: function (data) {
                alert("Image upload successful!");
                getAllImages();
            },
            error: function (error) {
                console.log("fail");
                console.log(error);
            },
            async: true,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 60000
        });
    }
    // var blob = imageHtml.slice(0, imageHtml.size);
    reader.readAsDataURL(imageHtml);
    // reader.readAsBinaryString(imageHtml);
}

function update_admin_table(admins) {
	//console.log(admins);
	$("#admin_table_content").empty();
	var rowNo = 0;
	var currentAuth = parseInt(admins[0].Authorization);
	
	//console.log(currentAuth);

	for (admin of admins) {
		var disabledDelete = parseInt(admin['Authorization']) < currentAuth ? "" : " disabled";
		//console.log(disabled);
		
		$("#admin_table_content").append('<tr>' 
				+ '<td>' + (rowNo + 1) +'</td>'
				+ '<td>' + admin['Username'] + '</td>'
				+ '<td>' + admin['Email'] + '</td>'
				+ '<td>' 
				+	'<button value="' 
				+		rowNo
				+	'" class="btn btn-warning edit_admin_buttons"><span class="glyphicon glyphicon-edit"></span></button>'
				+	'<button value="' 
				+		rowNo++
				+   '" class="btn btn-danger delete_admin_buttons"' 
				+		disabledDelete 
				+   '><span class="glyphicon glyphicon-minus"></span></button>'
				+ '</td>'
				+ '</tr>');

	}

	if (currentAuth == 9) {
		$("#admin_page_content").empty();
		$("#admin_page_content").append('<button id="button_add_admin" class="btn btn-success">Add</button>');

	}
}

function is_add_admin_form_valid() {
	if ($("#input_admin_username").val() == "" 
			|| $("#input_admin_email").val() == ""
			|| $("#input_admin_password").val() == ""
			|| $("#input_admin_confirm_password").val() == ""
			|| $("#input_admin_authorization").val() == ""
			)
		return false;

	if ($("#input_admin_password").val() != $("#input_admin_confirm_password").val())
		return false;
	return true;
}

function is_edit_admin_form_valid() {
	if ($("#input_edit_admin_username").val() == "" 
			|| $("#input_edit_admin_password").val() == ""
			|| $("#input_edit_admin_confirm_password").val() == ""
			)
		return false;

	if ($("#input_edit_admin_password").val() != $("#input_edit_admin_confirm_password").val())
		return false;
	return true;
}

function request_add_admin() {
	//console.log("confirm add admin");
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'addAdmin',
			Username: $("#input_admin_username").val(),
			Password: $("#input_admin_password").val(),
			Email: $("#input_admin_email").val(),
			Authorization: $("#input_admin_authorization").val()
		},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			admins = data;
			update_admin_table(admins);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function request_edit_admin() {
	var edit_admin_number =$("#edit_admin_number").val(); 
	console.log(edit_admin_number);
	var edit_admin_username = $("#input_edit_admin_username").val();
	var edit_admin_password = $("#input_edit_admin_password").val();
	var edit_admin_id = admins[edit_admin_number].ID;

	console.log(admins[edit_admin_number]);
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'modifyAdmin',
			Username: edit_admin_username,
			Password: edit_admin_password,
			AdminId: admins[edit_admin_number].ID
		},
		dataType: 'JSON',
		success: function(data){
			console.log(data);
			if (data.Result == "Success") {
				admins[edit_admin_number].Username = edit_admin_username;
				update_admin_table(admins);
			}
		},
		error: function(data){
			console.log(data);
		}
	});
}

function request_delete_admin(deleteRn) {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'deleteAdmin',
			AdminId: admins[deleteRn].ID
		},
		dataType: 'JSON',
		success: function(data){
			console.log(data);
			admins = data;
			update_admin_table(admins);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function populate_delete_category_dropdown()
{
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'getAllCategory',
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null) {
				$("#delete_category_list").empty();
				var popupSelect = document.getElementById('delete_category_list');
				for (category of data) {
					var newOption = document.createElement('option');
					newOption.value = category['categoryName'];
					if (typeof newOption.textContent === 'undefined')
					{
					    newOption.innerText = category['categoryName'];
					}
					else
					{
					    newOption.textContent = category['categoryName'];
					}
					popupSelect.appendChild(newOption);
				}
			}
		},
		error: function(data){
			console.log(data);
		}
	});
}

function request_delete_category() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'deleteCategory',
			Name: $("#delete_category_list").val()
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null) {
				console.log("success");
				actions = data;
				update_action_table(actions);
			}
		},
		error: function(data){
			console.log(data);
		}
	});
}

function refresh_Category() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {
			QueryData: 'getAllCategory',
			Description: $("#input_category_description").val(),
			Name: $("#input_category_name").val()
		},
		dataType: 'JSON',
		success: function(data){
			if (data != "undefined" && data != null) {
				categories = data;
				update_category_select(categories);
			}
			// data retrieved from server
			// Use the data to change the elements here

		},
		error: function(data){
			console.log(data);
		}
	});
}

function update_category_select(categories) {
	$("#action_category").empty();
	var mySelect = document.getElementById('action_category');
	for (category of categories) {
		var newOption = document.createElement('option');
		newOption.value = category['categoryName'];
		if (typeof newOption.textContent === 'undefined')
		{
		    newOption.innerText = category['categoryName'];
		}
		else
		{
		    newOption.textContent = category['categoryName'];
		}

		mySelect.appendChild(newOption);
	}
}