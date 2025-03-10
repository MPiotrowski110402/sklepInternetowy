<?php
require 'vendor/autoload.php';
require 'public/db.php';
session_start();
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


if(isset($_SESSION['username'])){
    $zalogowany = true;
    $username = $_SESSION['username'];
}

$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

$page = $_GET['page'] ?? 'shop_view'; 


$pageFile = 'pages/' . $page . '.php';

if (file_exists($pageFile)) {

    include $pageFile;
} else {

    echo "Strona nie została znaleziona.";
}

Class User{
    private $id;
    private $username;
    private $email;
    private $password;

    public function __construct($username, $email, $password){
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }
    public function getId(){
        return $this->id;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function hashPassword(){
        return password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function setUsername($username){
        $this->username = $username;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setPassword($password){
        $this->password = $password;
    }

}

?>
