
<?php
require_once 'database.php';
require_once 'order.php';
class Delivery {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function CreateDelivery($orderid, $delivery_id, $completed_date, $status) {
        try {
            

            $query = "INSERT INTO deliveries (order_id, delivery_person_id, completed_date, status) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
    
            $stmt->bindParam(1, $orderid);
            $stmt->bindParam(2, $delivery_id);
            $stmt->bindParam(3, $completed_date);
            $stmt->bindParam(4, $status);
    
            $stmt->execute();
            return true;
    
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function acceptDelivery($orderId, $deliveryPersonId, $completedDate, $status) {
        try {
            $this->db->beginTransaction();

            
            $order = new Order($this->db);
            $order->updateDeliveryStatus($orderId, 'Accepted');

            
            $this->CreateDelivery($orderId, $deliveryPersonId, $completedDate, $status);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function progressDeliveryStage($orderId, $newStatus) {
        $this->db->beginTransaction();
        try {
            // Update Orders table
            $queryOrders = "UPDATE orders SET delivery_status = ?";
            if ($newStatus === 'Completed') {
                $queryOrders .= ", payment_status = 'Payment Completed'";
            }
            $queryOrders .= " WHERE order_id = ?";
            $stmtOrders = $this->db->prepare($queryOrders);
            $stmtOrders->execute([$newStatus, $orderId]);

            // Update Deliveries table if the new status is 'Completed'
            if ($newStatus === 'Completed') {
                $queryDeliveries = "UPDATE deliveries SET completed_date = NOW(), status = 'completed' WHERE order_id = ?";
                $stmtDeliveries = $this->db->prepare($queryDeliveries);
                $stmtDeliveries->execute([$orderId]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }


    public function getMyDeliveries($deliveryPersonId , $status=NULL) {
        try {
            $query = "SELECT d.*, o.total, o.created_at , o.delivery_status 
                      FROM deliveries d
                      JOIN orders o ON d.order_id = o.order_id
                      WHERE d.delivery_person_id = ?"; 
                      
            if($status != NULL){
                $query = $query . "AND o.delivery_status = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$deliveryPersonId, $status]);
            }else{
            $stmt = $this->db->prepare($query);
            $stmt->execute([$deliveryPersonId]);
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getDeliveryPerson($orderID){
        $query = "SELECT employees.staff_name , employees.mobile_no FROM deliveries 
        JOIN employees ON employees.staff_id = deliveries.delivery_person_id
        WHERE order_id = ?" ;
        $stmt = $this->db->prepare($query); 
        $stmt->execute([$orderID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);  
       
    }


    
}
?>