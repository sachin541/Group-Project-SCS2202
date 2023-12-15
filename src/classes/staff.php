<?php
require_once 'database.php';

class Staff {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function deleteProduct($productId) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function updateProductStock($productId, $newQuantity) {
        try {
            $query = "UPDATE products SET quantity = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $newQuantity, PDO::PARAM_INT);
            $stmt->bindParam(2, $productId, PDO::PARAM_INT);
            $stmt->execute();
        } catch(PDOException $e) {
            throw $e;
        }
    }

    private function bindImageOrNull($stmt, $paramNumber, $image) {
        if ($image) {
            $stmt->bindParam($paramNumber, $image, PDO::PARAM_LOB);
        } else {
            $stmt->bindValue($paramNumber, null, PDO::PARAM_NULL);
        }
    }

    public function updateProduct($id, $productName, $category, $quantity, $description, $price, $discount, $brand, $image1, $image2, $image3) {
        try {
            $query = "UPDATE products SET product_name = ?, category = ?, quantity = ?, product_description = ?, price = ?, discount = ?, 
            brand = ?, image1 = IFNULL(?, image1), image2 = IFNULL(?, image2), image3 = IFNULL(?, image3) WHERE id = ?";
            $stmt = $this->db->prepare($query);
            
    
            $stmt->bindParam(1, $productName);
            $stmt->bindParam(2, $category);
            $stmt->bindParam(3, $quantity);
            $stmt->bindParam(4, $description);
            $stmt->bindParam(5, $price);
            $stmt->bindParam(6, $discount);
            $stmt->bindParam(7, $brand);
            $this->bindImageOrNull($stmt, 8, $image1);
            $this->bindImageOrNull($stmt, 9, $image2);
            $this->bindImageOrNull($stmt, 10, $image3);
            $stmt->bindParam(11, $id, PDO::PARAM_INT);
    
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch(PDOException $e) {
            throw $e;
        }
    }








}





?>