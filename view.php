<?php
session_start();
include 'config.php';

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchTerm = "%$search%";

// Pagination settings
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

// Count total matching entries
$count_sql = "SELECT COUNT(*) AS total FROM form
              WHERE name LIKE ? OR email LIKE ?";

$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("ss", $searchTerm, $searchTerm);
$count_stmt->execute();

$count_result = $count_stmt->get_result();
$total_rows = $count_result->fetch_assoc()['total'];

$total_pages = (int) ceil($total_rows / $limit);

// Prevent page number from exceeding the last page
if ($total_pages > 0 && $page > $total_pages) {
    $page = $total_pages;
}

// Calculate offset
$offset = ($page - 1) * $limit;

// Retrieve entries
$sql = "SELECT * FROM form
        WHERE name LIKE ? OR email LIKE ?
        ORDER BY id DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $offset);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Entries | Library Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        /* clickable sortable headers */
        th.sortable {
            cursor: pointer;
            user-select: none;
            white-space: nowrap;
        }

        /* row highlight on hover (works with Bootstrap striped rows) */
        /* modal buttons: full width on phones, normal size from 576px up */
        @media (min-width: 576px) {
            .w-sm-auto { width: auto !important; }
        }

        tr.row-hover > * {
            --bs-table-bg-state: #dbeafe;
        }
    </style>
</head>

<body class="bg-body-tertiary d-flex flex-column min-vh-100">

    <!-- Navigation Bar -->
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
                   <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </div>
</nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <div class="container mt-5">

            <h2 class="text-center mb-4">Manage Users</h2>

            <?php
            // Success / info message after update or delete
            if (isset($_SESSION['msg'])) {
                $flash = $_SESSION['msg'];
                $flashClass = (strpos($flash, 'successfully') !== false) ? 'alert-success' : 'alert-warning';
                echo '<div class="alert ' . $flashClass . ' alert-dismissible fade show" role="alert">';
                echo htmlspecialchars($flash);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
                unset($_SESSION['msg']);
            }
            ?>

            <!-- Search Form -->
            <form method="GET" action="view.php" class="mb-3">
                <div class="d-flex gap-2">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by Name or Email"
                        value="<?php echo htmlspecialchars($search); ?>"
                    >

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                    <a href="view.php" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>

            <!-- Total Entries -->
            <p class="text-muted">
                Total Entries:
                <strong><?php echo $total_rows; ?></strong>
            </p>

            <!-- Entries Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover bg-white" id="entriesTable">
                    <thead class="table-dark">
                        <tr>
                            <th class="sortable" onclick="sortTable(0)">ID<span class="sort-icon"></span></th>
                            <th class="sortable" onclick="sortTable(1)">Name<span class="sort-icon"></span></th>
                            <th class="sortable" onclick="sortTable(2)">Email<span class="sort-icon"></span></th>
                            <th class="sortable" onclick="sortTable(3)">Phone<span class="sort-icon"></span></th>
                            <th class="sortable" onclick="sortTable(4)">Created At<span class="sort-icon"></span></th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ($result->num_rows > 0): ?>

                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars((string)$row['id']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['name']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['email']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['phone']); ?>
                                    </td>

                                    <td>
                                        <?php
                                        echo isset($row['created_at'])
                                            ? htmlspecialchars($row['created_at'])
                                            : 'N/A';
                                        ?>
                                    </td>
                                    <td class="text-nowrap">
                                      <div class="d-flex gap-1 flex-nowrap">
                                        <a href="update.php?id=<?php echo $row['id']; ?>"
                                         class="btn btn-primary btn-sm">
                                         Update
                                        </a>

                                        <button type="button"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-id="<?php echo (int) $row['id']; ?>"
                                                data-name="<?php echo htmlspecialchars($row['name']); ?>">
                                            Delete
                                        </button>
                                      </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No entries found.
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 0): ?>

                <nav aria-label="Entries pagination">
                    <ul class="pagination justify-content-center">

                        <!-- Previous Button -->
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <?php if ($page > 1): ?>
                                <a class="page-link"
                                   href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">
                                    Previous
                                </a>
                            <?php else: ?>
                                <span class="page-link">Previous</span>
                            <?php endif; ?>
                        </li>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link"
                                   href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Button -->
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <?php if ($page < $total_pages): ?>
                                <a class="page-link"
                                   href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">
                                    Next
                                </a>
                            <?php else: ?>
                                <span class="page-link">Next</span>
                            <?php endif; ?>
                        </li>

                    </ul>
                </nav>

                <p class="text-center text-muted">
                    Page <?php echo $page; ?> of <?php echo $total_pages; ?>
                </p>

            <?php endif; ?>

        </div>
    </main>

    <!-- Footer -->
    <footer class="text-white text-center mt-auto py-3 bg-black">
        <p class="mb-0">Developed by Amna Fuad | 2026</p>
    </footer>

    <!-- Delete confirmation modal (replaces confirm()) -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete
                    <strong id="deleteEntryName">this entry</strong>?
                    This cannot be undone.
                </div>
                <div class="modal-footer flex-column flex-sm-row">
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger w-100 w-sm-auto">Yes, Delete</a>
                    <button type="button" class="btn btn-secondary w-100 w-sm-auto" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>
</html>

<?php
$stmt->close();
$count_stmt->close();
$conn->close();
?>
