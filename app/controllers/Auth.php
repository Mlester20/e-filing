<?php
session_start();

require_once __DIR__ . '/../../helpers/message.php';
require_once __DIR__ . '/../models/AuthModel.php';
require_once __DIR__ . '/../../database/config/config.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $authModel = new AuthModel($con);

        $email = $_POST['email'];
        $password = $_POST['password'];

        $row = $authModel->getUserByEmail($email);

        if($row && $authModel->verifyPassword($password, $row['password'])){
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['profile_picture'] = $row['profile_picture'];

            // ✅ REDIRECT
            if($_SESSION['role'] === 'admin'){
                header("Location: ../../resources/views/admin/dashboard.php");
            } 
            else if($_SESSION['role'] === 'registrar'){
                header("Location: ../../resources/views/registrar/home.php");
            } 
            else {
                //throw to login for unknown role
                header("Location: ../../../index.php");
            }
            exit();

        } else {
            setFlash('error', 'Invalid email or password');
            header("Location: ../../../index.php");
            exit();
        }
    }


?>