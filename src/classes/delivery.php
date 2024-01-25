
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
            $this->db->beginTransaction();

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


    
}
?>