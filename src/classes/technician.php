<?php
require_once 'database.php';
require_once 'users.php';
// Assuming User class contains necessary properties and methods

class Technician extends User {

    // Function to fetch all technician details
    public function getAllTechnicians() {
        $stmt = $this->db->prepare("SELECT * FROM login_details WHERE emp_role = 'technician'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Function to fetch details of a specific technician by ID
    public function getTechnicianByStaffId($staffId) {
        try {
            // Prepare the SQL statement
            $query = "SELECT * FROM employees WHERE staff_id = ? AND emp_role = 'technician'";
            $stmt = $this->db->prepare($query);

            // Bind the staff ID parameter
            $stmt->bindParam(1, $staffId, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?: [];  // Return the result or an empty array if no result
        } catch(PDOException $e) {
            // Handle exceptions (you can log this or return a custom error message)
            return [];  // Return an empty array on error
        }
    }

    // Other technician-specific methods...
}


?>
