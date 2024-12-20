<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="logo.png" rel="icon" type="image/png">
    <link rel="stylesheet" href="Admin_login_style.css">
    <title>Admin Login</title>
    <style>
        body.login-page {
            background: url('front_image.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .button {
            width: 100%;
            font-size: 16px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .img-fluid {
            max-height: 80px;
        }
        .admin-logo {
            max-width: 100px;
            margin: 20px auto;
        }
    </style>
</head>
<body class="login-page">
    <div class="login-container">
        <img src="logo.png" alt="Logo" class="img-fluid mb-2">
        <h1>Admin Login</h1>
        <img src="admin.png" alt="Admin Logo" class="admin-logo">
        <form id="loginForm" method="POST">
            <input type="text" name="id" class="form-control" placeholder="User ID" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn btn-primary button">Sign in</button>
        </form>
    </div>

    <script>
        // Simplified login validation
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission

            const id = document.querySelector('input[name="id"]').value;
            const password = document.querySelector('input[name="password"]').value;

            // Check if the credentials are correct
            if (id === '1234' && password === 'admin') {
                window.location.href = 'admin.php'; // Redirect to admin page
            } else {
                alert('Invalid ID or Password. Please try again.'); // Show error message
            }
        });
    </script>
</body>
</html>
