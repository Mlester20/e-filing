<nav class="navbar navbar-expand-lg navbar-dark navbar-sticky">
    <div class="container-fluid">
        <!-- Brand/Logo -->
        <a class="navbar-brand d-flex align-items-center" href="home.php">
            <span class="navbar-brand-icon">
                <i class="bi bi-file-earmark-text"></i>
            </span>
            <span class="navbar-brand-text">E-Filing System</span>
        </a>

        <!-- Navbar Toggler for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">
                        <i class="bi bi-house-door"></i>Dashboard
                    </a>
                </li>

                <!-- Files Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="filesDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-folder"></i>Files
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="filesDropdown">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-plus-circle"></i>Upload File</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-list"></i>My Files</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-archive"></i>Archived Files</a></li>
                    </ul>
                </li>

                <!-- Requests Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="requestsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-envelope"></i>Requests
                        <span class="badge bg-danger ms-1">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="requestsDropdown">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-hourglass-split"></i>Pending</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-check-circle"></i>Approved</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-x-circle"></i>Rejected</a></li>
                    </ul>
                </li>

                <!-- Reports -->
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-bar-chart"></i>Reports
                    </a>
                </li>

                <!-- Divider (visual separator before user controls) -->
                <li class="nav-item d-none d-lg-block" aria-hidden="true">
                    <span style="display:block; width:1px; height:22px; background:var(--nav-border); margin: 0 0.5rem;"></span>
                </li>

                <!-- Notifications -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="#" data-bs-toggle="tooltip" title="Notifications">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">5</span>
                    </a>
                </li>

                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-profile-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                        $profile_pic = !empty($_SESSION['profile_picture'])
                            ? htmlspecialchars($_SESSION['profile_picture'])
                            : '../../../public/assets/img/avatars/1.png';
                        ?>
                        <img
                            src="<?php echo $profile_pic; ?>"
                            alt="Profile Picture"
                        />
                        <span class="d-none d-md-inline"><?php echo $_SESSION['name'] ?? 'User'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="userDropdown">
                        <li class="dropdown-header">Account</li>
                        <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="../../../app/controllers/logout.php" onclick="return confirm('Are you sure you to logout?')">
                            <i class="bi bi-box-arrow-right"></i>Logout
                        </a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>