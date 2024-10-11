<?php
session_start();

$receiver_id = $_GET['receiver_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'sammy_verse');

    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    $sender_id = $_SESSION['id']; 
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header('Location: homepage.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Message</title>
</head>
<style>
    .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            border: 1px solid black;
            width: 70%;
            margin: 0 auto;          
            
            margin-top: 20px;
    }
    button {
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 90%;
            font-size: 20px;
    }

</style>
<body>
    <div class="main">
    <h2>Send a Message</h2>
    
    <form method="POST">
        <textarea name="message" placeholder="Type your message here..." cols="70" rows="5" required></textarea>
        <button type="submit">Send</button>
    </form>
    </div>
</body>
</html>
