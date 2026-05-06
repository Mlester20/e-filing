<?php
session_start();

require_once __DIR__ . '/../../models/admin/StudentRecordsModel.php';
require_once __DIR__ . '/../../../helpers/message.php';
require_once __DIR__ . '/../../../database/config/config.php';
require_once __DIR__ . '/../Controller.php';

    class StudentRecordsController extends Controller{

        public function __construct($con) {
            parent::__construct(new StudentRecordsModel($con)); // $this->model is set by the parent
        }

        public function index($page = 1, $limit = 10) {
            $students = $this->model->getPaginated($page, $limit);

            return array_map(function ($s) {
                $parts = array_filter([
                    $s['first_name']  ?? '',
                    $s['middle_name'] ?? '',
                    $s['last_name']   ?? '',
                    $s['suffix']      ?? '',
                ]);
                $s['full_name'] = trim(implode(' ', $parts));
                return $s;
            }, $students);
        }

        public function getAllStudents() {
            $students = $this->model->index();

            return array_map(function ($s) {
                $parts = array_filter([
                    $s['first_name']  ?? '',
                    $s['middle_name'] ?? '',
                    $s['last_name']   ?? '',
                    $s['suffix']      ?? '',
                ]);
                $s['full_name'] = trim(implode(' ', $parts));
                return $s;
            }, $students);
        }

        public function getTotalPages($limit = 10) {
            $total = $this->model->getTotalCount();
            return ceil($total / $limit);
        }

        public function view($id) {
            $student = $this->model->getById($id);
            if ($student) {
                $parts = array_filter([
                    $student['first_name']  ?? '',
                    $student['middle_name'] ?? '',
                    $student['last_name']   ?? '',
                    $student['suffix']      ?? '',
                ]);
                $student['full_name'] = trim(implode(' ', $parts));
                return $student;
            }
            return null;
        }

        public function create($data){
            if($this->model->create($data)){
                setFlash('success', 'Graduate student added successfully');
                header('Location: ../../../resources/views/admin/student-records.php');
                exit();
            }else{
                setFlash('error', 'Failed to add graduate student');
                header('Location: ../../../resources/views/admin/student-records.php');
                exit();
            }
        }

        public function update($id, $data){
            if($this->model->update($id, $data)){
                setFlash('success', 'Graduate student updated successfully');
                header('Location: ../../../resources/views/admin/student-records.php');
                exit();
            }else{
                setFlash('error', 'Failed to update graduate student');
                header('Location: ../../../resources/views/admin/student-records.php');
                exit();
            }
        }

        public function delete($id){
            if($this->model->delete($id)){
                setFlash('success', 'Graduate student deleted successfully');
                header('Location: ../../../resources/views/admin/student-records.php');
                exit();
            }else{
                setFlash('error', 'Failed to delete graduate student');
                header('Location: ../../../resources/views/admin/student-records.php');
                exit();
            }
        }
    }

    $controller = new StudentRecordsController($con);
    
    // Pagination
    $limit = 10;
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $students = $controller->index($page, $limit);
    $totalPages = $controller->getTotalPages($limit);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['create_graduate'])) {
            $controller->create([
                'student_no' => $_POST['student_no'],
                'first_name' => $_POST['first_name'],
                'middle_name' => $_POST['middle_name'],
                'last_name' => $_POST['last_name'],
                'suffix' => $_POST['suffix'] ?? 'N/A',
                'sex' => $_POST['sex'],
                'year_section' => $_POST['year_section'],
                'academic_year' => $_POST['academic_year'],
                'graduated_date' => $_POST['graduated_date'] ?? null,
                'diploma_no' => $_POST['diploma_no'],
                'form137_no' => $_POST['form137_no'],
                'remarks' => $_POST['remarks'] ?? null,
            ]);
        }
        elseif(isset($_POST['update_graduate'])) {
            $id = $_POST['student_id'];
            $controller->update($id, [
                'student_no' => $_POST['student_no'],
                'first_name' => $_POST['first_name'],
                'middle_name' => $_POST['middle_name'],
                'last_name' => $_POST['last_name'],
                'suffix' => $_POST['suffix'] ?? 'N/A',
                'sex' => $_POST['sex'],
                'year_section' => $_POST['year_section'],
                'academic_year' => $_POST['academic_year'],
                'graduated_date' => $_POST['graduated_date'] ?? null,
                'diploma_no' => $_POST['diploma_no'],
                'form137_no' => $_POST['form137_no'],
                'remarks' => $_POST['remarks'] ?? null,
            ]);
        }
        elseif(isset($_POST['delete_graduate'])) {
            $controller->delete($_POST['student_id']);
        }
    }

?>