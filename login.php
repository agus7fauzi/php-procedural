<?php

// When we use session we must starting first on first line
session_start();

require 'function.php';

// Use Cookie to check User logged or not
if (isset($_COOKIE["id"])  && isset($_COOKIE["key"])) {

    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($db, "SELECT username FROM users WHERE id = $id");

    $row = mysqli_fetch_assoc($result);

    if ($key == hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

// Check User login or not using Session
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

// Handle login form
if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($db, "SELECT * FROM php_procedural__users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            $_SESSION["login"] = true;

            if (isset($_POST['remember'])) {
                setcookie('id', $row['id'], time() + 60);
                setcookie('key', hash("sha256", $row["username"]), time() + 60);
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

$title = 'Login';

require_once 'templates/header.php';
?>

<div class="container mt-1 col-lg">
    <h1 class="justify-center mt-2 mb-2 text-bold">Login to Simple Book Store Management App</h1>

    <div class="mt-3"></div>
    <?php if (isset($error)) : ?>
        <p class="justify-center alert mb-1">Wrong Username / Password!</p>
    <?php endif; ?>

    <form class="justify-center col-sm" method="post">
        <label for="username">Username: </label>
        <input class="form-control" required type="text" name="username" id="username" value="agus7fauzi">
        <br>
        <label for="password">Password: </label>
        <input class="form-control" required type="password" name="password" id="password" value="123">
        <br>
        <input type="checkbox" name="remember" id="remember"><label for="remember">Remember me</label>
        <br><br>
        <div class="row-inline">
            <button class="btn btn-primary" type="submit" name="login">Login</button>
            <a class="btn btn-secondary" href="register.php">Register</a>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php';
