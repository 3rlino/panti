<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['error']) && $_GET['error'] === 'login_failed') {
    echo "<script>alert('Username atau password salah. Silakan coba lagi.');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASDP</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="img/asdp.png" type="image/x-icon">

    <style>
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 400px;
            text-align: center;
            justify-content: center;
            align-items: center;
        }

        .card h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .form-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }
        .home {
        display: flex;
        justify-content: center;
        align-items: center;
        }
    </style>
</head>
<body>
    <section id="home" class="home">
        <div class="container" style="align-items:center;text-align:center;">
        <div class="row"><br>
        <div class="col-md-6"><br>
            <h1>Login Admin</h1>&nbsp;
            <form method="POST" action="proses_login.php">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-input" autofocus required>
                
                <label for="password" class="form-label">Password:</label>
                <input type="text" id="password" name="password" class="form-input" required>
            
                <input type="submit" value="Login" class="form-button">
            </form>
        </div>
        &nbsp;
       </div>
    </div>
       
    </section>

    <footer>
        <p><a href="index.php" style="color: #bdbdbd;">Copyright &copy;</a> 2023 by Xgaming || All Right Reserved.</p>
    </footer>


    <script src="mixitup.min.js"></script>
    <script src="script.js"></script>
    <script src="scrypt.js"></script>
</body>
</html>
