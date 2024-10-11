<?php


$email = $_POST['email'];
$password = $_POST['password'];

$conn = new mysqli('localhost', 'root', '', 'sammy_verse');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    $sql = "SELECT * FROM users WHERE email = '$email' and password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();        
        $_SESSION['email'] = $row['email'];
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];  
        $_SESSION['id'] = $row['id'];
        header("Location: homepage.php");
        exit();            
        
    } else {
        echo "<style>
                p { color: red; font-size: 25px; text-align: center; }
            </style>";
        echo "<p>User Not Found, Invalid Email or Password</p>";
        echo "<p><a href='register.php'>Please Register</a> or <a href='index.html'>Please Enter a Valid Password</a> or <a href='#'>Forget Password</a></p>";
    }

    $conn->close();
}
?>
