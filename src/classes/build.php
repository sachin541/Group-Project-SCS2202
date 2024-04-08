<?php
require_once 'database.php';

class Build {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //for customer
    public function createBuild($customerID, $customerName, $contactNumber, $additionalNotes, $totalPrice, $cpuId, $gpuId, $motherboardId, $memoryId, $storageId, $powerSupplyId, $caseId, $cpuCoolersId, $monitorId, $mouseId, $keyboardId) {
        try {
            $this->db->beginTransaction();
    
            // Updated query to include new components
            $componentQuery = "INSERT INTO components_list 
            (CPU_id, GPU_id, MotherBoard_id, Memory_id, Storage_id, PowerSupply_id, Case_id, CPU_Coolers_id, Monitor_id, Mouse_id, Keyboard_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
            $componentStmt = $this->db->prepare($componentQuery);
    
            // Bind the new parameters
            $componentStmt->bindParam(1, $cpuId);
            $componentStmt->bindParam(2, $gpuId);
            $componentStmt->bindParam(3, $motherboardId);
            $componentStmt->bindParam(4, $memoryId);
            $componentStmt->bindParam(5, $storageId);
            $componentStmt->bindParam(6, $powerSupplyId);
            $componentStmt->bindParam(7, $caseId);
            $componentStmt->bindParam(8, $cpuCoolersId);
            $componentStmt->bindParam(9, $monitorId);
            $componentStmt->bindParam(10, $mouseId);
            $componentStmt->bindParam(11, $keyboardId);
    
            $componentStmt->execute();
            $componentsListId = $this->db->lastInsertId();
    
            // The rest of the build creation logic remains unchanged
            $buildQuery = "INSERT INTO Builds 
            (customer_id, customer_name, contact, components_list_id, comments, amount) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
            $buildStmt = $this->db->prepare($buildQuery);
    
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
            throw $e;
        }
    }
    

    public function getBuildsByCustomerId($customerId) {
        $query = "SELECT b.*, c.* FROM Builds b
                  INNER JOIN components_list c ON b.components_list_id = c.id
                  WHERE b.customer_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $customerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getStatus($buildId) {
        $query = "SELECT technician_assigned_date, build_start_date,
         build_completed_date, build_collected_date 
         FROM Builds WHERE build_id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $buildId);
        $stmt->execute();
        $build = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$build) {
            return 'Build Not Found';
        }

        if (is_null($build['technician_assigned_date'])) {
            return 'Request Created';
        } elseif (is_null($build['build_start_date'])) {
            return 'Technician Assigned';
        } elseif (is_null($build['build_completed_date'])) {
            return 'Build in Progress';
        } elseif (is_null($build['build_collected_date'])) {
            return 'Build Ready for Collection';
        } else {
            return 'Request Completed';
        }
    }

    public function getStatusClass($buildId) {
        $status = $this->getStatus($buildId);
        switch ($status) {
            case 'Request Created':
                return 'status-request-created';
            case 'Technician Assigned':
                return 'status-technician-assigned';
            case 'Build in Progress':
                return 'status-build-in-progress';
            case 'Build Ready for Collection':
                return 'status-build-ready';
            case 'Request Completed':
                return 'status-request-completed';
            default:
                return '';
        }
    }


    public function getAllFromBuildById($buildId) {
        try {
            $query = "SELECT * FROM Builds WHERE build_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $buildId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                return null; 
            }
        } catch(PDOException $e) {
            throw $e;
        }
    }

    //for tech
    public function getTechnicianBuildsbyID($technicianId, $filter = 'all') {
        // changed to * from build_id, customer_name, build_start_date, build_completed_date, build_collected_date
        try {
            $query = "SELECT * FROM Builds WHERE technician_id = :technicianId";
            
            if ($filter == 'completed') {
                $query .= " AND build_collected_date IS NOT NULL";
            } elseif ($filter == 'active') {
                $query .= " AND build_collected_date IS NULL";
            }

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':technicianId', $technicianId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }


    

    public function getAllNewBuilds(){
            try {
               
                $query = "SELECT b.*, c.* FROM Builds b
                  INNER JOIN components_list c ON b.components_list_id = c.id
                  WHERE technician_assigned_date IS NULL";

                $stmt = $this->db->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                throw $e;
            }
    }


    public function getBuildStatus($build) {
        if ($build['build_collected_date'] !== null && $build['build_collected_date'] !== '') {
            return ['Collected', 'status-request-completed'];
        } elseif ($build['build_completed_date'] !== null && $build['build_completed_date'] !== '') {
            return ['Completed', 'status-build-ready'];
        } elseif ($build['build_start_date'] !== null && $build['build_start_date'] !== '') {
            return ['In Progress', 'status-build-in-progress'];
        } elseif ($build['technician_assigned_date'] !== null && $build['technician_assigned_date'] !== '') {
            return ['Assigned', 'status-technician-assigned'];
        } else {
            return ['Pending', 'status-request-created'];
        }
    }


    public function assignTechnicianToBuild($buildId, $technicianId) {
        try {
            $query = "UPDATE builds SET technician_id = ?, technician_assigned_date = CURDATE() WHERE build_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $technicianId, PDO::PARAM_INT);
            $stmt->bindParam(2, $buildId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }


    public function rejectBuild($buildId, $technicianId, $reason) {
        try {
            $query = "UPDATE builds 
                      SET rejected = 1, 
                          rejected_reason = ?, 
                          technician_id = ?, 
                          technician_assigned_date = CURDATE() 
                      WHERE build_id = ?";
            $stmt = $this->db->prepare($query);
            
            // Bind parameters
            $stmt->bindParam(1, $reason, PDO::PARAM_STR);
            $stmt->bindParam(2, $technicianId, PDO::PARAM_INT);
            $stmt->bindParam(3, $buildId, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return true;
        } catch(PDOException $e) {
            echo $e ;
            return false;
        }
    }
    
    
    

    // Function to mark build as started
    public function startBuild($buildId) {
        try {
            $query = "UPDATE builds SET build_start_date = CURDATE() WHERE build_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $buildId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    // Function to mark build as completed
    public function completeBuild($buildId) {
        try {
            $query = "UPDATE builds SET build_completed_date = CURDATE() WHERE build_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $buildId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    // Function to mark build as collected
    public function collectBuild($buildId) {
        try {
            $query = "UPDATE builds SET build_collected_date = CURDATE() WHERE build_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $buildId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }









}

?>