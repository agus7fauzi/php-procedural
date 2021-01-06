<?php

// When we use session we must starting first on first line
session_start();

// Check User login or not
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'function.php';

// Handle delete action and make delete confirmation
if (delete($_GET["id"]) > 0) {
    echo "<script>
    alert('Data deleted successfully!');
    document.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
    alert('Data deleted successfully!');
    document.location.href = 'index.php';
</script>";
}

?>
