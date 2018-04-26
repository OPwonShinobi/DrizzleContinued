<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">User Profile</h4>
</div>

<div class="modal-body text-center">
    <?php echo '<img src="images/userphoto/'.$_SESSION['PhotoId'].'.png" name="aboutme" width="140" height="140" border="0" class="img-circle center"> '?>
    <p>Nick Name: <?php echo $_SESSION['Username']; ?></p>
    <p>Your Current Score: <div id="currentS"></div></p>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary btn-block" data-toggle="tab" data-target="#edit_profile">Edit</button>
    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button>
</div>