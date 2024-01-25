
<?php
require_once 'database.php';

class Delivery {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function CreateDelivery($orderid,$delivery_id,$accpted_date,$completed_date,$status) {
    try {

        $query = "INSERT INTO deliveries (order_id, delivery_person_id, accpeted_date,completed_date,status) VALUES (?,?,?,?,?)"; 
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $orderid); 
        $stmt->bindParam(2, $delivery_id);
        $stmt->bindParam(3, $accpted_date);
        $stmt->bindParam(4, $completed_date);
        $stmt->bindParam(5, $status);
        
        $stmt->execute(); 
        return true; 
        
    } catch(PDOException $e) {
        return $e; 
    }

    }



}
?>