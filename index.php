<?php

// When we use session we must starting first on first line
session_start();

// Check for user session, if the user does not have a login session, it will be redirect to login page
if (!isset($_SESSION["login"])) {

    header("Location: login.php");
    exit;
}

require 'function.php';

// Limit the data displayed and use pagination
$limitDataPage = 5;
$amountData = count(query("SELECT * FROM php_procedural__books"));
$pages = ceil($amountData / $limitDataPage);
$activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;
$initData = ($limitDataPage * $activePage) - $limitDataPage;

// Take the book data from the data base
$books = query("SELECT * FROM php_procedural__books LIMIT $initData, $limitDataPage");

// If user hit search button, call the searching function and display result
if (isset($_GET["search"])) {
    $books = search($_GET["keywords"]);
}

$title = 'Simple Book Store Management App | Core PHP Prosedural';
require_once 'templates/header.php';
?>

<div class="container mt-1">
    <a class="btn btn-secondary mt-1 logout-btn" href="logout.php">Logout</a>
    <h1 class="justify-center mt-2 mb-2 text-bold app-header">Simple Book Store Management App</h1>
    <h2 class="justify-center app-sub-header">by implementation of the Core PHP Procedural</h2>
    <div class="row-inline mt-1">
        <a class="btn btn-primary add-btn" href="add.php">Add</a>
        <br>
        <?php if (count($books) > 0) : ?>
            <form class="row-inline search-form" method="POST">
                <input class="form-control" type="text" name="keywords" autofocus>
                <button class="btn btn-primary" type="submit" name="search">Search</button>
            </form>
        <?php else : ?>
            <form class="row-inline search-form" method="POST" style="pointer-events: none; opacity: 0.5;">
                <input class="form-control" type="text" name="keywords" autofocus disabled>
                <button class="btn btn-primary" type="submit" name="search">Search</button>
            </form>
        <?php endif; ?>
    </div>
    <?php if (count($books) > 0) : ?>
        <table class="table box-shadow" border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No.</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php $index = 1;
            foreach ($books as $book) : ?>
                <tr>
                    <td><?= $index ?></td>
                    <td><?= $book["title"] ?></td>
                    <td><?= $book["author"] ?></td>
                    <td>Rp. <?= $book["price"] ?>, 00</td>
                    <td><img src="img/<?= $book["image"] ?>" width="50"></td>
                    <td><a class="badge badge-warning" href="change.php?id=<?= $book["id"] ?>">Change</a> |
                        <a class="badge badge-danger" href="delete.php?id=<?= $book["id"] ?>" onclick="return confirm('Are You Sure?');">Delete</a></td>
                </tr>
            <?php
                $index = $index + 1;
            endforeach;
            ?>
        </table>
    <?php else : ?>
        <p class="mt-3" style="color: #FFA000; text-align: center; font-size: 1.5rem; font-weight: bold">Books is empty!</p>
    <?php endif; ?>

    <br>
    <br>
    <div class="pagination">
        <?php if ($activePage > 1) {
            echo '<a href="?page=' . ($activePage - 1) . '"> &laquo; </a>';
        }
        if ($pages > 1) {
            for ($i = 1; $i <= $pages; $i++) {
                if ($i == $activePage) {
                    echo '<a href="?page=' . $i . '" style="color: red; font-weight: bold;"> ' . $i . ' </a>';
                } else {
                    echo '<a href="?page=' . $i . '"> ' . $i . ' </a>';
                }
            }
        }

        if ($activePage < $pages) {
            echo '<a href="?page=' . ($activePage + 1) . '"> &raquo; </a>';
        } ?>
    </div>
    <div class="mb-3"></div>
</div>

<?php require_once 'templates/footer.php';
