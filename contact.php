<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Us - My Library</title>

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
                    <a class="nav-link" href="form_detail.php">Form</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="contact.php" aria-current="page">Contact</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </div>
</nav>

    <!-- Main Content -->
    <main class="container my-5 flex-grow-1">

        <div class="text-center mb-5">
            <h1 class="fw-bold">Contact Us</h1>
            <p class="text-secondary">
                Have a question? Send us a message.
            </p>
        </div>

        <!-- Contact Form -->
        <div class="row justify-content-center">

            <div class="col-12 col-lg-7">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">

                        <form id="contactForm" method="POST" action="contactsave.php">
                            <?php
                            if (isset($_SESSION['msgs'])) {
                                $msg = $_SESSION['msgs'];

                                if ($msg == "Message submitted successfully!") {
                                  echo '<div class="alert alert-success">';
                                } else {
                                  echo '<div class="alert alert-warning">';
                                }

                                echo htmlspecialchars($msg);
                                echo '</div>';
                                unset($_SESSION['msgs']);
                            }
                            ?>
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Full Name
                                </label>

                                <input type="text"
                                  class="form-control"
                                  id="name"
                                  name="name"
                                  data-validate="name"
                                  oninput="this.value = this.value.toUpperCase()"
                                  placeholder="Enter your name">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email Address
                                </label>

                                <input type="text"
                                       class="form-control"
                                       id="email"
                                       name="email"
                                       data-validate="email"
                                       placeholder="Enter your email">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-4">
                                <label for="messageText" class="form-label">
                                    Message
                                </label>

                                <textarea class="form-control"
                                          id="messageText"
                                          name="msg"
                                          rows="4"
                                          data-validate="message"
                                          placeholder="Write your message"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>

                            <button type="submit"
                                    class="btn btn-primary w-100">
                                Send Message
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="text-white text-center mt-auto py-3">
        <p class="mb-0">Developed by Amna Fuad | 2026</p>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>


</body>
</html>
