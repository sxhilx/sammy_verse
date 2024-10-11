<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            background-color: #10375C;
            color: #F4F6FF;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;            
        }

        h1{
            color: #EB8317;
        }
        
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        label{
            
            font-size: larger;
            
        }

        input{
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size: large;
            width: 100%;
            border: none;
            border-radius: 5px;
            padding: 5px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        button{
            margin-top: 30px; 
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size: large;
            width: 100%;
            background-color: #F3C623;
            border: none;
            border-radius: 5px;
            padding: 8px;
        }

        a{
            text-decoration: none;
            color: #F3C623;
        }

        p{
            font-size: 17px;
        }

        
        
        
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Welcome to SammyVerse</h1>

        <h2>Login</h2>
        
            <form action="connect.php" method="post">
                <div>
                    <label for="name" name="name">First Name: 
                    <input type="text" name="firstName" placeholder="Enter Name" required></label>
                </div>
                <div>
                    <label for="surname" name="surname">Last Name: 
                    <input type="text" name="lastName" placeholder="Enter Surname" required></label>
                </div>
                <div class="email">
                    <label for="email" name="email">Email:</label> 
                    <span style="color: red; font-size: 17px;">
                        
                    </span><br>
                    <input type="text" name="email" placeholder="Enter Email" required>
                </div>
                <div class="password">
                    <label for="password" name="password">Password:</label><br>
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>
                <div class="button">
                    <button type="submit" name="Register">Register</button>
                </div>
            </form>

            <p>Already have an account? <a href="index.html">Login</a> or <a href="#">Forget Password</a></p>

            
            
    </div>
</body>
</html>