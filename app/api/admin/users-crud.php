<?php
session_start();

require_once __DIR__ . '/../../../database/config/config.php';
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../models/admin/UsersModel.php';

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

header('Content-Type: application/json');

$usersModel = new UsersModel($con);
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'getAll':
            $users = $usersModel->getAllUsers();
            echo json_encode(['success' => true, 'data' => $users]);
            break;

        case 'getById':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID required']);
                break;
            }
            $user = $usersModel->getUserById($id);
            if ($user) {
                echo json_encode(['success' => true, 'data' => $user]);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found']);
            }
            break;

        case 'create':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data['name'] || !$data['email'] || !$data['password'] || !$data['role']) {
                echo json_encode(['success' => false, 'message' => 'All fields are required']);
                break;
            }

            $result = $usersModel->createUser($data['name'], $data['email'], $data['password'], $data['role']);
            echo json_encode($result);
            break;

        case 'update':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data['id'] || !$data['name'] || !$data['email'] || !$data['role']) {
                echo json_encode(['success' => false, 'message' => 'All fields are required']);
                break;
            }

            $result = $usersModel->updateUser($data['id'], $data['name'], $data['email'], $data['role']);
            echo json_encode($result);
            break;

        case 'delete':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID required']);
                break;
            }
            $result = $usersModel->deleteUser($id);
            echo json_encode($result);
            break;

        case 'changePassword':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data['id'] || !$data['newPassword']) {
                echo json_encode(['success' => false, 'message' => 'ID and new password required']);
                break;
            }

            $result = $usersModel->updateUserPassword($data['id'], $data['newPassword']);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    error_log("API Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}

?>
