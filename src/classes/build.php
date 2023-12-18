<?php
require_once 'database.php';

class Build {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createBuild($customerID, $customerName, $contactNumber, $additionalNotes, $totalPrice, $cpuId, $gpuId, $motherboardId, $memoryId, $storageId, $powerSupplyId, $caseId) {
        try {
            $this->db->beginTransaction();

            // Insert into components_list table
            $componentQuery = "INSERT INTO components_list (CPU_id, GPU_id, MotherBoard_id, Memory_id, Storage_id, PowerSupply_id, Case_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $componentStmt = $this->db->prepare($componentQuery);

            // Binding parameters for components
            $componentStmt->bindParam(1, $cpuId);
            $componentStmt->bindParam(2, $gpuId);
            $componentStmt->bindParam(3, $motherboardId);
            $componentStmt->bindParam(4, $memoryId);
            $componentStmt->bindParam(5, $storageId);
            $componentStmt->bindParam(6, $powerSupplyId);
            $componentStmt->bindParam(7, $caseId);

            $componentStmt->execute();
            $componentsListId = $this->db->lastInsertId();

            // Insert into Builds table
            $buildQuery = "INSERT INTO Builds (customer_id, customer_name, contact, components_list_id, comments, amount) VALUES (?, ?, ?, ?, ?, ?)";
            $buildStmt = $this->db->prepare($buildQuery);

            // Binding parameters for build
            $buildStmt->bindParam(1, $customerID);
            $buildStmt->bindParam(2, $customerName);
            $buildStmt->bindParam(3, $contactNumber);
            $buildStmt->bindParam(4, $componentsListId);
            $buildStmt->bindParam(5, $additionalNotes);
            $buildStmt->bindParam(6, $totalPrice);

            $buildStmt->execute();

            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            throw $e;  // Rethrowing the exception to handle it outside this method
        }
    }
}

?>