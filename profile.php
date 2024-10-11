<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'sammy_verse');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $userId = (int)$_GET['id']; 

   
    $stmt = $conn->prepare("SELECT firstName, lastName, email, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        
        echo "<h2>" . htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) . "'s Profile</h2>";
        echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
        if (!empty($user['profile_picture'])) {
            echo "<img src='" . htmlspecialchars($user['profile_picture']) . "' alt='Profile Picture' style='width: 100px; height: 100px;'>";
        } else {
            echo "<p>No profile picture uploaded.</p>";
        }

        
        echo "<h3>Timeline</h3>";
        $stmt = $conn->prepare("SELECT content, created_at FROM posts WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $postsResult = $stmt->get_result();

        while ($post = $postsResult->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<p>" . htmlspecialchars($post['content']) . "</p>";
            echo "<small>" . htmlspecialchars($post['created_at']) . "</small>";
            echo "</div>";
        }


        $stmt->close();

        
    } else {
        echo "<p>User not found.</p>";
    }
    echo "<a href='homepage.php'>Back to Homepage</a>";
} else {
    echo "<p>No user ID provided.</p>";
}

$conn->close();
?>
