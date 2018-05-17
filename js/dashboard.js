var actionCompleted = 0;
$(document).ready(function(){
  get_myfinishi_table();
  display_myNotification_table();
});

function get_num_action() {
  $(".myActions").empty();

  $(".myActions").append(
    actionCounter
  );
}

function display_score() {
  $(".myScore").empty();

  $(".myScore").append(
    user_score
  );
  $("#currentS").empty();
  $("#currentS").append(
      user_score
  );
}

function display_school_score() {
  $(".schoolScore").empty();

  $(".schoolScore").append(
    school_score
  );
}

function get_action_completed(data) {
  actionCompleted = 0;
  for (action of data) {
    actionCompleted += 1;
  }
}

function display_completed() {
  $(".challengeCompleted").empty();
  //$(".challengeCompleted").text(actionCompleted);
  $(".challengeCompleted").append(actionCompleted);
}

function get_myfinishi_table() {
	$.ajax({
		type: "POST",
		url: "/querydata.php",
		data: {QueryData: 'myComplishment'},
		dataType: 'JSON',
		success: function(data){
			//console.log(data);
			update_my_complishment_table(data);
      get_action_completed(data);
      //console.log("Completed: " + actionCompleted);
      display_completed();
		},
		error: function(data){
			//console.log(data);
		}
	});
}

function update_my_complishment_table(data) {
    var counter = 0;
    console.log(data);
  $("#finish_history").empty();
  for (action of data) {
      if(counter<=15) {
          $("#finish_history").append('<tr>'
              + '<td class="col-xs-5">' + action["Description"] + '</td>'
              + '<td class="col-xs-5">' + action["CompleteTime"] + '</td>'
              + '</tr>'
          );
          counter = counter +1;
      }
      else {
          break;
      }
  }
}

function update_my_current_pick() {
  $("#current_pick").empty();
	for(var i = list.length - 1 ; i >= list.length - 3 && i >=0; i--) {
    $("#current_pick").append(
      '<div class="col-lg-4 text-center">'
        + '<div class="panel panel-default">'
        + '<div class ="challenge_box">'
        + '<div class="row">'
        + '<img src="/images/categories/'+ categoryRecord[list[i]] + '.png" height="100px" width="100px" style="margin-left:10%" alt="' + categoryRecord[list[i]] 
        + '" class ="challenge_img">'
        + '<p class ="challenge_name">'+nameRecord[list[i]] + ' <br><br> Point: ' + pointRecord[list[i]] +'</p>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
    );
	}
}


function checkNickname() {
    var x = document.forms["profileform"]["nickname"].value;
    if (x.match(/\s/g)){
        document.getElementById('nick-empty').innerHTML="Can't have space."
        document.getElementById('nick-empty').style.display='block';
        return false;
    }
    if (x == "") {
        document.getElementById('nick-empty').innerHTML="Empty input."
        document.getElementById('nick-empty').style.display='block';
        return false;
    }
    var filter = new Filter();
    var nicknameLowerCase=x.toLowerCase();
    if(filter.isProfane(nicknameLowerCase)){
        document.getElementById('nick-empty').innerHTML = "Bad words detected."
        document.getElementById('nick-empty').style.display = 'block';
        return false;
    }      
}


function display_myNotification_table() {
    $.ajax({
        type: "POST",
        url: "/querydata.php",
        data: {QueryData: 'myNotification'},
        dataType: 'JSON',
        success: function(data){
            displayNotification(data);
        },
        error: function(data){
            console.log(data);
        }
    });
}

function displayNotification(data) {
    $(notificationbar).empty();
    if(data[0]!=null) {
        $(notificationbar).append(
            '<div class="alert alert-danger alert-dismissable fade in col-xs-12">'
            + '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
            + '<strong>Notification:</strong>'
            + '<p class="text-left" style="  word-break: break-all;word-wrap: break-word;">' + data[0]["Message"] +'<br>'
            + data[0]["PostTime"] +'</p>'
            + '</div>'
        );
    }

}
