<?php
require_once 'database.php';



class InStore  {

    private $db; 

    public function __construct($db) {
        $this->db = $db;
    }
    public function addToInStore($userId, $productId, $quantity) {
        
        try {
            
            $checkQuery = "SELECT quantity FROM instore_items WHERE user_id = ? AND product_id = ?";
            $checkStmt = $this->db->prepare($checkQuery);

            $checkStmt->bindParam(1, $userId);
            $checkStmt->bindParam(2, $productId);

            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                
                $currentQuantity = $checkStmt->fetchColumn();
                $newQuantity = $currentQuantity + $quantity;

                $updateQuery = "UPDATE instore_items SET quantity = ? WHERE user_id = ? AND product_id = ?";
                $updateStmt = $this->db->prepare($updateQuery);

                $updateStmt->bindParam(1, $newQuantity);
                $updateStmt->bindParam(2, $userId);
                $updateStmt->bindParam(3, $productId);

                $updateStmt->execute();
                return "Quantity updated"; 
            }

            
            $query = "INSERT INTO instore_items (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $productId);
            $stmt->bindParam(3, $quantity);

            $stmt->execute();
            return $this->db->lastInsertId();
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function getInStoreItemsByUserId($userId) {
       
        try {
            $query = "SELECT p.*, i.quantity, i.product_id FROM instore_items i JOIN products p ON i.product_id = p.id WHERE i.user_id = ?";
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function deleteFromInStore($userId, $productId) {
        try {
            $query = "DELETE FROM instore_items WHERE user_id = ? AND product_id = ?";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $productId);

            $stmt->execute();
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function updateInStoreQuantity($userId, $productId, $quantity) {
        try {
            $query = "UPDATE instore_items SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(1, $quantity, PDO::PARAM_INT);
            $stmt->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt->bindParam(3, $productId, PDO::PARAM_INT);

            $stmt->execute();
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function clearInStore($userId) {
        try {
            $query = "DELETE FROM instore_items WHERE user_id = ?";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(1, $userId, PDO::PARAM_INT);

            $stmt->execute();
            return "InStore items cleared";
        } catch(PDOException $e) {
            throw $e;
        }
    }

    
    public function updateInStoreProductQuantities($userId) {
        try {
            $this->db->beginTransaction();

            $inStoreItems = $this->getInStoreItemsByUserId($userId);

            foreach ($inStoreItems as $item) {
                $updateQuery = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
                $updateStmt = $this->db->prepare($updateQuery);

                $updateStmt->bindParam(1, $item['quantity'], PDO::PARAM_INT);
                $updateStmt->bindParam(2, $item['product_id'], PDO::PARAM_INT);

                $updateStmt->execute();
            }

            $this->db->commit();
            return "InStore product quantities updated";
        } catch(PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    

    public function ConfirmInStoreOrder($userId, $data, $cartItems) {
        try {
            $this->db->beginTransaction();
    
            // Updated query for InStorePurchase table
            $orderQuery = "INSERT INTO instorepurchase (total, createdby, payment_type, payment_status, 
            NIC, first_name, last_name, phone) 
            VALUES (?, ?, ?, 'completed', ?, ?, ?, ?)";
    
            $orderStmt = $this->db->prepare($orderQuery);
    
            // Bind parameters
            $orderStmt->bindParam(1, $data['total_amount']);
            $orderStmt->bindParam(2, $userId); // Assuming createdby is the user ID
            $orderStmt->bindParam(3, $data['payment_method']);
            $orderStmt->bindParam(4, $data['NIC']); // Assuming NIC is part of $data
            $orderStmt->bindParam(5, $data['first_name']);
            $orderStmt->bindParam(6, $data['last_name']);
            $orderStmt->bindParam(7, $data['phone']);
    
            $orderStmt->execute();
    
            $orderId = $this->db->lastInsertId();
    
            // Insert into InStorePurchase_Items table
            $orderItemQuery = "INSERT INTO instorepurchase_items (quantity, order_id, product_id) VALUES (?, ?, ?)";
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

    public function getAllOrders($filterBy = null, $sortBy = null) {
        try {
            // Start of query
            $query = "SELECT * FROM instorepurchase";
    
            // Filtering logic
            if ($filterBy) {
                // Adjust the filtering logic as per your requirement
                $query .= " WHERE payment_status = :filterBy";
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
                    case 'total_asc':
                        $query .= " ORDER BY total ASC";
                        break;
                    case 'total_desc':
                        $query .= " ORDER BY total DESC";
                        break;
                    // Add more sorting options if needed
                }
            } else {
                // Default sorting
                $query .= " ORDER BY created_at DESC";
            }
    
            // Preparing and executing the statement
            $stmt = $this->db->prepare($query);
    
            // Bind the filter parameter if it exists
            if ($filterBy) {
                $stmt->bindParam(':filterBy', $filterBy);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch(PDOException $e) {
            throw $e;
        }
    }
    
    public function getInStoreOrderDetails($orderId) {
        try {
            $query = "SELECT 
            instorepurchase.order_id, instorepurchase.total, instorepurchase.created_at, instorepurchase.createdby, instorepurchase.payment_type, instorepurchase.payment_status,
            instorepurchase.first_name, instorepurchase.last_name, instorepurchase.NIC, instorepurchase.phone, 
            instorepurchase_items.quantity AS item_quantity, instorepurchase_items.product_id,
            products.product_name, products.price
            FROM instorepurchase
            JOIN instorepurchase_items ON instorepurchase.order_id = instorepurchase_items.order_id
            JOIN products ON instorepurchase_items.product_id = products.id
            WHERE instorepurchase.order_id = ?";
                      
            $stmt = $this->db->prepare($query);
            $stmt->execute([$orderId]);
    
            $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $orderDetails;
        } catch(PDOException $e) {
            throw $e;
        }
    }


}


