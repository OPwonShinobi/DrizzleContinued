<?php
//http://localhost:8000/retrieveImage.php?id=2
if(!empty($_GET['id'])){
    //DB details
    $dbHost     = 'localhost';
    $dbUsername = 'yecuser';
    $dbPassword = 'yec123!Q@W#E';
    $dbName     = 'yecdata';
    
    //Create connection and select DB
    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    
    //Check connection
    if($db->connect_error){
       die("Connection failed: " . $db->connect_error);
    }
    
    //Get image data from database
    $result = $db->query("SELECT image FROM images WHERE id = {$_GET['id']}");
    
    if($result->num_rows > 0){
        $imgData = $result->fetch_assoc();
        
        //Render image
        header("Content-type: image/jpg"); 
        echo $imgData['image']; 
    }else{
        echo 'Image not found...';
    }
}
?>