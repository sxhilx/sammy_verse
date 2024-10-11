<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Email Validation
    $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
    
    if (preg_match($pattern, $email)) { 
        $conn = new mysqli('localhost', 'root', '', 'sammy_verse');

        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<style>
                        p { color: red; font-size: 25px; text-align: center; }
                      </style>";
                echo "<p>User Already Exists</p>";
                echo "<p><a href='index.html'>Please Login</a></p>";
            } else {
                $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
                $stmt->execute();
                echo "<style>
                        p { color: red; font-size: 25px; text-align: center; }
                    </style>";
                echo "<p>Registration Successful</p>";
                echo "<p><a href='index.html'>Click here to go to Login</a></p>";

            }

            $stmt->close();
            $conn->close();
        }
    } else {
        header('Location: register.php?invalid-email');
        exit();
    }
}
?>
