<?php
session_start();
if(isset($_POST)){
    // SCRAP THIS, CANT GET USERID
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
    $imgContent = $_POST["image"];
    $description = $_POST["description"];
    $UserID = $_SESSION['UserID'];
    //Insert image content into database
    $insert = $db->query("INSERT into Images (image, created, userID, description) VALUES ('$imgContent', '$dataTime', '$UserID', '$description')");
    if($insert){
        echo "File uploaded successfully.";
        echo '<button onclick="goBack()">Go back</button>';
    }else{
        echo "File upload failed, please try again.";
        echo '<button onclick="goBack()">Go back</button>';
    } 
}else{
    echo "Please select an image file to upload.";
}

?>

<script>
function goBack() {
    window.history.back();
}
</script>