<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'sammy_verse');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}


$userId = $_SESSION['id'];
$profilePicture = '';

if (isset($_FILES['profilePic'])) {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['profilePic']['name']);
    move_uploaded_file($_FILES['profilePic']['tmp_name'], $uploadFile);


    $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
    $stmt->bind_param("si", $uploadFile, $userId);
    $stmt->execute();
    $stmt->close();
}


$conn->close();
header('Location: homepage.php'); 
exit();
?>
