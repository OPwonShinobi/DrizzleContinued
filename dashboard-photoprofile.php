<?php
if (!isset($_SESSION['Userid']))
    header('Location: login.php');
?>
<script>
    var record=0;
    var selectFlag=0;
    function changeIt(img)
    {
        if(selectFlag==1){
            record.style.border="none";
        }
        img.style.border = "thick solid #7bcd8a";
        var name = img.src;
        var filename = name.replace(/^.*[\\\/]/, '');
        var	strFileName = name.replace(/^.*\/|\.[^.]*$/g, '');
        document.getElementById("editimage").src="images/userphoto/"+filename;
        document.getElementById("pid").value=strFileName;
        record=img;
        selectFlag=1;
    }
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Choose Photo</h4>
</div>

<div class="modal-body text-center">
    <div class="row">
        <?php
        $i=0;
        $dirname = "images/userphoto/";
        $images = glob($dirname."*.png");
        foreach($images as $image) {
            echo '
					<div class="col-xs-4 text-center">
						<img src="'.$image.'" id="img'.++$i.'" width="50" height="50" border="0" class="img-circle center" onclick="changeIt(this)" />
					</div>
				';
        }
        ?>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary btn-block" data-toggle="tab" data-target="#edit_profile" >Select</button>
    <button type="button" class="btn btn-danger btn-block"  data-toggle="tab" data-target="#user_profile" data-dismiss="modal">Cancel</button>
</div>