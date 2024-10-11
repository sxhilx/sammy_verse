<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Timeline</title>
    <?php
        session_start();
        $firstName = $_SESSION['firstName'];
        $lastName = $_SESSION['lastName'];
    ?>
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
        }
        .profile-section {
            margin: 20px;
            font-family: Arial, sans-serif;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .upload-link {
            color: purple;
            text-decoration: underline;
            cursor: pointer;
        }
        
        #imageUpload {
            display: none;
        }
        
        .preview-image {
            max-width: 100px;
            max-height: 100px;
            display: none;
            margin-top: 10px;
        }

        .post-section, .search-section , .message-section{
            display: flex;
            flex-direction: column;
            align-items: center;
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
            width: 100%;
            font-size: 20px;
        }

        .posts{
            border: 1px solid black;
            width: 100%;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            font-size: 20px;
        }

        .search-input{
            border: 1px solid black;
            width: 100%;    
            padding: 10px;
            border-radius: 5px;
            font-size: 20px;
        }

        .search-results{
            border: 1px solid black;
            width: 100%;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            font-size: 20px;
        }

        .messages{
            border: 1px solid black;
            width: 100%;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            font-size: 20px;
        }

        
        
    </style> 
</head>
<body>
    <div class="main">
        <h1>Welcome, 
            <?php
                echo $firstName . " " . $lastName;
            ?>
        </h1>

        <div class="profile-section">
            <img id="preview" class="preview-image" alt="Preview">
            <form action="upload_profile.php" method="post">
                <div class="profile-header">
                    
                    <label for="imageUpload" class="upload-link">Upload New Profile Picture</label>
                    <input name="profilePic" type="file" id="imageUpload" accept="image/*" onchange="previewImage(event)">
                    <button type="submit" name="upload" >Upload</button>
                </div>
            </form>

            
           
            
        </div>
        <div class="post-section">
            <form action="posts.php" method="post">
                <div>
                    <textarea name="post" cols="70" rows="5" placeholder="What's on your mind?"></textarea><br>
                    <button type="submit">Post</button>      
                </div>    
                
            </form>

            <h3>Your Posts</h3>
            <div class="posts">                

                <?php
                    session_start(); 
                    $conn = new mysqli('localhost', 'root', '', 'sammy_verse');

                    if ($conn->connect_error) {
                        die('Connection Failed: ' . $conn->connect_error);
                    }

                
                    $userId = $_SESSION['id']; 

                    $stmt = $conn->prepare("SELECT content, created_at FROM posts WHERE user_id = ? ORDER BY created_at DESC");
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='post-content'><p>" . $row['content'] . "</p><small>" .$row['created_at'] . "</small></div>";
                        }
                    }else{
                        echo "<div class='post-content'><p>No posts yet</p></div>";
                    }
                    

                    $stmt->close();
                    $conn->close();
                ?>
            </div>
        </div>

        <div class="search-section">
            <h2>Search User</h2>
            <form action="" method="post">
                <div>
                    <input type="text" name="search" placeholder="Search User" class="search-input">
                    <button type="submit">Search</button>
                </div>
            </form>
            <h3>Search result</h3>
            <div class="search-results">
                <?php
                    session_start(); 
                    $search = $_POST['search'];
                    $conn = new mysqli('localhost', 'root', '', 'sammy_verse');

                    if ($conn->connect_error) {
                        die('Connection Failed: ' . $conn->connect_error);
                    }

                    $stmt = $conn->prepare("SELECT id, firstName, lastName, email FROM users WHERE firstName LIKE ? OR lastName LIKE ? OR email LIKE ?");
                    $stmt->bind_param("sss", $search, $search, $search);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<p> Name: " . $row['firstName'] . " " . $row['lastName'] . "</p>";
                            echo "<p> Email: " . $row['email'] . "</p>";
                            echo "<p> <a href='profile.php?id=" . $row['id'] . "'>View Profile</a> </p>";
                            echo "<a href='send_message.php?receiver_id=" . $row['id'] . "'>Send Message</a></p>";
                        }
                    }else{
                        echo "<p>No user found</p>";
                    }
                    $stmt->close();
                    $conn->close();
                ?>
            </div>
        
        </div>

        <div class="message-section">
            <h3>Your Messages</h3>
            <div class="messages">
            <?php
                session_start();


                $userId = $_SESSION['id'];
                $conn = new mysqli('localhost', 'root', '', 'sammy_verse');

                if ($conn->connect_error) {
                    die('Connection Failed: ' . $conn->connect_error);
                }

                $stmt = $conn->prepare("SELECT messages.id, messages.message, messages.timestamp, users.firstName, users.lastName 
                                        FROM messages 
                                        JOIN users ON messages.sender_id = users.id 
                                        WHERE messages.receiver_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();


                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='message'>";
                        echo "<p><strong>" . $row['firstName'] . " " . $row['lastName'] . "</strong>: " . $row['message'] . "</p>";
                        echo "<p><small>Sent on: " . $row['timestamp'] . "</small></p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No messages found.</p>";
                }

                $stmt->close();
                $conn->close();
            ?>
        </div>
        </div>


    </div>


    <script>
        function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Show the preview
            }
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>
</html>