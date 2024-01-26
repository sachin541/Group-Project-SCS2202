
<?php
require_once 'database.php';
require_once 'Order.php';
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
        try {
            // Start constructing the query
            $query = "UPDATE Orders SET delivery_status = ?";

            // Only add payment_status update if the new status is 'Completed'
            if ($newStatus === 'Completed') {
                $query .= ", payment_status = 'Payment Completed'";
            }

            // Finalize the query
            $query .= " WHERE order_id = ?";

            // Preparing and executing the statement
            $stmt = $this->db->prepare($query);
            $stmt->execute([$newStatus, $orderId]);

            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }


    public function getMyDeliveries($deliveryPersonId) {
        try {
            $query = "SELECT d.*, o.total, o.created_at 
                      FROM deliveries d
                      JOIN orders o ON d.order_id = o.order_id
                      WHERE d.delivery_person_id = ? AND d.status = 'Accepted'";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$deliveryPersonId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }


    
}
?>