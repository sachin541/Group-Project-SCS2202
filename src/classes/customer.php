<?php
require_once 'database.php';
require_once 'users.php';

class Customer extends User {

    private function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM login_details WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // If a record is found, return true
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function register_customer($email, $password) {

        if ($this->emailExists($email)) {
            return false; // Email exists, registration should not continue
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $customerRole = 'customer'; // Set role to 'customer'

        $stmt = $this->db->prepare("INSERT INTO login_details (email, user_password, role) VALUES (:email, :user_password, :role)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_password', $hashedPassword);
        $stmt->bindParam(':role', $customerRole);

        return $stmt->execute();
    }


    public function new_password($email, $password) {

        

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        

        $stmt = $this->db->prepare("UPDATE login_details SET user_password=? where email=?");
        $stmt->execute([$hashedPassword,$email]); 
        

        return $stmt->execute();
    }

    
    public function new_email($email, $id) {

    
        $stmt = $this->db->prepare("UPDATE login_details SET email=? where id=?");
        $stmt->execute([$email,$id]); 
        

        return $stmt->execute();
    }
   
}

// Usage
// $customer = new Customer();
// $customer->register_customer('customer@example.com', 'customer123');
?>

