<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone)) {
        $_SESSION['msg'] = "All fields are required!";
        header("Location: form_detail.php");
        exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = "Invalid email format!";
        header("Location: form_detail.php");
        exit();
    }

    // Validate phone
    if (!is_numeric($phone) || strlen($phone) != 10) {
        $_SESSION['msg'] = "Phone must be 10 digits!";
        header("Location: form_detail.php");
        exit();
    }

    // Check duplicate email
    $sql_check = "SELECT * FROM form WHERE email='$email'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
         $_SESSION['msg'] = "Email already exists!";
         header("Location: form_detail.php");
         exit();
    }

    // Insert data
    $sql = "INSERT INTO form (name, email, phone)
            VALUES ('$name', '$email', '$phone')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "Entry added successfully!";
        header("Location: form_detail.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
