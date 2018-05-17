<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<script src="js/myaction.js"></script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="my-page-header">
            My Actions <small>The movement for a greener future through youth action</small>
        </h1>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> My Backpack</h2>
            </div>
            <div class="panel-body">
                <!-- <label class="switch"> -->
                    <!-- this also clears the timestamps for stuff older than a day -->
<!--                     <input type="checkbox" id="hide_completed_actions" onchange="get_myaction_table()"> 
                    <span class="slider round"></span> -->
                    <div class="well well-sm" style="min-height: 10px">
                        <img src="images/check1.svg" height="50px" width="50px" onclick="toggleSubmittedActions(this)">
                        <span>Hide Completed</span>
                    </div>
                <!-- </label> -->

                <div class="row" id="my_action_content">

                </div>
                <div class="row">
                    <span class="col-sm-12" style="text-align: center">
                    <!-- <span style="margin-left:45%;">   -->
                        <a class="btn btn-primary btn-lg" data-toggle="modal" data-target="#submitPointsModal" onclick="subCheck()">Submit
                        </a> 
                    <!-- </span> -->
                    <!-- <span class="col-sm-6" style="text-align: left;"> -->
                        <a class="btn btn-info btn-lg" data-toggle="modal" data-target="#uploadImgModel" >
                        Upload an image
                        </a> 
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>

<!-- points submission pop up -->
<div class="modal fade" id="submitPointsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog tab-content" role="document">

        <div id="share_before" class="modal-content tab-pane fade in active">
            <div class="modal-body">
                <h2> Are you sure you want to submit? </h2><br>

                <div id = "score_content"> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearScore()">Close</button>
                <button type="button" class="btn btn-primary" data-toggle="tab" data-target="#share_score" onclick="submit_my_finish()">Save Point</button>
            </div>
        </div>

        <div id="share_score" class="modal-content tab-pane fade">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Share Score</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center"><img width="100px" height="100px" src="images/color/check.png"></div>

                <div class="row text-center"><h2> SUCCESS! </h2></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-block" data-dismiss="modal" data-toggle="tab" data-target="#share_before" onclick="clearScore()">Back</button>
                <!--share to  social medea-->
                <ul class="share-button">
                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.drizzlesociety.org%2F&t=" title="Share on Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><i class="fa fa-facebook-square fa-3x"></i></a></li>
                    <li><a href="https://twitter.com/intent/tweet?source=https%3A%2F%2Fwww.drizzlesociety.org%2F&text=:%20https%3A%2F%2Fwww.drizzlesociety.org%2F&via=DrizzleOrg" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text='+'I just completed '+shareCounter+' actions and earned ' + sum + ' points as part of the Youth Environmental Challenge %23DrizzleYEC. Join us :'  + 'www.youthenvironmentalchallenge.com'); return false;"><i class="fa fa-twitter-square fa-3x"></i></a></li>
                    <li><a href="https://plus.google.com/share?url=https%3A%2F%2Fwww.drizzlesociety.org%2F" target="_blank" title="Share on Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><i class="fa fa-google-plus-square fa-3x"></i></a></li>
                    <li><a href="https://www.instagram.com/drizzlesociety/"><i class="fa fa-instagram fa-3x"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- image upload pop up -->
<div class="modal fade" id="uploadImgModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog tab-content" role="document">
        <div id="uploadModel" class="modal-content tab-pane fade in active">
            <form  method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <h2>Send us a picture of you being green!</h2>
                    <p>Any image you upload may be featured on the homepage.</p>
                    <p>Please note the max size is 4mB per image.</p>
                    <!-- these form elems dont need names, using ajax to submit -->
                    <img src="" id="imagePreview" style="max-height: 150px;max-height: 150px" hidden="true">
                    <input id="imageToUpload" type="file" onchange="validateImage(this)" />
                    <br/>
                    <textarea id="imageDescription" rows="4" style="width: 100%;" placeholder="Write something about your picture!"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="button" id="imageUploadButton" value="No image selected" class="btn btn-primary" disabled="true" onclick="uploadImage()">
                    <!-- this btn is triggered via code to activate a popup, should never click it -->
                    <button type="button" id="uploadSuccessButton" hidden  data-toggle="tab" data-target="#uploadSuccessModal" />
                </div>
            </form>
        </div>

        <div id="uploadSuccessModal" class="modal-content tab-pane fade">
            <div class="modal-body">
                <div class="row text-center"><img width="100px" height="100px" src="images/color/check.png"></div>
                <div class="row text-center"><h2> Upload Success! </h2></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-block" data-dismiss="modal" data-toggle="tab" data-target="#uploadModel">Back</button>
            </div>
        </div>
    </div>
</div>