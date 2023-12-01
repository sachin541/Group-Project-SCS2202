<?php
require_once 'database.php';
// Assuming User class contains necessary properties and methods

class Technician extends User {

    // Function to fetch all technician details
    public function getAllTechnicians() {
        $stmt = $this->db->prepare("SELECT * FROM login_details WHERE emp_role = 'technician'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Function to fetch details of a specific technician by ID
    public function getTechnicianById($id) {
        $stmt = $this->db->prepare("SELECT * FROM login_details WHERE id = :id AND emp_role = 'technician'");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Other technician-specific methods...
}


?>
