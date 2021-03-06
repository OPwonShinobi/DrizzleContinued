var myAction = [];
var pointRecord=[];
var categoriesByIndex=[];
var list= [];
var sum = 0;
var actionCounter = 0;
var nameRecord=[];
var shareCounter=0;
var hideSubmitted = false;
// ~4MB max image size for uploading, seems like ajax
// file limit is around~4.7MB  
var MAXFILESIZE = 4194304;

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

/* The "hide submitted actions" checkbox is just a plain image. 
This is the function called onclick so it behaves like a checkbox
and the actions are hidden.
*/
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

/* Get the list of useractions with no CompleteTime timestamps and appends
them to the page. Also resets the action arrays. */
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
            + '<p class="submit-text">Ready to submit!</p>'
            + '</div>'
            + '<p style="font-size:18px;visibility:hidden">Submission Time: </p>'
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

/* Get the entire list of useractions(disregarding timestamps) and appends
them to the page. Also resets the action arrays. */
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
        var submissionStatus = '<p style="font-size:18px; color:black;visibility:hidden">Submission Time: </p>';
        var cooldownStatus = '<p style="font-size:40px; color:black">Cooldown: 1 day</p>';
        var cooldownIcon = $('<img src="images/hourglass.svg" style="color:black;position:relative;z-index:2;" height="150px" width="150px">'); 
        // userActions by default has CompleteTime null,
        // resets submissionStatus & cooldownIcon to allow user to submit again
        if (action['CompleteTime'] == null)
        {
            //make text bigger for no timestamped actions!
            // submissionStatus.css("visibility","hidden"); //i'd use this for submission Status but it's too cramped
            cooldownIcon.css("visibility","hidden"); //hidden but the space is still there
            cooldownStatus = '<p class="submit-text" style="color:black">Ready to submit!</p>';
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
        // if userAction has no timestamp (can be submitted), set it black
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

/* Called every time list of useractions is updated. Disables the submitted
useractions that are on timeout.*/
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

/* Updates action in backend database to finished. */
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

/* Call this function to submit the currently selected actions & get points for them.
After this all selected actions become disabled for a day.*/
function submit_my_finish() {
    shareCounter=0;
    for(var i = 0; i < list.length; i++) {
        if(myAction[list[i]] == 2) {
            finish_my_action(list[i]);
            myAction[list[i]] = 3;
            finishAction(list[i]);
            getSchoolScore();
            getUserScore();
            get_myfinishi_table();
            shareCounter= shareCounter+1;
        }
    }
}

/* Get sum of points of useractions and updates UI on the popup 
submission box to show sum of points.*/
function subCheck(){
    calculatePoint();
    $("#score_content").append(
        '<h2>You will receive ' + sum + ' points. </h2>'
    );
}

/* Updates sum to current sum of all useractions' points. */
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

//filepicker argument should be input elem with type set to 'file'
//call this onchange
function validateImage(filepicker) {
    var uploadBtn = document.getElementById('imageUploadButton');
    document.getElementById("imagePreview").hidden = true;
    document.getElementById("imagePreview").src = "";
    uploadBtn.disabled = true;
    
    var file = filepicker.files[0];
    if (file == undefined || file.size <= 0)
    {
        uploadBtn.value = "please choose a file";
    }
    else if (file.size > MAXFILESIZE) 
    {
         uploadBtn.value = "File size exceeded";
    }
    else if (file.type != "image/jpg" && file.type != "image/jpeg" && file.type != "image/png" && file.type != "image/gif")
    {
        uploadBtn.value = "File must be an image(jpg, png)";
    }
    else
    {
        uploadBtn.disabled = false;
        uploadBtn.value = "Upload";
        generateImagePreview(file);
    }
}

/*
Populates the image upload popup window with a image preview.

imgFile must be a file object from an <input type='file'> 
NOTE, This function creates a temporary URL reference to the 
img file on the system; the file is never loaded into browser memory 
As such, if you clear cache or move the original file the preview may 
break. But for larger files (~4MB) this is much faster than the 
alternative which needs to parse & recreate the file. */
function generateImagePreview(imgFile) {
    var imagePreview = document.getElementById("imagePreview");
    imagePreview.hidden = false;
    imagePreview.src = URL.createObjectURL(imgFile);
}

/* Should only call this function after validateImage has checked 
image file. Call this function to upload an image and a description to 
querydata.php to handle. 
NOTE: the image from an <input> needs to be scanned into the browser first,
then an ajax call is sent to querydata to parse & decode the file. Then it's
copied by value into the db. This could be made more efficient but I couldn't.
To any future devs feel free to simplify this process from
html(input)->js(FileReader)->ajax(FormData)->php(base64_decode)->mysql(longblob)
*/
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
                console.log("img upload success");
                console.log(data);
                $("#uploadSuccessButton").click();
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
    reader.readAsDataURL(imageHtml);
    // reader.readAsBinaryString(imageHtml); doesnt decode properly on php side
}