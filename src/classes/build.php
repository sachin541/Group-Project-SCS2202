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
    
            
            $buildQuery = "INSERT INTO builds 
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
        $query = "SELECT b.*, c.* FROM builds b
                  INNER JOIN components_list c ON b.components_list_id = c.id
                  WHERE b.customer_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $customerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getStatus($buildId) {
        $query = "SELECT technician_assigned_date, build_start_date,
         build_completed_date, build_collected_date , rejected 
         FROM builds WHERE build_id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $buildId);
        $stmt->execute();
        $build = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$build) {
            return 'Build Not Found';
        }
        if($build['rejected'] == 1){
            return 'Request Rejected'; 
        }
        elseif (is_null($build['technician_assigned_date'])) {
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
            case 'Request Rejected':
                return 'status-request-rejected';
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
            $query = "SELECT * FROM builds WHERE build_id = ?";
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
        
        try {
            $query = "SELECT build_id, customer_name, build_start_date, build_completed_date, build_collected_date FROM builds WHERE technician_id = :technicianId";

            if ($filter == 'rejected'){
                $query.= " AND rejected IS NOT NULL";
            }
            else if ($filter == 'completed') {
                $query .= " AND build_collected_date IS NOT NULL";
            } elseif ($filter == 'active') {
                $query .= " AND build_collected_date IS NULL AND rejected IS NULL";
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
               
                $query = "SELECT b.*, c.* FROM builds b
                  INNER JOIN components_list c ON b.components_list_id = c.id
                  WHERE technician_assigned_date IS NULL";

                $stmt = $this->db->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                throw $e;
            }
    }

    //eror here
    public function getBuildStatus($build) {
        if($build['rejected'] == 1){
            return ['Rejected', 'status-request-rejected'];
        }
        else if ($build['build_collected_date'] !== null && $build['build_collected_date'] !== '') {
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


    public function checkComponentStock($buildId) {
        $outOfStockItems = [];

        // Retrieve the components list for the given build ID
        $query = "SELECT components_list_id FROM builds WHERE build_id = :buildId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':buildId', $buildId);
        $stmt->execute();
        $componentsListId = $stmt->fetch(PDO::FETCH_COLUMN);

       
        $query = "SELECT CPU_id, GPU_id, MotherBoard_id, Memory_id, Storage_id, PowerSupply_id, Case_id, CPU_Coolers_id, Monitor_id, Mouse_id, Keyboard_id FROM components_list WHERE id = :componentsListId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':componentsListId', $componentsListId);
        $stmt->execute();
        $components = $stmt->fetch(PDO::FETCH_ASSOC);

        //Check the current stock quantity for each of those components
        foreach ($components as $componentId) {
            if (!empty($componentId)) { // Ensure the componentId is not null
                $query = "SELECT product_name, quantity FROM products WHERE id = :componentId";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':componentId', $componentId);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product['quantity'] <= 0) {
                    // Add out of stock item to the list
                    $outOfStockItems[] = $product['product_name'];
                }
            }
        }

        // Return the list of components that are out of stock
        return $outOfStockItems;
    }

    public function reduceComponentStock($buildId) {

        $query = "SELECT components_list_id FROM builds WHERE build_id = :buildId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':buildId', $buildId);
        $stmt->execute();
        $componentsListId = $stmt->fetch(PDO::FETCH_COLUMN);

        try {
            
            $query = "SELECT CPU_id, GPU_id, MotherBoard_id, Memory_id, Storage_id, PowerSupply_id, Case_id, CPU_Coolers_id, Monitor_id, Mouse_id, Keyboard_id FROM components_list WHERE id = :componentsListId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':componentsListId', $componentsListId);
            $stmt->execute();
            $components = $stmt->fetch(PDO::FETCH_ASSOC);
    
            foreach ($components as $componentId) {
                if (!empty($componentId)) { 
                    $updateQuery = "UPDATE products SET quantity = quantity - 1 WHERE id = :componentId AND quantity > 0";
                    $updateStmt = $this->db->prepare($updateQuery);
                    $updateStmt->bindParam(':componentId', $componentId);
                    $updateStmt->execute();
                    
                    
                    if ($updateStmt->rowCount() == 0) {
                        
                        throw new Exception("Failed to decrement product stock for component ID: " . $componentId);
                    }
                }
            }
        } catch(PDOException $e) {
            throw $e;
        } catch(Exception $e) {
            throw $e;
        }
    }
    




}

?>