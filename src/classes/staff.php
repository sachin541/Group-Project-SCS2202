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
}
?>