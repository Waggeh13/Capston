<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APP</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 35px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .bafrow {
            color: rgb(34, 34, 249);
        }
        .care {
            color: red;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        input {
            margin-bottom: 10px;
        }
    </style>

</head>

<body>
    <div class="logo">
        <span class="bafrow">Bafrow</span><span class="care">Care</span>
    </div>

    <div class="container">
        <div class="form-box login">
            <form action="">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" id="user_id" placeholder="User ID" required>
                    <i class='bx bxs-user'></i>
                    <div id="idError" class="error-message"></div><br>
                </div>
                <div class="input-box">
                    <input type="password" id="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt' ></i>
                    <div id="passwordError" class="error-message"></div><br>
                </div>
                <div class="forgot-link">
                    <a href="#" style="text-decoration: none;">Forget password?</a>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!</h1>
                <p>Connecting Care, Simplifying Lives</p>
            </div>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
</body>
</html>