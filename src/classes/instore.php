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



















}

