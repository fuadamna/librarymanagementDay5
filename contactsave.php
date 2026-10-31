<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['msg'];

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['msgs'] = "All fields are required!";
        header("Location: contact.php");
        exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msgs'] = "Invalid email format!";
        header("Location: contact.php");
        exit();
    }
    

    // Check duplicate email
    $sql_check = "SELECT * FROM contact WHERE email='$email'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
         $_SESSION['msgs'] = "Email already exists!";
         header("Location: contact.php");
         exit();
    }

    // Insert data
    $sql = "INSERT INTO contact (name, email, message)
            VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['msgs'] = "Message submitted successfully!";
        header("Location: contact.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
