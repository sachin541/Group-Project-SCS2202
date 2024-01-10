<?php
require_once 'database.php';

class Checkout {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createOrder($userId, $data, $cartItems) {
        try {
            $this->db->beginTransaction();

            // Insert into orders table
            $orderQuery = "INSERT INTO orders (total, created_at, payment_type, payment_status, 
            first_name, last_name, email, phone, delivery_city_address, postalcode, province, 
            city, customer_id, delivery_status) 
            VALUES (?, NOW(), ?, 'pending', ?, ?, ?, ?, ?, ?, ?, ?, ?, 'not_assigned')";
            $orderStmt = $this->db->prepare($orderQuery);

            // Binding parameters
            $orderStmt->bindParam(1, $data['total_amount']);
            $orderStmt->bindParam(2, $data['payment_method']);
            $orderStmt->bindParam(3, $data['first_name']);
            $orderStmt->bindParam(4, $data['last_name']);
            $orderStmt->bindParam(5, $data['email']);
            $orderStmt->bindParam(6, $data['phone']);
            $orderStmt->bindParam(7, $data['delivery_address']);
            $orderStmt->bindParam(8, $data['postalcode']);
            $orderStmt->bindParam(9, $data['province']);
            $orderStmt->bindParam(10, $data['city']);
            $orderStmt->bindParam(11, $userId);

            $orderStmt->execute();

            $orderId = $this->db->lastInsertId();

            // Insert into order_items table
            $orderItemQuery = "INSERT INTO order_items (quantity, order_id, product_id) VALUES (?, ?, ?)";
            $orderItemStmt = $this->db->prepare($orderItemQuery);

            foreach ($cartItems as $item) {
                // Binding parameters for each item
                $orderItemStmt->bindParam(1, $item['quantity']);
                $orderItemStmt->bindParam(2, $orderId);
                $orderItemStmt->bindParam(3, $item['product_id']);

                $orderItemStmt->execute();
            }

            $this->db->commit();
            return $orderId;
        } catch(PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
?>


<!-- TODO : should be moved into order class -->