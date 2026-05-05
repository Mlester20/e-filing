<?php
require_once __DIR__ . '/../BaseModel.php';

    class UsersModel extends BaseModel{
        protected $users = 'users';

        public function index(){
            try{
                $query = "SELECT id, name, email, role, created_at FROM {$this->users} ORDER BY id ASC";
                $stmt = $this->con->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $users = [];
                while($row = $result->fetch_assoc()){
                    $users[] = $row;
                }
                return $users;
            }catch(Exception $e){
                echo "Error fetching users: " . $e->getMessage();
            }
        }

        public function hashPassword($password){
            return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        }

        public function create($data){
            try{
                $query = "INSERT INTO {$this->users} (name, email, password, role) VALUES (?, ?, ?, ?)";
                $stmt = $this->con->prepare($query);
                $hashedPassword = $this->hashPassword($data['password']);
                $stmt->bind_param("ssss", $data['name'], $data['email'], $hashedPassword, $data['role']);
                $stmt->execute();
                return true;
            }catch(Exception $e){
                echo "Error creating user: " . $e->getMessage();
                return false;
            }
        }

        public function update($id, $data){
            try{
                $query = "UPDATE {$this->users} SET name = ?, email = ?, role = ? WHERE id = ?";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param("sssi", $data['name'], $data['email'], $data['role'], $id);
                $stmt->execute();
                return true;
            }catch(Exception $e){
                echo "Error updating user: " . $e->getMessage();
                return false;
            }
        }

        public function delete($id){
            try{
                $query = "DELETE FROM {$this->users} WHERE id = ?";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                return true;
            }catch(Exception $e){
                echo "Error deleting user: " . $e->getMessage();
                return false;
            }
        }
    }

?>