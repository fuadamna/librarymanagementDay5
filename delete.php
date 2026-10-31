<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "DELETE FROM form WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "Entry deleted successfully!";
        header("Location: view.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
