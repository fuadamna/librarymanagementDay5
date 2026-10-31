<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "SELECT * FROM form WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        die("Entry not found!");
    }
}

if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (empty($name) || empty($email) || empty($phone)) {
        $_SESSION['msg'] = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = "Invalid email format!";
    } elseif (!is_numeric($phone) || strlen($phone) != 10) {
        $_SESSION['msg'] = "Phone Number must be 10 digits!";
    } else {
        $sql = "UPDATE form SET name=?, email=?, phone=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $phone, $id);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Entry updated successfully!";
            header("Location: view.php");
            exit();
        } else {
            echo "Error updating record!";
        }
    }

    header("Location: update.php?id=" . $id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Entry | Library Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-body-tertiary d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="index.html">
            Library Management System
        </a>

        <!-- Hamburger button (mobile) -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="form_detail.php">Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="view.php" aria-current="page">Entries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
        </div>

    </div>
</nav>

    <main class="container mt-5 flex-grow-1">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body">

                <h2 class="text-center mb-4">Edit Entry</h2>
                <?php
                  if (isset($_SESSION['msg'])) {
                  echo '<div class="alert alert-warning">';
                  echo htmlspecialchars($_SESSION['msg']);
                  echo '</div>';

                  unset($_SESSION['msg']);
                  }
                ?>

                <form method="POST" action="update.php?id=<?php echo $id; ?>">
                    
                    <input type="hidden" name="id"
                           value="<?php echo $id; ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name"
                               class="form-control"
                               data-validate="name"
                               oninput="this.value = this.value.toUpperCase()"
                               value="<?php echo htmlspecialchars($row['name']); ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email"
                               class="form-control"
                               data-validate="email"
                               value="<?php echo htmlspecialchars($row['email']); ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone"
                               class="form-control"
                               maxlength="10"
                               data-validate="phone"
                               inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               value="<?php echo htmlspecialchars($row['phone']); ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <button type="submit" name="update"
                            class="btn btn-success">
                        Update
                    </button>

                    <a href="view.php" class="btn btn-secondary">
                        Cancel
                    </a>

                </form>
                
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="text-white text-center mt-auto py-3 bg-dark">
        <p class="mb-0">Developed by Amna Fuad | 2026</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>
</html>


