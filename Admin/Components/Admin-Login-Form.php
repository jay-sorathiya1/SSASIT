<?php

define('Username', 'admin');
define('Password', password_hash('Admin@123', PASSWORD_DEFAULT));

$error = "";
$success = "";

// Handle logout success message
if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    $success = "You have been successfully logged out.";
}


if (isset($_POST['username']) && isset($_POST['password'])) {

    $Username = $_POST['username'];
    $Password = $_POST['password'];

    if ($Username === Username && password_verify($Password, Password)) {

        session_start();

        $_SESSION['User_Logged-In'] = true;
        $_SESSION['admin_username'] = $Username;
        $_SESSION['LAST_ACTIVITY'] = time();

        header('Location: Dashboard');

        exit();
    } else {
        $error = "Invalid Username or Password";
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSASIT-Authentication</title>
    <link rel="stylesheet" href="Css/Login.css?v=<?php echo time(); ?>">
    <?php require 'config/Icon-Config.php'; ?>
</head>

<body>
    <div class="auth">
        <div class="login-image">

        </div>
        <div class="login-card">
            <div class="login-icon">
                <img src="Public/Icon/user.png" alt="user">
                <h1>admin login</h1>
            </div>
            <form action="" class="login-form" method="post">
                <?php if ($error) { ?>
                    <p class="error-msg"><?php echo $error; ?></p>
                <?php } ?>
                <?php if ($success) { ?>
                    <p class="success-msg"><?php echo $success; ?></p>
                <?php } ?>
                <div class="input-group">
                    <i class="fa-solid fa-circle-xmark cross"></i>
                    <label class='login-labels' for="username">Username</label>
                    <input class='login-fields' type="text" name="username" id="username"
                        placeholder="Enter your username" required minlength="3" maxlength="15">
                </div>

                <div class="input-group">
                    <img src="Public/Icon/seen.png" class="eye" alt="">
                    <!-- <i class="fa-jelly-fill fa-regular fa-eye"></i> -->
                    <i class="fa-solid fa-eye-slash"></i>
                    <label class='login-labels' for="password">Password</label>
                    <input class='login-fields' type="password" name="password" id="password"
                        placeholder="Enter your Password" required
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_])[A-Za-z0-9_@]{8,15}"
                        title="Password must be 8 to 15 characters long and contain at least One Upper case and One Lower case letter and at least One Number and _ @">
                </div>
                <a class='forgot-password' href="#">Forgot Password?</a>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>

<script>
    const username = document.querySelector('#username');
    const password = document.querySelector('#password');
    const cross = document.querySelector('.fa-circle-xmark');
    const eye = document.querySelector('.eye');
    const eyeSlash = document.querySelector('.fa-eye-slash');
    const loginForm = document.querySelector('.login-form');


    username.addEventListener('input', () => {
        cross.style.transform = 'scale(0)';

        if (username.value) {
            cross.style.transform = 'scale(1)';
            cross.addEventListener('click', () => {
                username.value = '';
                cross.style.transform = 'scale(0)';
            });
        } else {
            cross.style.transform = 'scale(0)';
        }
    });

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        loginForm.submit();
    });

    eye.addEventListener('click', () => {
        password.type = 'text';
        eye.style.transform = 'scale(0)';
        eyeSlash.style.transform = 'scale(1)';
    });
    eyeSlash.addEventListener('click', () => {
        password.type = 'password';
        eye.style.transform = 'scale(1)';
        eyeSlash.style.transform = 'scale(0)';
    });



    const successMessage = document.querySelector('.success-msg,.error-msg');
    if (successMessage) {
        setTimeout(() => {
            successMessage.remove();
            remove_Url_Parameter('logout');
        }, 3000);
    }

    function remove_Url_Parameter(parameter) {
        // Create a URL object from the current URL
        const url = new URL(window.location.href);

        // Use the searchParams API to delete the specified parameter
        url.searchParams.delete(parameter);

        // Update the URL in the browser without reloading the page
        window.history.replaceState({}, '', url.toString());
    }

</script>

</html>