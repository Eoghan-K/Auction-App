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
        private $user;
        
        public function __construct($data){
            foreach ( $data as $key=>$value ) {
                $this->$key=$value;
            }
            
            $this->validateAndSanitize();
            
            $this->config = parse_ini_file('../Config.ini');
            
            $this->PDOConnection = $this->getConnection();

            $this->user = $this->findUser();
            
            if ($this->user) {
                echo $this->user;
               $this->authenticate();
            }
        }
    
        protected function validateAndSanitize () {
            $this->email = filter_var( filter_var( $this->email, FILTER_SANITIZE_EMAIL ), FILTER_VALIDATE_EMAIL );
            $this->password = filter_var( $this->password, FILTER_SANITIZE_STRING );
            
            if ( empty( $this->email ) || empty( $this->password ) ) {
                $this->ToLogin( false );
            }
        }
        
        private function findUser(){
            $sql = 'SELECT * FROM users WHERE email_address = :email';
            $stmt = $this->PDOConnection->prepare($sql);
            $stmt->bindParam(':email', $this ->email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        private function authenticate(){
            if (password_verify($this->password, $this->user[ 'user_password' ])) {
                return $this->ToLogin( true );
            }
            $this->ToLogin(false);
        }
        
        private function createSession($user){
            session_start();
            $_SESSION['id'] = $user["user_id"];
            $_SESSION[ "firstName" ] = $user[ "first_name" ];
            $_SESSION[ "lastName" ] = $user[ "second_name" ];
            $_SESSION[ "email" ] = $user[ "email_address" ];
            $_SESSION[ "address" ] = $user[ "home_address" ];
            $_SESSION[ "username" ] = $user[ "username" ];
            session_write_close();
        }
        
        private function ToLogin($success) {
            if ($success){
                $this->createSession( $this->user);
                header( 'location: ../userPage.php' );
            } else {
                header( 'location: ../login.php?error' );
            }
        }
    }
    
    new Login($_POST);
    
