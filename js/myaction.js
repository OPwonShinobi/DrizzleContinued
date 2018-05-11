var myAction = [];
var pointRecord=[];
var categoriesByIndex=[];
var list= [];
var sum = 0;
var actionCounter = 0;
var nameRecord=[];
var shareCounter=0;
var hideSubmitted = false;

$(document).ready(function(){
    myAction = [];
    pointRecord= [];
    categoryRecord=[];
    sum = 0;
    list=[];
    actionCounter = 0;
    nameRecord=[];
    get_myaction_table();
    hideSubmitted = false;
});

function get_myaction_table() {
    $.ajax({
        type: "POST",
        url: "/querydata.php",
        data: {QueryData: 'myActionsWithUserIndication'},
        dataType: 'JSON',
        success: function(data){
            if (hideSubmitted)
                filter_my_action_table(data);
            else
                update_my_action_table(data);
        },
        error: function(data){
            console.log(data);
        }
    });
}

function toggleSubmittedActions(img) {
    //user just checked box, hide submitted
    var src = img.getAttribute('src');
    if (src == 'images/check1.svg')
    {
        img.src = 'images/check2.svg';
        hideSubmitted = true;
    } 
    else
    {
        img.src = 'images/check1.svg';
        hideSubmitted = false;
    }
    get_myaction_table();
}

function filter_my_action_table(data) {
    $("#my_action_content").empty();
    $("#score_content").empty();
    myAction = [];
    pointRecord= [];
    categoryRecord=[];
    list=[];
    nameRecord=[];
    sum = 0;
    actionCounter = 0;
    for (action of data) {
        if (action['CompleteTime'] != null)
        {
            continue;
        }
        var userAction = $(
            '<div class="col-lg-4 text-center" style="color:black">'
            + '<div class="panel panel-default" >'
            + '<div class ="challenge_box">'

            + '<div  class ="row">'
            + '<img src="/images/categories/'+ action['Category'] + '.png" alt="" class ="challenge_img">'
            + '<p class ="challenge_name col-sm-7" style="text-align:left;">'+ action['Description'] + '</p>'
            + '<p class ="label label-danger col-sm-3" style="font-size:1em;margin-left:2%;">Points: ' + action['Points'] +'</p>' 
            + '</div>'

            + '<div class ="row">'
            + '<img src="images/check1.svg" height="50px" width="50px" class ="challenge_check" id = "'+ action['ActionID'] + '" onclick="finishAction(\''+ action['ActionID'] + '\')">'
            + '</div>'

            + '<img src="images/hourglass.svg" style="visibility:hidden" height="150px" width="150px">'
            + '<p style="font-size:40px; ">Ready to submit!</p>'
            + '</div>'
            + '<p style="font-size:18px; visibility:hidden">Submission Time: ' + action['CompleteTime'] +'</p>'
            + '</div>'
            + '</div>'
        );
        $("#my_action_content").append(userAction)
        myAction[action['ActionID']] = 1;
        list.push(action['ActionID']);
        pointRecord[action['ActionID']] = action['Points'];
        nameRecord[action['ActionID']] = action['Description'];
        categoryRecord[action['ActionID']] = action['Category'];
        actionCounter = actionCounter+1;
        get_num_action();
    }
    check_myAction_status();
    update_my_current_pick();
}

function update_my_action_table(data) {
    $("#my_action_content").empty();
    $("#score_content").empty();
    myAction = [];
    pointRecord= [];
    categoryRecord= [];
    list=[];
    nameRecord=[];
    sum = 0;
    actionCounter = 0;
    for (action of data) {
        // submitted actions cannot be changed, instead displays submitted time & 
        // a big hourglass icon over the action
        var submissionStatus = '<p style="font-size:18px; color:black;visibility:hidden">Submission Time: ' + action['CompleteTime'] +'</p>';
        var cooldownStatus = '<p style="font-size:40px; color:black">Cooldown: 1 day</p>';
        var cooldownIcon = $('<img src="images/hourglass.svg" style="color:black;position:relative;z-index:2;" height="150px" width="150px">'); 
        // userActions by default has CompleteTime null,
        // resets submissionStatus & cooldownIcon to allow user to submit again
        if (action['CompleteTime'] == null)
        {
            //make text bigger for no timestamped actions!
            // submissionStatus.css("visibility","hidden"); //i'd use this for submission Status but it's too cramped
            cooldownIcon.css("visibility","hidden"); //hidden but the space is still there
            cooldownStatus = '<p style="font-size:40px; color:black">Ready to submit!</p>';
        }
        var userAction = $(
            '<div class="col-lg-4 text-center">'
            + '<div class="panel panel-default" >'
            + '<div class ="challenge_box">'

            + '<div  class ="row">'
            + '<img src="/images/categories/'+ action['Category'] + '.png" alt="" class ="challenge_img">'
            + '<p class ="challenge_name col-sm-7" style="text-align:left;">'+ action['Description'] + '</p>'
            + '<p class ="label label-danger col-sm-3" style="font-size:1em;margin-left:2%;">Points: ' + action['Points'] +'</p>' 
            + '</div>'

            + '<div class ="row">'
            + '<img src="images/check1.svg" height="50px" width="50px" class ="challenge_check" id = "'+ action['ActionID'] + '" onclick="finishAction(\''+ action['ActionID'] + '\')">'
            + '</div>'

            + cooldownIcon.prop("outerHTML") //return jquery obj as html string
            + cooldownStatus
            + '</div>'
            + submissionStatus
            + '</div>'
            + '</div>'
        );
        // userAction.css("color", "Grey");
        // if userAction has no timestamp (can be submitted), set it black
        // unused for now
        if (action['CompleteTime'] == null)
        {
            userAction.css("color", "black");
        }

        $("#my_action_content").append(userAction)
        myAction[action['ActionID']] = 1;
        list.push(action['ActionID']);
        pointRecord[action['ActionID']] = action['Points'];
        nameRecord[action['ActionID']] = action['Description'];
        categoryRecord[action['ActionID']] = action['Category'];
        actionCounter = actionCounter+1;
        get_num_action();
    }
    check_myAction_status();
    update_my_current_pick();
}

function check_myAction_status() {
    $.ajax({
        type: "POST",
        url: "/querydata.php",
        data: {
            QueryData: 'checkMyactionfinish',
        },
        dataType: 'JSON',
        success: function(data){
            lockAction(data);
        },
        error: function(data){

        }
    });
}

/* Updates the UI to signal a finished action. Doesn't do anything on backend. */
function finishAction(id) {
    var S = document.getElementById(id);
    if(myAction[id] == 1) {
        S.src='images/check2.svg';
        myAction[id] = 2;
    }
    else if(myAction[id] == 2){
        S.src='images/check1.svg';
        myAction[id] = 1;
    }
}

/* Updates action in database to finished. */
function finish_my_action(actionId) {
    $.ajax({
        type: "POST",
        url: "/querydata.php",
        data: {
            QueryData: 'finishAction',
            ActionId:  actionId
        },
        dataType: 'JSON',
        success: function(data){
            console.log("Just added accomplishment");
            get_myaction_table();
        },
        error: function(data){
            console.log("failed to add accomplishment:" + data);
        }
    });
}
function submit_my_finish() {
    shareCounter=0;
    for(var i = 0; i < list.length; i++) {
        if(myAction[list[i]] == 2) {
            finish_my_action(list[i]);
            myAction[list[i]] = 3;
            finishAction(list[i]);
            getUserScore();
            get_myfinishi_table();
            shareCounter= shareCounter+1;
        }
    }
}

function subCheck(){
    calculatePoint();
    $("#score_content").append(
        '<h2>You will receive ' + sum + ' points. </h2>'
    );
}

function calculatePoint() {
    for(var i = 0; i < list.length; i++) {
        if(myAction[list[i]] == 2) {
            sum = sum + parseInt(pointRecord[list[i]]);
        }
    }
}

function clearScore() {
    $("#score_content").empty();
    sum = 0;
}

function lockAction(data){
    for (action of data) {
        if(action['CompleteActionID']!= null) {
            var S = document.getElementById(action['ActionID']);
            //S is null when it's hidden was hidden
            if (S == null)
                continue;
            myAction[action['ActionID']] = 3;
            S.src='images/check2.svg';
        }
    }

}
