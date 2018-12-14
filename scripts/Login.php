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
            
            $this->PDOConnection = $this->getConnection();

            $user = $this->findUser($this->email);
            
            if ($user) {
                if ($this->authenticate($this->password, $user['user_password'])) {
                    $this->createSession($user);
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
        
        private function findUser($email){
            $sql = 'SELECT * FROM users WHERE email_address = :email';
            $stmt = $this->PDOConnection->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        private function authenticate($password, $hashedPassword){
            if (password_verify($password, $hashedPassword)) {
                return true;
            }
            return false;
        }
        
        private function createSession( $user){
            session_start();
            $_SESSION['id'] = $user["user_id"];
            $_SESSION[ "firstName" ] = $user[ "first_name" ];
            $_SESSION[ "lastName" ] = $user[ "second_name" ];
            $_SESSION[ "email" ] = $user[ "email_address" ];
            $_SESSION[ "address" ] = $user[ "home_address" ];
            $_SESSION[ "username" ] = $user[ "username" ];
            session_write_close();
        }
    }
    
    new Login($_POST);
    
