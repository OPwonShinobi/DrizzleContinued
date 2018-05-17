<?php
/* This file isn't used. It can save uploaded images to a mysql db as a longblob using POST, but has an upload limit of ~2MB. Anything bigger will be null when sent over POST. The site currently runs off ajax using the saveUploadedImage function in querydata.php. To future devs feel free to use this if saveUploadedImage fails. */

if(isset($_POST["submit"])){
    $check = false;
    echo "<script>console.log('here is ".filesize($_FILES["image"]["tmp_name"])."')</script>";
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        /*
         * Insert image data into database
         */
        
        //DB details
        $dbHost     = 'localhost';
        $dbUsername = 'yecuser';
        $dbPassword = 'yec123!Q@W#E';
        $dbName     = 'yecdata';
        
        //Create connection and select DB
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
        // Check connection
        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }
        
        $dataTime = date("Y-m-d H:i:s");
        
        //Insert image content into database
        $insert = $db->query("INSERT into Images (image, created, userID, description) VALUES ('$imgContent', '$dataTime', '-1', '')");
        if($insert){
            echo "File uploaded successfully.";
            echo '<button onclick="goBack()">Go back</button>';
        }else{
            echo "File upload failed, please try again.";
            echo '<button onclick="goBack()">Go back</button>';
        } 
    }else{
        echo "Please select an image file to upload.";
        echo '<button onclick="goBack()">Go back</button>';
    }
}
?>

<script>
function goBack() {
    window.history.back();
}
</script>
