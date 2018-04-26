var myAction = [];
var pointRecord=[];
var list= [];
var sum = 0;
var actionCounter = 0;
var nameRecord=[];
var shareCounter=0;

$(document).ready(function(){
    myAction = [];
    pointRecord= [];
    sum = 0;
    list=[];
    actionCounter = 0;
    nameRecord=[];
    get_myaction_table();

});

function get_myaction_table() {
    $.ajax({
        type: "POST",
        url: "/querydata.php",
        data: {QueryData: 'myActionsWithUserIndication'},
        dataType: 'JSON',
        success: function(data){
            //console.log(data);
            update_my_action_table(data);
        },
        error: function(data){
            //console.log(data);
        }
    });
}

function update_my_action_table(data) {

    $("#my_action_content").empty();
    $("#score_content").empty();
    myAction = [];
    pointRecord= [];
    list=[];
    nameRecord=[];
    sum = 0;
    actionCounter = 0;
    for (action of data) {
        $("#my_action_content").append(
            '<div class="col-lg-4 text-center">'
            + '<div class="panel panel-default">'
            + '<div  class ="challenge_box">'

            + '<div  class ="row">'
            + '<img src="/images/points/'+ action['Points'] + '.png" height="100px" width="100px" alt="" class ="challenge_img">'
            + '<p class ="challenge_name">'+ action['Description'] + ' <br><br> Point: ' + action['Points'] +'</p>'
            + '</div>'

            + '<div  class ="row">'
            + '<img src="images/check1.png" height="50px" width="50px" class ="challenge_check" id = "'+ action['ActionID'] + '" onclick="finishAction(\''+ action['ActionID'] + '\')">'
            + '</div>'
            + '</div>'
            + '</div>'
            + '</div>'
        );
        myAction[action['ActionID']] = 1;
        list.push(action['ActionID']);
        pointRecord[action['ActionID']] = action['Points'];
        nameRecord[action['ActionID']] = action['Description'];
        actionCounter = actionCounter+1;
        get_num_action();
    }
    check_myAction_status();


    update_my_current_pick();
}

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
        },
        error: function(data){

        }
    });
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

function finishAction(id) {
    var S = document.getElementById(id);
    if(myAction[id] == 1) {
        S.src='images/check2.png';
        myAction[id] = 2;
    }
    else if(myAction[id] == 2){
        S.src='images/check1.png';
        myAction[id] = 1;
    }
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
            myAction[action['ActionID']] = 3;
            S.src='images/check2.png';
        }
    }

}
