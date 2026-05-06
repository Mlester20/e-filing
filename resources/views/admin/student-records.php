<?php

require_once __DIR__ . '/../../../app/controllers/admin/StudentRecordsController.php';
require_once __DIR__ . '/../../../helpers/message.php';
require_once __DIR__ . '/../../../app/middleware/auth.php';
allowOnly(['admin']);  //only admin should allowed to access this page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard | <?php require_once __DIR__ . '/../../../helpers/title.php'; ?> </title>
    <link rel="icon" type="image/x-icon" href="../../../public/assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,400&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../../public/assets/vendor/fonts/iconify-icons.css" />
    <link rel="stylesheet" href="../../../public/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../../public/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../../../public/assets/css/demo.css" />
    <link rel="stylesheet" href="../../../public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../../public/assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="../../../public/css/admin-dashboard.css" />
    <script src="../../../public/assets/vendor/js/helpers.js"></script>
    <script src="../../../public/assets/js/config.js"></script>
</head>
<body>

    <?php showFlash(); ?>

    <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
    <?php require_once __DIR__ . '/partials/topbar.php'; ?>

    <div class="text-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGraduateModal">Add Graduate Student</button>
    </div>

    <!-- Create Graduate Student Modal -->
    <div class="modal fade" id="createGraduateModal" tabindex="-1" aria-labelledby="createGraduateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGraduateModalLabel">Add Graduate Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Student No. -->
                        <div class="col-12">
                            <label for="student_no" class="form-label">Student No.</label>
                            <input type="number" class="form-control" id="student_no" name="student_no" required>
                        </div>

                        <!-- Name Fields -->
                        <div class="col-md-4">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="col-md-4">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>

                        <!-- Suffix & Sex -->
                        <div class="col-md-6">
                            <label for="suffix" class="form-label">Suffix</label>
                            <input type="text" class="form-control" id="suffix" name="suffix" placeholder="Jr., Sr., III...">
                        </div>
                        <div class="col-md-6">
                            <label for="sex" class="form-label">Sex</label>
                            <select class="form-select" id="sex" name="sex" required>
                                <option value="" disabled selected>Select sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <!-- Year Section & Academic Year -->
                        <div class="col-md-6">
                            <label for="year_section" class="form-label">Year & Section</label>
                            <input type="text" class="form-control" id="year_section" name="year_section" required>
                        </div>
                        <div class="col-md-6">
                            <label for="academic_year" class="form-label">Academic Year</label>
                            <input type="text" class="form-control" id="academic_year" name="academic_year" placeholder="e.g. 2024-2025" required>
                        </div>

                        <!-- Graduated Date -->
                        <div class="col-12">
                            <label for="graduated_date" class="form-label">Graduated Date</label>
                            <input type="date" class="form-control" id="graduation_date" name="graduation_date" required>
                        </div>

                        <!-- Diploma No. & Form 137 No. -->
                        <div class="col-md-6">
                            <label for="diploma_no" class="form-label">Diploma No.</label>
                            <input type="text" class="form-control" id="diploma_no" name="diploma_no">
                        </div>
                        <div class="col-md-6">
                            <label for="form137_no" class="form-label">Form 137 No.</label>
                            <input type="text" class="form-control" id="form137_no" name="form137_no">
                        </div>

                        <!-- Remarks -->
                        <div class="col-12">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="create_graduate" class="btn btn-primary">Add Student</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <h5 class="card-header">Manage Graduate Students</h5>
        <div class="table-responsive nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Year Section</th>
                        <th>Academic Year</th>
                        <th>Graduated Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($students as $index => $student): ?>
                        <tr>
                            <td><?= ($page - 1) * $limit + $index + 1 ?></td>
                            <td><?= $student['full_name'] ?></td>
                            <td><?= $student['year_section'] ?></td>
                            <td><?= $student['academic_year'] ?></td>
                            <td><?= date('F j, Y', strtotime($student['graduated_date'])) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" data-student-id="<?= $student['id'] ?>">Edit</button>
                                <button type="button" class="btn btn-sm btn-secondary view-btn" data-student-id="<?= $student['id'] ?>">View</button>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-student-id="<?= $student['id'] ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($totalPages > 1): ?>
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1">First</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php 
                        $start = max(1, $page - 2);
                        $end = min($totalPages, $page + 2);
                        
                        for($i = $start; $i <= $end; $i++): 
                    ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $totalPages ?>">Last</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>

    <!-- Edit Graduate Student Modal -->
    <div class="modal fade" id="editGraduateModal" tabindex="-1" aria-labelledby="editGraduateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGraduateModalLabel">Edit Graduate Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="edit_student_id">
                    <div class="row g-3">

                        <!-- Student No. -->
                        <div class="col-12">
                            <label for="edit_student_no" class="form-label">Student No.</label>
                            <input type="number" class="form-control" id="edit_student_no" name="student_no" required>
                        </div>

                        <!-- Name Fields -->
                        <div class="col-md-4">
                            <label for="edit_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="edit_middle_name" name="middle_name">
                        </div>
                        <div class="col-md-4">
                            <label for="edit_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                        </div>

                        <!-- Suffix & Sex -->
                        <div class="col-md-6">
                            <label for="edit_suffix" class="form-label">Suffix</label>
                            <input type="text" class="form-control" id="edit_suffix" name="suffix" placeholder="Jr., Sr., III...">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_sex" class="form-label">Sex</label>
                            <select class="form-select" id="edit_sex" name="sex" required>
                                <option value="" disabled>Select sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <!-- Year Section & Academic Year -->
                        <div class="col-md-6">
                            <label for="edit_year_section" class="form-label">Year Section</label>
                            <input type="text" class="form-control" id="edit_year_section" name="year_section" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_academic_year" class="form-label">Academic Year</label>
                            <input type="text" class="form-control" id="edit_academic_year" name="academic_year" placeholder="e.g. 2024-2025" required>
                        </div>

                        <!-- Graduated Date -->
                        <div class="col-12">
                            <label for="edit_graduation_date" class="form-label">Graduated Date</label>
                            <input type="date" class="form-control" id="edit_graduation_date" name="graduation_date" required>
                        </div>

                        <!-- Diploma No. & Form 137 No. -->
                        <div class="col-md-6">
                            <label for="edit_diploma_no" class="form-label">Diploma No.</label>
                            <input type="text" class="form-control" id="edit_diploma_no" name="diploma_no">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_form137_no" class="form-label">Form 137 No.</label>
                            <input type="text" class="form-control" id="edit_form137_no" name="form137_no">
                        </div>

                        <!-- Remarks -->
                        <div class="col-12">
                            <label for="edit_remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="edit_remarks" name="remarks" rows="3"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_graduate" class="btn btn-primary">Update Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Graduate Student Modal -->
    <div class="modal fade" id="viewGraduateModal" tabindex="-1" aria-labelledby="viewGraduateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewGraduateModalLabel">Student Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label"><strong>Full Name</strong></label>
                            <p id="view_full_name" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label"><strong>Student No.</strong></label>
                            <p id="view_student_no" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Year Section</strong></label>
                            <p id="view_section" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Academic Year</strong></label>
                            <p id="view_academic_year" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Sex</strong></label>
                            <p id="view_sex" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Graduated Date</strong></label>
                            <p id="view_graduated_date" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Diploma No.</strong></label>
                            <p id="view_diploma_no" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Form 137 No.</strong></label>
                            <p id="view_form137_no" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label"><strong>Remarks</strong></label>
                            <p id="view_remarks" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteGraduateModal" tabindex="-1" aria-labelledby="deleteGraduateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteGraduateModalLabel">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="delete_student_id">
                    <p>Are you sure you want to delete this graduate student? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_graduate" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>    

    <?php require_once __DIR__ . '/partials/footer.php'; ?>
    
    <!-- ── Vendor scripts ── -->
    <script src="../../../public/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../../public/assets/vendor/libs/popper/popper.js"></script>
    <script src="../../../public/assets/vendor/js/bootstrap.js"></script>
    <script src="../../../public/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../../public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../../public/assets/vendor/js/menu.js"></script>
    <script src="../../../public/assets/js/main.js"></script>

    <script id="studentsData" type="application/json">
        <?php 
            $allStudents = $controller->getAllStudents();
            echo json_encode($allStudents);
        ?>
    </script>

    <script src="../../../public/js/admin/students.js"></script>

</body>
</html>