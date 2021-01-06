<?php

require 'function.php';

if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        echo "<script>alert('You have successfully registered!'); window.location.replace('login.php');</script>";
    } else {
        echo "<script>alert('You failed to register!');</script>";
        echo mysqli_error($db);
    }
}

$title = 'Registration';

require_once 'templates/header.php';
?>

<div class="container mt-1 col-lg">
    <h1 class="justify-center mt-2 mb-2 text-bold">Register to Simple Book Store Management App</h1>
    <form class="justify-center col-sm mt-3" method="post">
        <label for="username">Username: </label>
        <input class="form-control" required type="text" name="username" id="username">
        <br>
        <label for="password">Password: </label>
        <input class="form-control" required type="password" name="password" id="password">
        <br>
        <label for="verify-password">Password Confirmation: </label>
        <input class="form-control" required type="password" name="verify-password" id="verify-password">
        <br><br>
        <div class="row-inline">
            <button class="btn btn-primary" type="submit" name="register">Register</button>
            <a class="btn btn-secondary" href="login.php">Login</a>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php';
