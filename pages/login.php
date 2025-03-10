<?php
    $db = new Database();
    class Auth{
        private $db;
        public function __construct(Database $db) {
            $this->db = $db;
        }

        public function login($email, $password){
            $query = $this->db->getConnection()->prepare("SELECT * FROM users WHERE email =?");
            $query->execute([$email]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password_hash'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                return ['success' => 'Login successful'];
            }else{
                return ['error' => 'Invalid email or password'];
            }
        }
    }
    $auth = new Auth($db);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];
        if(empty($email)){
            $errors[] = 'Email is required';
        }
        if(empty($password)){
            $errors[] = 'Password is required';
        }
        if(empty($errors)){
            $result = $auth->login($email, $password);
            if(isset($result['error'])){
                $errors[] = $result['error'];
            }
            else{
                header('Location: index.php');
                exit();
            }
        }
        echo $twig->render('login.html.twig',[
            'errors' => $errors,
        ]);
    }else{
        echo $twig->render('login.html.twig', []);
    }
?>
