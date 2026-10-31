<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Form - Library Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f5f6f8;
        }

        .navbar,
        footer {
            background-color: #1f2937;
        }

        .form-card {
            max-width: 600px;
            border: none;
            border-radius: 12px;
        }

        .btn-primary {
            background-color: #1f2937;
            border-color: #1f2937;
        }

        .btn-primary:hover {
            background-color: #374151;
            border-color: #374151;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
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
                    <a class="nav-link active" href="form_detail.php" aria-current="page">Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view.php">Entries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </div>
</nav>

    <!-- Main Form -->
    <main class="container my-5 flex-grow-1">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Your Details</h1>
            <p class="text-secondary">
                A simple way to share your information.
            </p>
        </div>

        <div class="card form-card shadow-sm mx-auto">
            <div class="card-body p-4 p-md-5">

                <form method="POST" action="form.php" onsubmit="return validateForm()">
                    <?php
                    if (isset($_SESSION['msg'])) {
                      $msg = $_SESSION['msg'];

                      if ($msg == "Entry added successfully!") {
                        echo '<div class="alert alert-success">';
                      } else {
                        echo '<div class="alert alert-warning">';
                      }
                      echo htmlspecialchars($msg);
                      echo '</div>';
                      unset($_SESSION['msg']);
                    }
                    ?>
                    
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Name
                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control"
                               data-validate="name"
                               oninput="this.value = this.value.toUpperCase()"
                               placeholder="Enter your name">
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email
                        </label>

                        <input type="text"
                               id="email"
                               name="email"
                               class="form-control"
                               data-validate="email"
                               placeholder="Enter your email">
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="form-label">
                            Phone
                        </label>

                        <input type="text"
                               id="phone"
                               name="phone"
                               class="form-control"
                               data-validate="phone"
                               inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               placeholder="Enter 10-digit phone number"
                               maxlength="10">
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex flex-wrap gap-2">

                        <button type="submit"
                                class="btn btn-primary ">
                            Submit
                        </button>

                        <button type="reset"
                                class="btn btn-primary ">
                            Clear Form
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-white text-center mt-auto py-3">
        <p class="mb-0">Developed by Amna Fuad | 2026</p>
    </footer>

    <!-- JavaScript Validation -->
    <script>
        function validateForm() {

            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let phone = document.getElementById("phone").value.trim();

            // Check empty fields
            if (name === "" || email === "" || phone === "") {
                alert("All fields required");
                return false;
            }

            // Check email
            if (!email.includes("@") || !email.includes(".")) {
                alert("Invalid email");
                return false;
            }

            // Check phone: exactly 10 numeric digits
            if (phone.length !==10 || isNaN(phone)) {
                alert("Phone must be 10 digits.");
                return false;
            }      
            // Prevent page reload
            return true;
        }

        
    </script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>
</html>
