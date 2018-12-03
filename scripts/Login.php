<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("DBConnection.php");
    
    class Login extends DBConnection{
        private $config;
        private $PDOConnection;
        private $email;
        private $password;
        
        public function __construct($data){
            foreach ( $data as $key=>$value ) {
                $this->$key=$value;
            }
    
            $this->validateAndSanitize();
            
            $this->config = parse_ini_file('../Config.ini');
            
            try{
                $this->PDOConnection = new PDO("mysql:host=".$this->config['dburl']."; dbname=".$this->config['dbname'],$this->config['username'], $this->config['password'],
                                               array(PDO::ATTR_PERSISTENT => true ));
                $this->PDOConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "Connection status: " . $e->getCode() . " Connection error message: " . $e->getMessage();
                die("The Connection to the database failed");
            }

            $user = $this->findUser($this->email);
            echo $user['user_id'];
            if ($user) {
                if ($this->authenticate($this->password, $user['user_password'])) {
                    $this->createSession($user['user_id']);
                    header( 'location: ../userPage.php' );
                } else {
                    header( 'location: ../login.php?error');
                }
            } else {
                header( 'location: ../login.php?error' );
            }
        }
    
        protected function validateAndSanitize () {
            $this->email = filter_var(filter_var($this->email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            $this->password = filter_var($this->password, FILTER_SANITIZE_STRING);
            
            if (empty( $this->email) || empty( $this->password)) {
                header( 'location: ../login.php?error' );
            }
        }
        
        public function findUser($email){
            $sql = 'SELECT * FROM users WHERE email_address = :email';
            $stmt = $this->PDOConnection->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function authenticate($password, $hashedPassword){
            if (password_verify($password, $hashedPassword)) {
                return true;
            }
            return false;
        }
        
        public function createSession($id){
            session_start();
            $_SESSION['id'] = $id;
            session_write_close();
        }
    }
    
    new Login($_POST);
    
