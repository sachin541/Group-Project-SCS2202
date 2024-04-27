<?php
require_once 'database.php';
class Repair {
    
    private $db; 

    public function __construct($db) {
        $this->db = $db;
    }

    
    public function getCustomerRepairsbyID($customerId) {
        try {
            $query = "SELECT repair_id, item_name FROM repairs WHERE customer_id = ? ORDER BY repair_id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $customerId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); //fetching man rows
        } catch(PDOException $e) {
            throw $e;
        }
    }
    
    public function getTechnicianRepairsbyID($technicianId, $filter = 'all') {
        try {
            $query = "SELECT * FROM repairs WHERE technician_id = ?";

            if ($filter == 'rejected'){
                $query.= " AND rejected IS NOT NULL";
            }
            else if ($filter == 'completed') {
                $query .= " AND item_collected_date IS NOT NULL";
            } elseif ($filter == 'active') {
                $query .= " AND item_collected_date IS NULL AND rejected IS NULL";
            }
    
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $technicianId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }
    

    public function createRepair($customer_id, $contact, $item_name, $repair_description, $customer_name) {
        try {
            
            $query = "INSERT INTO repairs (customer_id, contact, item_name, repair_description, customer_name) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);

           
            $stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $contact, PDO::PARAM_STR);
            $stmt->bindParam(3, $item_name, PDO::PARAM_STR);
            $stmt->bindParam(4, $repair_description, PDO::PARAM_STR);
            $stmt->bindParam(5, $customer_name, PDO::PARAM_STR);
            
            $stmt->execute();

            return true;
        } catch(PDOException $e) {
            
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
    

    public function getAllNewRepairs($orderby = "ASC"){
        try {
           
            $query = "SELECT * FROM repairs WHERE technician_assigned_date IS NULL ORDER BY added_timestamp " . $orderby ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchall(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            throw $e;
        }

    }

    public function assignTechnicianToRepair($repairId, $technicianId) {
        try {
            
            $query = "UPDATE repairs SET technician_id = ?, technician_assigned_date = CURDATE() WHERE repair_id = ?";
            $stmt = $this->db->prepare($query);

            
            $stmt->bindParam(1, $technicianId, PDO::PARAM_INT);
            $stmt->bindParam(2, $repairId, PDO::PARAM_INT);

            $stmt->execute();

            return true;
        } catch(PDOException $e) {
            
            return false;
        }
    }

    public function rejectRepair($repairId, $technicianId, $reason) {
        try {
            $query = "UPDATE repairs 
                      SET rejected = 1, 
                          rejected_reason = ?, 
                          technician_id = ?, 
                          technician_assigned_date = CURDATE() 
                      WHERE repair_id = ?";
            $stmt = $this->db->prepare($query);
            
            // Bind parameters
            $stmt->bindParam(1, $reason, PDO::PARAM_STR);
            $stmt->bindParam(2, $technicianId, PDO::PARAM_INT);
            $stmt->bindParam(3, $repairId, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return true;
        } catch(PDOException $e) {
            // Consider logging the error message to a file or a database
            error_log('Error in rejectRepair: ' . $e->getMessage());
            return false;
        }
    }
    

    public function progress_repair_stage2($repairId) {
        try {
            $query = "UPDATE repairs SET repair_wip_date = CURDATE() WHERE repair_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $repairId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    public function progress_repair_stage3($repairId) {
        try {
            $query = "UPDATE repairs SET repair_completed_date = CURDATE() WHERE repair_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $repairId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    public function progress_repair_stage4($repairId, $amount) {
        try {
            $query = "UPDATE repairs SET item_collected_date = CURDATE() , amount = ? WHERE repair_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $amount, PDO::PARAM_INT);
            $stmt->bindParam(2, $repairId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }



    public function getRepairStatus($repair) {

        if($repair['rejected'] == 1){
            return ['Rejected', 'status-request-rejected'];
        }
        else if ($repair['item_collected_date'] !== null && $repair['item_collected_date'] !== '') {
            return ['Completed', 'status-request-completed'];
        } elseif ($repair['repair_completed_date'] !== null && $repair['repair_completed_date'] !== '') {
            return ['Ready for Collection', 'status-build-ready'];
        } elseif ($repair['repair_wip_date'] !== null && $repair['repair_wip_date'] !== '') {
            return ['In Progress', 'status-build-in-progress'];
        } elseif ($repair['technician_assigned_date'] !== null && $repair['technician_assigned_date'] !== '') {
            return ['Assigned', 'status-technician-assigned'];
        } else {
            return ['Pending', 'status-request-created'];
        }
    }
    
    
   
    


    



}
