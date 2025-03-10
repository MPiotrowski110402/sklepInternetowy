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
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'price_asc';
$cartCount = array_sum(array_map('intval', array_values($_SESSION['cart'])));
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

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

if (!empty($search)) {
    $totalProducts = $products->getTotalProductsCountBySearch($search);
} else {
    $totalProducts = $products->getTotalProductsCount($category, $price);
}


$limit = 9;
$totalPages = ceil($totalProducts / $limit);  

$count = max(1, min($count, $totalPages));
$productsList = $products->getProductsByFilters($category, $price, $count);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $productsList = $products->getProductBySearch($search);
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sortBy'])) {
    $sortBy = $_GET['sortBy'];
    $productsList = $products->getProductBySort($sortBy);
}


$categories = $categoryList->getAllCategories();
$productCount = $totalProducts;

echo $twig->render('shop.html.twig', [
    'products' => $productsList,
    'zalogowany' => $zalogowany,
    'username' => $username,
    'totalPages' => $totalPages,
    'currentCount' => $count, 
    'category' => $category,
    'price' => $price,
    'cartCount' => $cartCount,
    'categories' => $categories,
    'productsCount' => $productCount,
    'sortBy' => $sortBy,
]);
?>
