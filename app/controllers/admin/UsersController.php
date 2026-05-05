<?php
session_start();

require_once __DIR__ . '/../../models/admin/UsersModel.php';
require_once __DIR__ . '/../../../database/config/config.php';
require_once __DIR__ . '/../../../helpers/message.php';
require_once __DIR__ . '/../../controllers/Controller.php'; 

    class UsersController extends Controller{
        private $usersModel;

        public function __construct($con){
            $this->usersModel = new UsersModel($con);
        }

        public function index(){
            return $this->usersModel->index();
        }

        public function create($data){
            if($this->usersModel->create($data)){
                setFlash('success', 'User created successfully');
                header('Location: ../../../resources/views/admin/users.php');
                exit();
            }else{
                setFlash('error', 'Failed to create user');
                header('Location: ../../../resources/views/admin/users.php');
                exit();
            }
        }

        public function update($id, $data){
            if($this->usersModel->update($id, $data)){
                setFlash('success', 'User updated successfully');
                header('Location: ../../../resources/views/admin/users.php');
                exit();
            }else{
                setFlash('error', 'Failed to update user');
                header('Location: ../../../resources/views/admin/users.php');
                exit();
            }
        }

        public function delete($id){
            if($this->usersModel->delete($id)){
                setFlash('success', 'User deleted successfully');
                header('Location: ../../../resources/views/admin/users.php');
                exit();
            }else{
                setFlash('error', 'Failed to delete user');
                header('Location: ../../../resources/views/admin/users.php');
                exit();
            }
        }
    }

    // bootstrap the controller
    $usersController = new UsersController($con);
    $users = $usersController->index();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['create_user'])){
            $usersController->create(
                [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'role' => $_POST['role']
                ]
            );
        }
        if(isset($_POST['update_user'])){
            $usersController->update(
                $_POST['id'],
                [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role']
                ]
            );
        }
        if(isset($_POST['delete_user'])){
            $usersController->delete($_POST['id']);
        }
    }

?>