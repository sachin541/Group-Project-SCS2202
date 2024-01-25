
<?php
require_once 'database.php';

class Order {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    //TODO : CHANGE THIS FUNCTION
    public function getOrderDetails($orderId) {
    try {
        $query = "SELECT 
                    orders.order_id, orders.total, orders.created_at, orders.payment_type , orders.payment_status,
                    orders.first_name, orders.last_name, orders.email, orders.phone, orders.delivery_status, 
                    orders.delivery_city_address, orders.postalcode, orders.city, orders.province,
                    order_items.quantity AS item_quantity, order_items.product_id,
                    products.product_name, products.price
                    
                  FROM Orders orders
                  JOIN Order_Items order_items ON orders.order_id = order_items.order_id
                  JOIN products ON order_items.product_id = products.id
                  WHERE orders.order_id = ?";
                  
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);

        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orderDetails;
    } catch(PDOException $e) {
        throw $e;
    }
    }

    public function getUnassignedOrders() {
        try {
            $query = "SELECT * FROM orders WHERE delivery_status = 'Order Placed' ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function updateDeliveryStatus($orderId, $status) {
        try {
            $query = "UPDATE orders SET delivery_status = ? WHERE order_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$status, $orderId]);
            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }


}
?>
