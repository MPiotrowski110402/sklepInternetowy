<?php 
require_once 'shop.php';
$db = new Database();

class CategoryList{
    private $db;


    
    public function __construct($db){
        $this->db = $db;
    }



    public function getAllCategories(){
        $query = $this->db->getConnection()->prepare("SELECT * FROM categories");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>