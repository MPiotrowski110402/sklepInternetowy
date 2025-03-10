<?php
require_once 'shop.php';
require_once 'category.php';
if(!isset($_SESSION['username'])){
    $zalogowany = false;
    $username = '';
    }
$db = new Database();
$products = new Products($db);
$cart = new Cart($db);
$categoryList = new CategoryList($db);




$count = isset($_GET['count']) ? (int)$_GET['count'] : 1;
$category = isset($_GET['category']) ? $_GET['category'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : null;
$cartCount = array_sum(array_map('intval', array_values($_SESSION['cart'])));


switch (true) {
    case ($category !== '' && $price !== null && $price !== ''):
        $productsList = $products->getProductsByFilters($category, $price, $count);
        break;
    case ($category !== '' && ($price === null || $price === '')):
        $productsList = $products->getProductByCategory($category, $count);
        break;
    case (($category === '' || $category === null) && ($price !== null && $price !== '')):
        $productsList = $products->getProductByPrice($price, $count);
        break;
    case (($category === '' || $category === null) && ($price === null || $price === '')):
        $productsList = $products->getAllProducts($count);
        break;
    default:
        $productsList = $products->getAllProducts($count);
        break;
}

$totalProducts = $productsClass->getTotalProductsCount($category, $price);
$limit = 9;
$totalPages = ceil($totalProducts / $limit);  


$count = max(1, min($count, $totalPages));
$productsList = $productsClass->getProductsByFilters($category, $price, $count);
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])){
    $search = trim($_GET['search']);
    $productsList = $productsClass->getProductBySearch($search);

}
$category = $categoryList->getAllCategories();

echo $twig->render('shop.html.twig', [
    'products' => $productsList,
    'zalogowany' => $zalogowany,
    'username' => $username,
    'totalPages' => $totalPages,
    'currentCount' => $count, 
    'category' => $category,
    'price' => $price,
    'cartCount' => $cartCount,
    'categories' => $category
]);
?>