<?php
session_start();

require_once __DIR__ . '/../../../app/middleware/auth.php';
allowOnly(['registrar']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Home | <?php require_once __DIR__ . '/../../../helpers/title.php'; ?> </title>
    <link rel="stylesheet" href="../../../public/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../public/css/registrar/app.css">
</head>
<body>
    <!-- Navbar -->
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <!-- Main Content -->
    <div class="container-fluid py-5 text-center">
        <div class="row">
            <div class="col-12">
                <h1 class="text-blue-200">Welcome to E-Filing System</h1>
                <p class="text-muted">You are logged in as a Registrar</p>
            </div>
        </div>
    </div>

    <!-- Tooltip Initialization -->
    <script src="../../../public/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>
</html>