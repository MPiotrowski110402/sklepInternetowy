<?php 
require_once 'shop.php';
if(!isset($_SESSION['username'])){
$zalogowany = false;
$username = '';
}

$db = new Database();
$products = new Products($db);

// Pobranie ID produktu z URL
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

// Pobranie produktu na podstawie ID
$product = $products->getProductById($product_id);


if (!$product) {
    echo 'Brak produktu o tym ID.';
    exit;
}


echo $twig->render('product_detail.html.twig', [
    'product' => $product,
    'zalogowany' => $zalogowany,
    'username' => $username
]);
?>