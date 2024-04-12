
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

    

    public function getAllOrders($filterBy = null, $sortBy = null, $paymentType = null, $paymentStatus = null, $deliveryStatus = null,$customerId = null) {
        try {
            $query = "SELECT * FROM Orders";
    
            // Where conditions array
            $whereConditions = [];
    
            if ($customerId) {
                $whereConditions[] = "customer_id = :customerId";
            }
    
            if ($paymentType) {
                $whereConditions[] = "payment_type = :paymentType";
            }
    
            if ($paymentStatus) {
                $whereConditions[] = "payment_status = :paymentStatus";
            }
    
            if ($deliveryStatus) {
                $whereConditions[] = "delivery_status = :deliveryStatus";
            }
    
            // Add where conditions to query if they exist
            if (!empty($whereConditions)) {
                $query .= " WHERE " . implode(" AND ", $whereConditions);
            }
    
            // Sorting logic
            if ($sortBy) {
                switch ($sortBy) {
                    case 'date_asc':
                        $query .= " ORDER BY created_at ASC";
                        break;
                    case 'date_desc':
                        $query .= " ORDER BY created_at DESC";
                        break;
                    case 'id_asc':
                        $query .= " ORDER BY order_id ASC";
                        break;
                    case 'id_desc':
                        $query .= " ORDER BY order_id DESC";
                        break;
                    case 'total_asc':
                        $query .= " ORDER BY total ASC";
                        break;
                    case 'total_desc':
                        $query .= " ORDER BY total DESC";
                        break;
                }
            }
    
            // Preparing statement
            $stmt = $this->db->prepare($query);
    
            // Binding parameters
            if ($customerId) {
                $stmt->bindParam(':customerId', $customerId);
            }
    
            if ($paymentType) {
                $stmt->bindParam(':paymentType', $paymentType);
            }
    
            if ($paymentStatus) {
                $stmt->bindParam(':paymentStatus', $paymentStatus);
            }
    
            if ($deliveryStatus) {
                $stmt->bindParam(':deliveryStatus', $deliveryStatus);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch(PDOException $e) {
            throw $e;
        }
    }


    public function countPendingPaymentsByCustomerId($customerId) {
        try {
            $query = "SELECT COUNT(*) AS pending_payments 
                      FROM Orders 
                      WHERE customer_id = :customerId 
                      AND payment_status = 'pending'";
                      
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['pending_payments'];
        } catch(PDOException $e) {
            throw $e;
        }
    }
    

 




}
?>
