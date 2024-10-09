<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        *{
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            color: white;
        }

        .login-google {
            background-color: #db4437;
        }

        .login-google:hover {
            background-color: #c1351e;
        }

        .login-facebook {
            background-color: #4267B2;
        }

        .login-facebook:hover {
            background-color: #3b5998;
        }

        .login-apple {
            background-color: #333;
        }

        .login-apple:hover {
            background-color: #000;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login to Your Account</h2>
        <a href="login.php?provider=Google" class="login-button login-google">Login with Google</a>
        <a href="login.php?provider=Facebook" class="login-button login-facebook">Login with Facebook</a>
        <!-- <a href="login.php?provider=Apple" class="login-button login-apple">Login with Apple</a> -->
    </div>
</body>
</html>
