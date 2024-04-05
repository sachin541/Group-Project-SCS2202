<?php
require_once 'database.php'; 

class UserManager {
    protected $db;

    public function emailExists($email) {
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

    

    public function addEmployee($emp_role, $name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $staff_id, $nic, $profile_picture) {
        // Prepare the SQL statement with placeholders
        $stmt = $this->db->prepare("INSERT INTO employees (emp_role, staff_name, staff_address, mobile_no, alternative_mobile_no, date_of_birth, sal, staff_id, nic, profile_picture) VALUES (:emp_role, :name, :address, :mobile_no, :alternative_mobile_no, :date_of_birth, :sal, :staff_id, :nic, :profile_picture)");
        
        // Bind the parameters to the SQL statement
        $stmt->bindParam(':emp_role', $emp_role);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':mobile_no', $mobile_no);
        $stmt->bindParam(':alternative_mobile_no', $alternative_mobile_no);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':sal', $sal);
        $stmt->bindParam(':staff_id', $staff_id);
        $stmt->bindParam(':nic', $nic);
    
        // Check if profile picture is not null, which means an image was uploaded
        if ($profile_picture !== null) {
            // PDO::PARAM_LOB instructs PDO to send the data as a stream
            $stmt->bindParam(':profile_picture', $profile_picture, PDO::PARAM_LOB);
        } else {
            // Bind NULL if no image was uploaded
            $stmt->bindValue(':profile_picture', null, PDO::PARAM_NULL);
        }
    
        // Execute the statement and return the result
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


    public function updateEmployee($staff_id, $name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $role, $nic, $profile_picture) {
        try {
            // Begin a transaction
            $this->db->beginTransaction();
    
            // Update employee details in the 'employees' table, including the NIC, role, and possibly the profile picture
            $query = "UPDATE employees SET emp_role = :role, staff_name = :name, staff_address = :address, mobile_no = :mobile_no, alternative_mobile_no = :alternative_mobile_no, date_of_birth = :date_of_birth, sal = :sal, nic = :nic";
            
            // If a profile picture is provided, add it to the update query
            if ($profile_picture !== null) {
                $query .= ", profile_picture = :profile_picture";
            }
            
            $query .= " WHERE staff_id = :staff_id";
            
            $stmt1 = $this->db->prepare($query);
    
            // Bind common parameters
            $stmt1->bindParam(':role', $role);
            $stmt1->bindParam(':name', $name);
            $stmt1->bindParam(':address', $address);
            $stmt1->bindParam(':mobile_no', $mobile_no);
            $stmt1->bindParam(':alternative_mobile_no', $alternative_mobile_no);
            $stmt1->bindParam(':date_of_birth', $date_of_birth);
            $stmt1->bindParam(':sal', $sal);
            $stmt1->bindParam(':nic', $nic);
            $stmt1->bindParam(':staff_id', $staff_id);
            
            // Bind the profile picture if it's provided
            if ($profile_picture !== null) {
                $stmt1->bindParam(':profile_picture', $profile_picture, PDO::PARAM_LOB);
            }
    
            $stmt1->execute();

        // Update role in the 'login_details' table
        $stmt2 = $this->db->prepare("UPDATE login_details SET role = :role WHERE id = :staff_id");
        $stmt2->bindParam(':role', $role);
        $stmt2->bindParam(':staff_id', $staff_id);
        
        $stmt2->execute();

        // Commit the transaction
        $this->db->commit();

        return true;
    } catch (Exception $e) {
        // Roll back the transaction in case of an error
        $this->db->rollback();
        // Optionally log the error message: error_log("Update Employee Error: " . $e->getMessage());
        return false; 
    }
}

    
    
    

    public function getStaffById($staff_id) {
        // Prepare a SQL statement to select the staff member by their staff_id
        $stmt = $this->db->prepare("SELECT * FROM employees e  JOIN login_details l  ON e.staff_id = l.id WHERE staff_id = :staff_id");
        
        // Bind the staff_id parameter to the prepared statement
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch the result as an associative array and return it
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getNumberOfStaff() {
        try {
            $query = "SELECT COUNT(*) AS total FROM login_details WHERE role IN ('technician', 'staff', 'deliverer')";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            throw $e; // Handle any exceptions
        }
    }

    public function getNumberOfCustomers() {
        try {
            $query = "SELECT COUNT(*) AS total FROM login_details WHERE role = 'customer'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            throw $e; // Handle any exceptions
        }
    }
    
    

   
    
}
