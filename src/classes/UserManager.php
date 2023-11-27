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

    // public function addStaff($name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $staff_id) {
    //     return $this->addEmployee('staff', $name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $staff_id);
    // }

    // public function addDeliverer($name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $staff_id) {
    //     return $this->addEmployee('deliverer', $name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $staff_id);
    // }

    // public function addTechnician($name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $staff_id) {
    //     return $this->addEmployee('technician', $name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $staff_id);
    // }

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
}
