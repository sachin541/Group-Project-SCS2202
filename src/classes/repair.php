<?php
require_once 'database.php';
class Repair {
    
    private $db; 

    public function __construct($db) {
        $this->db = $db;
    }

    // Method to fetch repair requests for a specific customer
    public function getCustomerRepairsbyID($customerId) {
        try {
            $query = "SELECT repair_id, item_name FROM repairs WHERE customer_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $customerId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); //fetching man rows
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function getTechnicianRepairsbyID($technicianId) {
        try {
            $query = "SELECT repair_id, item_name FROM repairs WHERE technician_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $technicianId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); //fetching man rows
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function createRepair($customer_id, $contact, $item_name, $repair_description) {
        try {
            // Prepare the SQL statement
            $query = "INSERT INTO repairs (customer_id, contact, item_name, repair_description) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);

            // Bind parameters
            $stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $contact, PDO::PARAM_STR);
            $stmt->bindParam(3, $item_name, PDO::PARAM_STR);
            $stmt->bindParam(4, $repair_description, PDO::PARAM_STR);

            // Execute the statement
            $stmt->execute();

            return true;
        } catch(PDOException $e) {
            // Handle the exception (you can log this or return a custom error message)
            return false;
        }
    }



    public function getAllFromRepairById($repairId) {
        try {
           
            $query = "SELECT * FROM repairs WHERE repair_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $repairId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            throw $e;
        }
    }
    

    public function getAllNewRepairs(){
        try {
           
            $query = "SELECT * FROM repairs WHERE technician_assigned_date IS NULL";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchall(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            throw $e;
        }

    }



}
