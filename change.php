<?php

// When we use session we must starting first on first line
session_start();

// Check User login or not
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'function.php';

$id = $_GET["id"];

// Take the book data from the data base
$books = query("SELECT * FROM php_procedural__books WHERE id = $id")[0];

// Handle modification form
if (isset($_POST["submit"])) {
    if (change($_POST) > 0) {
        echo "<script>
            alert('Data changed successfully!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data has failed to change!');
            document.location.href = 'index.php';
        </script>";
    }
}

$title = 'Change a Books Data';

require_once 'templates/header.php';
?>

<div class="container mt-1 col-lg">
    <h1 class="justify-center mt-2 mb-2 text-bold">Change a Books Data</h1>
    <form class="justify-center col-md mt-3" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $books["id"] ?>">
        <input type="hidden" name="old-image" value=<?= $books["image"] ?>>
        <div class="row-inline">
            <label class="mr-1" for="title">Title: </label>
            <input class="form-control" type="text" required name="title" id="title" value="<?= $books["title"] ?>">
        </div>
        <br>
        <div class="row-inline">
            <label class="mr-1" for="author">Author: </label>
            <input class="form-control" type="text" required name="author" id="author" value="<?= $books["author"] ?>">
        </div>
        <br>
        <div class="row-inline">
            <label class="mr-1" for="price">Price: </label>
            <input class="form-control" type="text" required name="price" id="price" value="<?= $books["price"] ?>">
        </div>
        <br>
        <div class="row-inline">
            <label class="mr-1" for="image">Image: </label>
            <img class="mr-1" src="img/<?= $books["image"] ?>" width="50"><br>
            <input class="form-control-file" type="file" name="image" id="image">
        </div>

        <br><br>
        <div class="row-inline">
            <button class="btn btn-primary mb-1" type="submit" name="submit">Save</button>
            <a class="btn btn-secondary" href="index.php">Back</a>
        </div>
    </form>
</div>

<?php require_once 'templates/footer.php';
