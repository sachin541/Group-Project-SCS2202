<?php
// Assuming you have a class Database that returns a PDO connection
require_once 'database.php';

class User {
    protected $db;

    public function __construct() {
        // Instantiate the database connection
        $this->db = (new Database())->getConnection();
    }

    public function register($email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $defaultRole = 'user'; // Set default role to 'user'

        $stmt = $this->db->prepare("INSERT INTO login_details (email, user_password, role) VALUES (:email, :password, :role)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_password', $hashedPassword);
        $stmt->bindParam(':role', $defaultRole);

        return $stmt->execute();
    }//note make this abstract 

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT id, role ,user_password FROM login_details WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['user_password'])) {
            return ['id' => $user['id'], 'role' => $user['role']]; // Return user ID for session creation
        }

        return false;
    }

    public function getRole($userId) {
        $stmt = $this->db->prepare("SELECT role FROM  WHERE id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['role'] : null;
    }

   

    // Other user-related methods...
}

// Usage
// $user = new User();
// $user->register('email@example.com', 'password123');
// $userId = $user->login('email@example.com', 'password123');
// $role = $user->getRole($userId);
?>
