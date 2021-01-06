<?php

// When we use session we must starting first on first line
session_start();

// Check User login or not
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'function.php';

// Handle addition form
if (isset($_POST["submit"])) {
    if (!file_exists(__DIR__ . '/img')) {
        mkdir(__DIR__ . '/img', 0777);
    }
    if (add($_POST) > 0) {
        echo "<script>
            alert('Data added successfully!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data failed to add!');
            document.location.href = 'index.php';
        </script>";
    }
}

$title = 'Add a Book';

require_once 'templates/header.php';
?>

<div class="container mt-1 col-lg">
    <h1 class="justify-center mt-2 mb-2 text-bold">Add a Book</h1>
    <form class="justify-center col-md mt-3" method="post" enctype="multipart/form-data">
        <div class="row-inline">
            <label class="mr-1" for="title">Title: </label>
            <input class="form-control" required type="text" name="title" id="title">
        </div>
        <br>
        <div class="row-inline">
            <label class="mr-1" for="author">Author: </label>
            <input class="form-control" required type="text" name="author" id="author">
        </div>
        <br>
        <div class="row-inline">
            <label class="mr-1" for="price">Price: </label>
            <input class="form-control" required type="text" name="price" id="price">
        </div>
        <br>
            <div class="row-inline">
            <label class="mr-1" for="image">Image: </label>
            <input class="form-control-file" required type="file" name="image" id="image">
        </div>

        <br><br>
        <div class="row-inline">
            <button class="btn btn-primary mb-1" type="submit" name="submit">Save</button>
            <a class="btn btn-secondary" href="index.php">Back</a>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php';
