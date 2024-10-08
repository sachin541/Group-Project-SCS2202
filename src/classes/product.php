<?php
require_once 'database.php';
require_once 'users.php';
class Product {
    private $db; 

    public function __construct($db) {
        $this->db = $db;
    }

    public function addProduct($productName, $category, $quantity, $description, $price, $discount, $brand, $image1, $image2, $image3) {
        try {
            $query = "INSERT INTO products (product_name, category, quantity, product_description, 
            price, discount, brand, image1, image2, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($query);
    
            $stmt->bindParam(1, $productName);
            $stmt->bindParam(2, $category);
            $stmt->bindParam(3, $quantity);
            $stmt->bindParam(4, $description);
            $stmt->bindParam(5, $price);
            $stmt->bindParam(6, $discount);
            $stmt->bindParam(7, $brand);
    
            // Handling images
            $this->bindImageOrNull($stmt, 8, $image1);
            $this->bindImageOrNull($stmt, 9, $image2);
            $this->bindImageOrNull($stmt, 10, $image3);
    
            $stmt->execute();
            return $this->db->lastInsertId();
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


    public function getProductsByCategory($categoryName,$search=NULL) {
        try {
            $query = "SELECT * FROM products WHERE category = ? AND price";

            if($search != NULL){
                $query = $query . "AND product_name LIKE '%" . $search . "%'"; 
            }

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $categoryName);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function getProductById($productId) {
        try {
            $query = "SELECT * FROM products WHERE id = ? LIMIT 1"; 
            $stmt = $this->db->prepare($query);

            
            $stmt->bindParam(1, $productId, PDO::PARAM_INT);

            $stmt->execute();

            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function getProductStockById($productId) {
        try {
            // Query to select only the quantity column
            $query = "SELECT quantity FROM products WHERE id = ? LIMIT 1"; 
            $stmt = $this->db->prepare($query);
    
            // Bind the product ID parameter
            $stmt->bindParam(1, $productId, PDO::PARAM_INT);
    
            // Execute the statement
            $stmt->execute();
    
            // Fetch and return only the quantity
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['quantity'] : null;
        } catch(PDOException $e) {
            // Handle exception
            throw $e;
        }
    }
    

    public function getTotalNumberOfProducts() {
        try {
            $query = "SELECT COUNT(*) AS total FROM products"; // SQL query to count all products
            $stmt = $this->db->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result
            return $result['total']; // Return the total count
        } catch(PDOException $e) {
            throw $e; // Handle any exceptions
        }
    }
    
    public function getLatestProducts($limit = 10) {
        try {
            $query = "SELECT * FROM products ORDER BY added_timestamp DESC LIMIT ?";
            $stmt = $this->db->prepare($query);
            
            // Bind the limit parameter
            $stmt->bindParam(1, $limit, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }
    
    //from categories table 
    public function getAllCategories() {
        try {
            $query = "SELECT category FROM productcategories ORDER BY category";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    //from products table 
    public function getDistincCategoriesFromProduct() {
        try {
            // Adjusted query to select unique categories from the products table
            $query = "SELECT DISTINCT category FROM products ORDER BY category";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }
    
}
?>
