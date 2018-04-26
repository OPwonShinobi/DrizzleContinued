<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Profile</h4>
</div>
<form method="POST" class="updatprofile" name="profileform" action="index.php" onsubmit="return checkNickname()">
    <div class="modal-body">
        <div class="form-group text-center">
            <a href="#" data-toggle="tab" data-target="#photo_profile">
                <?php echo
                    '<img src="images/userphoto/'.$_SESSION['PhotoId'].'.png" id="editimage" name="aboutme" width="140" height="140" border="0" class="img-circle center"> '
                ?>
            </a>
        </div>
        <div class="form-group">
            <div id="nick-empty" class="row accounterror" style="display: none"><p>Empty Input.</p></div>
            <label for="usr">Nick Name:</label>
        <?php echo
            '<input type="text" class="form-control" id="usr" name="nickname" maxlength="20" value= '.$_SESSION['Username'].'>'
        ?>

        <?php echo
            '<input type="hidden" id="pid" name="pid" value='.$_SESSION['PhotoId'].'>'
        ?>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block">Save</button>
        <button type="button" class="btn btn-danger btn-block"  data-toggle="tab" data-target="#user_profile" data-dismiss="modal">Cancel</button>
    </div>
</form>