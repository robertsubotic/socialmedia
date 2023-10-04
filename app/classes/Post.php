<?php
    require_once 'User.php';
    require_once '../config/config.php';

    class Post {
        protected $connection;

        public function __construct() {
            global $connection;
            $this->connection = $connection;
        }

        public function create($description) {
            $sql_query = "INSERT INTO post (username, description, likes) VALUES (?, ?, ?)";
            $statement = $this->connection->prepare($sql_query);

            $user = new User();
            $username = $user->getUsername();
            $start_likes = 0;

            $statement->bind_param("ssi", $username, $description, $start_likes);

            $result = $statement->execute();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        public function getPosts() {
            $posts = array();

            $sql_query = "SELECT * FROM post"; 
            $result = $this->connection->query($sql_query);

            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }

            return $posts;
        }

        public function likePost() {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents("php://input"), true);
        
            $postId = $data['postId'];
            $isLiked = $data['isLiked'];
            $userId = $_SESSION['id']; 
        
            $response = [
                'success' => false,
                'newStatus' => !$isLiked  
            ];
        
            if ($isLiked) {
                $statement = $this->connection->prepare("DELETE FROM post_likes WHERE post_id = ? AND user_id = ?");
                $statement->bind_param("ii", $postId, $userId);
                if ($statement->execute() && $statement->affected_rows > 0) {
                    $stmtUpdate = $this->connection->prepare("UPDATE post SET likes = likes - 1 WHERE id = ?");
                    $stmtUpdate->bind_param("i", $postId);
                    $stmtUpdate->execute();
        
                    $response['success'] = true;
                    $response['newStatus'] = false;
                }
            } else {
                $statement = $this->connection->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
                $statement->bind_param("ii", $postId, $userId);
                if ($statement->execute()) {
                    $stmtUpdate = $this->connection->prepare("UPDATE post SET likes = likes + 1 WHERE id = ?");
                    $stmtUpdate->bind_param("i", $postId);
                    $stmtUpdate->execute();
        
                    $response['success'] = true;
                    $response['newStatus'] = true;
                }
            }
        
            return $response;
        }

        public function checkIfPostIsLikedByUser($postId, $userId, $connection) {
            $query = "SELECT id FROM post_likes WHERE post_id = ? AND user_id = ?";
            $statement = $connection->prepare($query);
            $statement->bind_param('ii', $postId, $userId);
            $statement->execute();
            $result = $statement->get_result();
        
            return $result->num_rows > 0;
        }
    }
?>