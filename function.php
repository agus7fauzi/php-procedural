<?php

define('HOST', 'localhost');
define('USER', 'agusfauz_id');
define('PASSWORD', '12345678X0');
define('DB', 'agusfauz_db');

/*
* Connect to Database using mysqli driver
*
* @var \mysqli|false $db
*/
$db = mysqli_connect(HOST, USER, PASSWORD, DB);

if (!$db) {
    die('Connection Failed: ' . mysqli_connect_error());
}

function query($query)
{
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function add($data)
{
    global $db;

    $image = upload();
    if (!$image) {
        return false;
    }

    $title = htmlspecialchars($data["title"]);
    $author = htmlspecialchars($data["author"]);
    $price = htmlspecialchars($data["price"]);

    $query = "INSERT INTO php_procedural__books VALUES
                ('', '$title', '$author', '$price', '$image')
            ";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function delete($id)
{
    global $db;

    $imagePath = __DIR__ . '/img/' . query("SELECT image FROM php_procedural__books WHERE id = $id")[0]['image'];
    mysqli_query($db, "DELETE FROM php_procedural__books WHERE id = $id");
    $result =  mysqli_affected_rows($db);

    if ($result > 0) {
        unlink($imagePath);
    }
    return $result;
}

// Modification function
function change($data)
{
    global $db;

    $id = $data["id"];
    $title = htmlspecialchars($data["title"]);
    $author = htmlspecialchars($data["author"]);
    $price = htmlspecialchars($data["price"]);
    $oldImage = $data["old-image"];

    if ($_FILES["image"]["error"] === 4) {
        $image = $oldImage;
    } else {
        $image = upload();
        unlink(__DIR__ . '/img/' . $oldImage);
    }

    $query = "UPDATE php_procedural__books SET
                title = '$title',
                author = '$author',
                price = '$price',
                image = '$image'
                WHERE id = $id";

    mysqli_query($db, $query);
    echo mysqli_error($db);

    return mysqli_affected_rows($db);
}

function search($keyword)
{
    $query = "SELECT * FROM php_procedural__books
                WHERE
            title LIKE '%$keyword%' OR
            author LIKE '%$keyword%' OR
            price LIKE '%$keyword%'";

    return query($query);
}

// Uploda function
function upload()
{
    $fileName = $_FILES['image']['name'];
    $fileSize = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmpName = $_FILES['image']['tmp_name'];

    if ($error === 4) {
        echo "<script>
                alert('Please select an image first!');
                </script>";
        return false;
    }

    $validImgExtentions = ["jpg", "jpeg", "png", "jfif"];
    $ImgExtention = explode('.', $fileName);
    $ImgExtention = strtolower(end($ImgExtention));

    if (!in_array($ImgExtention, $validImgExtentions)) {
        echo "<script>
        alert('The image you uploaded is invalid!');
        </script>";

        return false;
    }

    if ($fileSize > 1000000) {
        echo "<script>
        alert('Image size is too large!');
        </script>";

        return false;
    }

    $newFileName = uniqid();
    $newFileName .= '.';
    $newFileName .= $ImgExtention;

    move_uploaded_file($tmpName, 'img/' . $newFileName);

    return $newFileName;
}

// Register function
function register($data)
{
    global $db;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($db, $data["password"]);
    $verifyPassword = mysqli_real_escape_string($db, $data["verify-password"]);

    $result = mysqli_query($db, "SELECT username FROM php_procedural__users WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username already registered!');</script>";

        return false;
    }

    if ($password !== $verifyPassword) {
        echo "<script>alert('Password confirmation does not match!');</script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($db, "INSERT INTO php_procedural__users VALUES(null, '$username', '$password')");

    return mysqli_affected_rows($db);
}
