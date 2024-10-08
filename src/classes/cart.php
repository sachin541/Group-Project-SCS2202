<?php
require_once 'database.php';

class Cart {

    private $db; 

    public function __construct($db) {
        $this->db = $db;
    }

    // public function test($userId, $productId, $quantity){
    //     $checkQuery = "SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?";
    //     $checkStmt = $this->db->prepare($checkQuery);

    //     $checkStmt->bindParam(1, $userId);
    //     $checkStmt->bindParam(2, $productId);

    //     $checkStmt->execute();
    //     // $checkStmt->fetchAll(PDO::FETCH_ASSOC); 
    //     return $checkStmt;

    // }

    public function addToCart($userId, $productId, $quantity) {
        try {
            // Check if the product already exists in the cart
            $checkQuery = "SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?";
            $checkStmt = $this->db->prepare($checkQuery);

            $checkStmt->bindParam(1, $userId);
            $checkStmt->bindParam(2, $productId);

            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                // If the product is already in the cart, increment its quantity
                $currentQuantity = $checkStmt->fetchColumn();
                $newQuantity = $currentQuantity + $quantity;

                $updateQuery = "UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?";
                $updateStmt = $this->db->prepare($updateQuery);

                $updateStmt->bindParam(1, $newQuantity);
                $updateStmt->bindParam(2, $userId);
                $updateStmt->bindParam(3, $productId);

                $updateStmt->execute();
                return "Quantity updated"; 
            }

            // If the product is not in the cart, add it
            $query = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)";
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

    public function getCartItemsByUserId($userId) {
        try {
            $query = "SELECT p.*, c.quantity , c.product_id FROM cart_items c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?";
            //replace the 1 ? with the user id 
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    // for testing 
    // $stmt->bindParam(1, $userId);
    // $stmt->bindParam(2, $productId);

    //remove single item 
    public function deleteFromCart($userId, $productId) {
        try {
            $query = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
            $stmt = $this->db->prepare($query);

            $stmt->execute([$userId,$productId]);
        } catch(PDOException $e) {
            throw $e;
        }
    }


    public function updateCartQuantity($userId, $productId, $quantity) {
        try {
            $query = "UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(1, $quantity, PDO::PARAM_INT);
            $stmt->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt->bindParam(3, $productId, PDO::PARAM_INT);

            $stmt->execute();
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function clearCart($userId) {
        try {
            $query = "DELETE FROM cart_items WHERE user_id = ?";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(1, $userId, PDO::PARAM_INT);

            $stmt->execute();
            return "true";
        } catch(PDOException $e) {
            throw $e;
        }
    }

    //used when making orders 
        public function updateProductQuantities($userId) {
        try {
            $this->db->beginTransaction();

            
            $cartItems = $this->getCartItemsByUserId($userId);

            
            foreach ($cartItems as $item) {
                $updateQuery = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
                $updateStmt = $this->db->prepare($updateQuery);

                $updateStmt->bindParam(1, $item['quantity'], PDO::PARAM_INT);
                $updateStmt->bindParam(2, $item['product_id'], PDO::PARAM_INT);

                $updateStmt->execute();
            }

            $this->db->commit();
            return "Product quantities updated";
        } catch(PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

}

