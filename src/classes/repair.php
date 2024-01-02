<?php
require_once 'database.php';
class Repair {
    
    private $db; 

    public function __construct($db) {
        $this->db = $db;
    }

    
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
    
    public function getTechnicianRepairsbyID($technicianId, $filter = 'all') {
        try {
            $query = "SELECT repair_id, item_name, technician_assigned_date, repair_wip_date, repair_completed_date, item_collected_date FROM repairs WHERE technician_id = ?";
            
            if ($filter == 'completed') {
                $query .= " AND item_collected_date IS NOT NULL";
            } elseif ($filter == 'active') {
                $query .= " AND item_collected_date IS NULL";
            }
    
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $technicianId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }
    

    public function createRepair($customer_id, $contact, $item_name, $repair_description) {
        try {
            
            $query = "INSERT INTO repairs (customer_id, contact, item_name, repair_description) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);

           
            $stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $contact, PDO::PARAM_STR);
            $stmt->bindParam(3, $item_name, PDO::PARAM_STR);
            $stmt->bindParam(4, $repair_description, PDO::PARAM_STR);

            
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

    public function progress_repair_stage4($repairId) {
        try {
            $query = "UPDATE repairs SET item_collected_date = CURDATE() WHERE repair_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $repairId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }



    public function getRepairStatus($repair) {
        if ($repair['item_collected_date'] !== null && $repair['item_collected_date'] !== '') {
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
