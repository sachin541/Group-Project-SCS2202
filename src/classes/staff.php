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
}
?>