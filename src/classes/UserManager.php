<?php
require_once 'database.php'; 

class UserManager {
    protected $db;

    private function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM login_details WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // If a record is found, return true
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function addUser($email, $password, $role) {


        if ($this->emailExists($email)) {
            return false; // Email exists, registration should not continue
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO login_details (email, user_password, role) VALUES (:email, :password, :role)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    

    public function addEmployee($emp_role , $name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $staff_id) {
        $stmt = $this->db->prepare("INSERT INTO employees (emp_role, staff_name, staff_address, mobile_no, alternative_mobile_no, date_of_birth, sal, staff_id) VALUES (:emp_role , :name, :address, :mobile_no, :alternative_mobile_no, :date_of_birth, :sal, :staff_id)");
        $stmt->bindParam(':emp_role', $emp_role);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':mobile_no', $mobile_no);
        $stmt->bindParam(':alternative_mobile_no', $alternative_mobile_no);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':sal', $sal);
        $stmt->bindParam(':staff_id', $staff_id);

        return $stmt->execute();
    }


    public function getDistinctRoles() {
        $stmt = $this->db->prepare("SELECT DISTINCT emp_role FROM employees");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getAllEmployees($role = null) {
        $query = "SELECT * FROM employees";
        if ($role) {
            $query .= " WHERE emp_role = :role";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':role', $role);
        } else {
            $stmt = $this->db->prepare($query);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // public function deleteEmployee($id) {
    //     $stmt = $this->db->prepare("DELETE FROM employees WHERE id = :id");
    //     $stmt->bindParam(':id', $id);
    //     return $stmt->execute();
    // }

    public function deleteEmployee($id) {
        // Start a transaction
        $this->db->beginTransaction();

        try {
            // Delete from the employees table
            $stmt1 = $this->db->prepare("DELETE FROM employees WHERE staff_id = :id");
            $stmt1->bindParam(':id', $id);
            $stmt1->execute();

            // Delete from the login_details table
            $stmt2 = $this->db->prepare("DELETE FROM login_details WHERE id = :id");
            $stmt2->bindParam(':id', $id);
            $stmt2->execute();

            // Commit the transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            $this->db->rollback();
            return false;
        }
    }
}
