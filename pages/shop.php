<?php

    $db = new Database();

    class Products {
        private $db;

        public function __construct(Database $db) {
            $this->db = $db;
        }
        public function getAllProducts($count = 1){
            $count = max(1,$count);
            $limit = 9;
            $offset = ($count - 1) * $limit;
            $query = $this->db->getConnection()->prepare("SELECT p.* FROM products p LIMIT :limit OFFSET :offset");
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->bindParam(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_ASSOC);      
            
        }
        public function getProductByCategory($category, $count = 1) {
            if ($category == '') {
                return $this->getAllProducts($count); 
            }
            $limit = 9;
            $offset = ($count - 1) * $limit;
            $query = $this->db->getConnection()->prepare(
                "SELECT p.* 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE c.name = :category
                LIMIT :limit OFFSET :offset"
            );
            $query->bindParam(':category', $category, PDO::PARAM_STR);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->bindParam(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getProductByPrice($price) {
            $query = $this->db->getConnection()->prepare(
                "SELECT * FROM products WHERE price <= :price"
            );
            $query->bindParam(':price', $price, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getProductsByFilters($category, $price, $count = 1) {
            $count = max(1, $count);
            $limit = 9;
            $offset = ($count - 1) * $limit;
            $sql = "SELECT p.* FROM products p";
            
            if ($category !== '') {
                $sql .= " JOIN categories c ON p.category_id = c.id WHERE c.name = :category";
            }
        
            if ($price !== null && $price !== '') {
                if ($category !== '') {
                    $sql .= " AND p.price <= :price";
                } else {
                    $sql .= " WHERE p.price <= :price";
                }
            }
        
            $sql .= " LIMIT :limit OFFSET :offset"; 
        
            $query = $this->db->getConnection()->prepare($sql);
        
            if ($category !== '') {
                $query->bindParam(':category', $category, PDO::PARAM_STR);
            }
            if ($price !== null && $price !== '') {
                $query->bindParam(':price', $price, PDO::PARAM_INT);
            }
            $query->bindParam(':limit', $limit, PDO::PARAM_INT); 
            $query->bindParam(':offset', $offset, PDO::PARAM_INT);  
        
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getTotalProductsCount($category = '', $price = null) {
            $sql = "SELECT COUNT(*) FROM products p";
        
            if ($category !== '') {
                $sql .= " JOIN categories c ON p.category_id = c.id WHERE c.name = :category";
            }
        
            if ($price !== null && $price !== '') {
                if ($category !== '') {
                    $sql .= " AND p.price <= :price";
                } else {
                    $sql .= " WHERE p.price <= :price";
                }
            }
        
            $query = $this->db->getConnection()->prepare($sql);
        
            if ($category !== '') {
                $query->bindParam(':category', $category, PDO::PARAM_STR);
            }
        
            if ($price !== null && $price !== '') {
                $query->bindParam(':price', $price, PDO::PARAM_INT);
            }
        
            $query->execute();
            return $query->fetchColumn();
        }
        public function getProductById($id){
            $query = $this->db->getConnection()->prepare("SELECT * FROM products WHERE id =?");
            $query->execute([$id]);
            $product = $query->fetch(PDO::FETCH_ASSOC);
            if ($product && isset($product['specifications'])) {
                $product['specifications'] = json_decode($product['specifications'], true);
            }
            return $product;
        }
        public function getProductBySearch($search){
            $query = $this->db->getConnection()->prepare("SELECT * FROM products WHERE name LIKE :search OR description LIKE :search OR specifications LIKE :search");
            $search = "%$search%"; 
            $query->bindValue(':search', $search, PDO::PARAM_STR); 
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getTotalProductsCountBySearch($search) {
            $query = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM products WHERE name LIKE :search OR description LIKE :search OR specifications LIKE :search");
            $search = "%$search%"; 
            $query->bindValue(':search', $search, PDO::PARAM_STR); 
            $query->execute();
            return $query->fetchColumn();
        }
        public function getProductBySort($sort){
            
            $orderBy = '';
        
            
            switch ($sort) {
                case 'price_desc':
                    $orderBy = 'ORDER BY price DESC';
                    break;
                case 'price_asc':
                default:
                    $orderBy = 'ORDER BY price ASC';
                    break;
            }
        
            
            $query = $this->db->getConnection()->prepare("SELECT * FROM products $orderBy");
        
            
            $query->execute();
        
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

    }
    class Cart {
        private $db;
        private $cartId;
        public function __construct(Database $db) {
            $this->db = $db;
            $this->cartId = $this->getCartId();
            $this->loadCart();
        }
        private function getCartId(){
            if(isset($_COOKIE['cart_id'])){
                return $_COOKIE['cart_id'];
            }
            else{
                $newCartId = bin2hex(random_bytes(16));
                setcookie('cart_id',$newCartId, time()+ (30*24*60*60), "/");
                return $newCartId;
            }
        }
        private function loadCart(){
            $query = $this->db->getConnection()->prepare("SELECT data FROM carts WHERE cart_id = ?");
            $query->execute([$this->cartId]);
            $cartData = $query->fetchColumn();
            if($cartData){
                $_SESSION['cart'] = json_decode($cartData, true);
            }else{
                $_SESSION['cart'] = [];
            }
        }
        private function saveCart(){
            $cartData = json_encode($_SESSION['cart']);
            $query = $this->db->getConnection()->prepare("
            INSERT INTO carts (cart_id, data) VALUES (?,?)
            ON DUPLICATE KEY UPDATE data = ?
            ");
            $query ->execute([$this->cartId, $cartData, $cartData]);
        }
        public function addProduct($product_id, $quantity){
            if(isset($_SESSION['cart'][$product_id])){
                $_SESSION['cart'][$product_id] += $quantity;
            }else{
                $_SESSION['cart'][$product_id] = $quantity;
            }
            $this->saveCart();
        }

        public function removeProduct($product_id){
            if( isset($_SESSION['cart'][$product_id])){
                unset($_SESSION['cart'][$product_id]);
            }
            $this->saveCart();
        }
        public function getCart(){
            return $_SESSION['cart'];
        }
        public function clearCart(){
            $_SESSION['cart'] = [];
            $this->saveCart();
        }
        public function getCartDetails(){
            $cart = $this->getCart();
            $productDetails = [];

            foreach($cart as $product_id => $quantity){
                $query = $this->db->getConnection()->prepare("SELECT name, price FROM products WHERE id = ?");
                $query->execute([$product_id]);
                $product = $query->fetch();

                if($product){
                    $productDetails[] = [
                        'id' => $product_id,
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'quantity' => $quantity
                    ];
                }
            }
            return $productDetails;
        }
        public function deleteRow($id){
            if(isset($_SESSION['cart'][$id])){
                unset($_SESSION['cart'][$id]);
                $this->saveCart();
                return true;
            }
        }
    }
    $productsClass = new Products($db);
    $cart = new Cart($db);
    $count = isset($_GET['count']) ? (int)$_GET['count'] : 1;
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $price = isset($_GET['price']) ? $_GET['price'] : null;


    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])){
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $cart->addProduct($product_id, $quantity);
        header("Location: index.php?page=shop_view&category=$category&price=$price&count=$count");
        exit();
    }
?>
