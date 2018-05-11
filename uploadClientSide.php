<?php
session_start();
if(isset($_POST)){
    saveUploadedImage();
    header("Location: /index.php");
}

function saveUploadedImage() 
{
    define("DB_HOST", "localhost");
    define("DB_USER", "yecuser");
    define("DB_PASSWORD", "yec123!Q@W#E");
    define("DB_DATABASE", "yecdata");
    try {
        $conn = new PDO("mysql:host=".DB_HOST .";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    if ($conn) 
    {
        $stmt = $conn->prepare("INSERT into Images (image, created, userID, description) VALUES (:image, NOW(), :Userid, :description)");
        $stmt->bindValue("image", $_FILES["image"]);
        // $stmt->bindParam("dateSubmitted", date("Y-m-d H:i:s"));
        $stmt->bindParam("Userid", $_SESSION['Userid']);
        $stmt->bindParam("description", $_POST["description"]);
        $result = $stmt->execute();
        if ($result) 
        {
            // $response = array("ImageUploadResult"=>"Success");
            echo json_encode($result);
        } else {
            $response = array("ImageUploadResult"=>"Fail");
            echo json_encode($response);            
        }
    }
}
?>
