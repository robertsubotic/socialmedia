<?php
    require_once '../config/config.php';
    class User {
        protected $connection;

        public function __construct() {
            global $connection;
            $this->connection = $connection;
        }

        public function create($username, $email, $password) {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql_query = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
            $statement = $this->connection->prepare($sql_query);

            $statement->bind_param("sss", $username, $email, $hash_password);

            $result = $statement->execute();

            if ($result) {
                return true;
            } else {
                return false;
            }

        }

        public function login($email, $password) {
            $sql_query = "SELECT id, password FROM user WHERE email = ?";
            $statement = $this->connection->prepare($sql_query);
            $statement->bind_param("s", $email);
            $statement->execute();

            $result = $statement->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    $_SESSION['id'] = $user['id'];
                    return true;
                }
            }
            return false;
        }

        public function logout() {
            unset($_SESSION['id']);
            session_destroy();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
        }

        public function getUsername() {
            if (!isset($_SESSION['id'])) {
                return null; 
            }
            
            $userId = $_SESSION['id'];
            $sql_query = "SELECT username FROM user WHERE id = ?";
            $statement = $this->connection->prepare($sql_query);
            $statement->bind_param("i", $userId);
            $statement->execute();
        
            $result = $statement->get_result();
            
            if ($result->num_rows == 1) {
                $user = $result->fetch_object();
                return $user->username;
            }
        
            return null; 
        }

        public function getEmail() {
            if (!isset($_SESSION['id'])) {
                return null; 
            }
            
            $userId = $_SESSION['id'];
            $sql_query = "SELECT email FROM user WHERE id = ?";
            $statement = $this->connection->prepare($sql_query);
            $statement->bind_param("i", $userId);
            $statement->execute();
        
            $result = $statement->get_result();
            
            if ($result->num_rows == 1) {
                $user = $result->fetch_object();
                return $user->email;
            }
        
            return null; 
        }
        
        public function changePassword($password) {
            if (!isset($_SESSION['id'])) {
                return null; 
            }

            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $id = $_SESSION['id'];

            $sql_query = "UPDATE user SET password = ? WHERE id = ?";
            $statement = $this->connection->prepare($sql_query);

            $statement->bind_param("si", $hash_password, $id);

            $result = $statement->execute();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
?>