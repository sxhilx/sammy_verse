<?php

session_start();

$post = $_POST['post'];
$dateTime = date('Y-m-d H:i:s');
$userId = $_SESSION['id'];

$conn = new mysqli('localhost', 'root', '', 'sammy_verse');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO posts (user_id, content, created_at) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $post, $dateTime);
    $stmt->execute();
    $stmt->close();
}
header('Location: homepage.php');
exit();
?>