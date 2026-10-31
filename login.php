<?php
session_start();
include 'config.php';

$msg = "";

if (isset($_POST['login'])) {

    $email    = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user   = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == "admin") {
            header("Location: view.php");
        } else {
            header("Location: index.html");
        }
        exit;

    } else {
        $msg = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-dark d-flex flex-column min-vh-100">

    <!-- Background image (same as home page) -->
    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1400&q=80"
         alt=""
         class="position-fixed top-0 start-0 w-100 h-100 object-fit-cover z-n1">

    <!-- Dark overlay -->
    <div class="position-fixed top-0 start-0 w-100 h-100 bg-dark opacity-50 z-n1"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.html">
            Library Management System
        </a>
    </div>
</nav>

    <!-- Login form -->
    <main class="container d-flex align-items-center justify-content-center flex-grow-1 py-5">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">

            <!-- Transparent card (dark glass) with white text -->
            <div class="card bg-dark bg-opacity-50 text-white border border-2 border-light shadow-lg rounded-4"
                 data-bs-theme="dark">
                <div class="card-body p-4">

                    <h3 class="text-center fw-bold mb-4">Login</h3>

                    <?php if (isset($_GET['msg'])) { ?>
                        <div class="alert alert-success">You have been logged out.</div>
                    <?php } ?>

                    <?php if ($msg != "") { ?>
                        <div class="alert alert-danger"><?php echo $msg; ?></div>
                    <?php } ?>

                    <form method="POST" autocomplete="off">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email"
                                   class="form-control form-control-lg bg-dark bg-opacity-50 text-white border-light"
                                   autocomplete="off" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password"
                                   class="form-control form-control-lg bg-dark bg-opacity-50 text-white border-light"
                                   autocomplete="new-password" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="login" class="btn btn-light btn-lg">Login</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center mt-auto py-3">
        <p class="mb-0">Developed by Amna Fuad | 2026</p>
    </footer>

    <!-- Bootstrap JavaScript (needed for the mobile menu) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>