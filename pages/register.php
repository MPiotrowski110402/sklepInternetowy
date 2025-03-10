<?php
    
    $db = new Database();

    class Auth {
        private $db;

        public function __construct(Database $db) {
            $this->db = $db;
        }
        public function checkIfUserExists($email, $username){
            $query = $this->db->getConnection()->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
            $query->execute([$email, $username]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        public function register(User $user, $password, $confirm_password ){
            if($password !== $confirm_password){
                return ['error' => 'Hasła nie są identyczne'];
            }


            if($this->checkIfUserExists($user->getEmail(), $user->getUsername())){
                return ['error' => 'User already exists'];
            }
            $password_hash = $user->hashPassword();


            $query = $this->db->getConnection()->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $query->execute([$user->getUsername(), $user->getEmail(), $password_hash]);

            return ['success' => 'User registered successfully'];
        }

    }
    $auth = new Auth($db);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $errors = [];
        if (empty($username)) {
            $errors[] = 'Nazwa użytkownika jest wymagana.';
        }
    
        if (empty($email)) {
            $errors[] = 'Adres e-mail jest wymagany.';
        }
    
        if (empty($password)) {
            $errors[] = 'Hasło jest wymagane.';
        }
    
        if ($password !== $confirm_password) {
            $errors[] = 'Hasła nie są identyczne.';
        }
        if(empty($errors)){
            $user = new User($username,$email,$password);
            $result = $auth->register($user, $password, $confirm_password);

            if(isset($result['error'])){
                $errors[] = $result['error'];
            }else{
                header("Location: index.php?page=login");
            }

        echo $twig->render('register.html.twig',[
            'errors' => $errors,
        ]);
        }
    }else{
        echo $twig->render('register.html.twig', []);
    }
?>
