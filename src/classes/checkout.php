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
            VALUES (?, NOW(), ?, 'pending', ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Order Placed')";

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


    
    public function createOrderOnline($userId, $data, $cartItems) {
        try {
            $this->db->beginTransaction();

            // Insert into orders table
            $orderQuery = "INSERT INTO orders (total, created_at, payment_type, payment_status, 
            first_name, last_name, email, phone, delivery_city_address, postalcode, province, 
            city, customer_id, delivery_status) 
            VALUES (?, NOW(), ?, 'Completed', ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Order Placed')";

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

    // public function setPayHereStatus($status, $order_id){
        
    //     $query = "UPDATE orders SET payherestatus = ? WHERE order_id = ?";
    //     $stmt = $this->db->prepare($query); 
    //     $result = $stmt->execute([$status,$order_id]); 
    //     return $result; 
    // }

    public function getNextOrderId() {
        try {
            
            $stmt = $this->db->query("SELECT MAX(order_id) AS max_id FROM orders");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nextId = $row ? $row['max_id'] + 1 : 1;


            return $nextId;
        } catch (PDOException $e) {
        
            
            throw $e;
        }
    }

    public function insertPayment($statusCode, $order_id) {
        try {
        
            $stmt = $this->db->prepare("INSERT INTO payments (status, order_id)  VALUES (?,?)");
        
            $stmt->execute([$statusCode,$order_id]);

        } catch (PDOException $e) {
            throw $e; 
        }
    }

    public function PayHereNotify($statusCode, $order_id){
        
        $stmt = $this->db->prepare("UPDATE payments SET status = ? WHERE order_id = ?"); 
        
        
        $stmt->execute([$statusCode, $order_id]); 
    }

    public function GetPaymentStatus($order_id) {
        // Prepare the SQL query
        $stmt = $this->db->prepare("SELECT EXISTS (
            SELECT 1 
            FROM payments 
            WHERE order_id = :order_id AND status = 2
        ) AS StatusExists");

        // Bind the order_id parameter to the query
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return true if there exists at least one record with status 2, false otherwise
        return (bool)$result['StatusExists'];
    }


    

}
?>


