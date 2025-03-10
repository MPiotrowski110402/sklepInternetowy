<?php 
require_once 'shop.php';
if(!isset($_SESSION['username'])){
$zalogowany = false;
$username = '';
}
$db = new Database();
$cart = new Cart($db);
$cartContent = $cart->getCartDetails();
$totalPrice = 0;
foreach ($cartContent as $item){
    $totalPrice += $item['price'] * $item['quantity'];
}
if(isset($_GET['deleteCart']) &&  $_GET['deleteCart'] == 'true') {
    $cart->clearCart();
    header('Location: index.php?page=cart');
    exit;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cart->deleteRow($id);
    header('Location: index.php?page=cart');
   
}
echo $twig->render('cart.html.twig', [
    'cart' => $cartContent,
    'totalPrice' => $totalPrice,
    'zalogowany' => $zalogowany,
    'username' => $username,
]);
?>