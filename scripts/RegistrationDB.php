<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("DBConnection.php");
/*
    TODO when html pages are setup must redirection to pages upon success or failure 
    incorperating any errors into the design 
*/

class Registration extends DBConnection{
    private $firstName,$secondName,$username;
    private $password;
    private $homeAddress, $emailAddress, $phoneNumber, $postCode;
    private $sql;
    private $PDOConnection;
    private $config;
    
    
    public function __construct(){
        //ensure all user posted data is safe to store in database
        $stringArr = $this->sanitizeVariables();
        //create sql statement
        $this->sql = "INSERT INTO user (firstname, secondname, username) VALUES (:firstname, :secondname, :username)";
        $this->config = parse_ini_file('../Config.ini');
        
    }

    private function sanitizeVariables(){
        //before bothering to even clean the items
        $this->checkAndCleanString($_POST['firstname']);
        $this->checkAndCleanString($_POST['secondname']);
        $this->checkAndCleanString($_POST['username']);
        //$this->checkVar($_POST['password']);
        //$this->checkVar($_POST['email']);
        //$this->checkVar($_POST['homeAddress']);
        //$this->checkVar($_POST['postCode']);
        
        //this method cleans variables of illegal Chars
        //begin filering strings
        //$this->firstName = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
        //$this->secondName = filter_var($_POST['secondname'], FILTER_SANITIZE_STRING);
        //$this->username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        //$this->password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        //$this->emailAddress = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        //$this->homeAddress = filter_var($_POST['homeAddress'], FILTER_SANITIZE_STRING);
        //$this->postCode = filter_var($_POST['postCode'], FILTER_SANITIZE_STRING);
        
        //stripslashes($data)
       
        
         //hash and salt password using blowfish crypt
        $this->password = crypt($this->password, $this->config['salt']);
    }

    private function checkAndCleanString($var){

        if($var === null || $var === ""){
            die("data was null");
        }
        echo "unfiltered " . $var;
        //I want to use this method to clean vars aswell but I cannot get filter_input to work so I might just use it to check if null
        echo "filtered " . filter_input(INPUT_POST, $var, FILTER_SANITIZE_STRING);
        //return $var;
    }

    public function beginTransaction(){
        //this function pushes data to the database
        //setup connection
        $this->connectionSetup();
        //get connection previously setup
        $this->PDOConnection = $this->getConnection();
        try{
            //prepare statement
            $query = $this->PDOConnection->prepare($this->sql);
            //bind variables to sql statement and execute statement
            //$query->execute(array('firstname'=>$this->firstName, 'secondname'=>$this->secondName, 'username'=>$this->username));
        }catch(PDOException $e){
            //WHEN something fails report it
            echo("The query failed: " . $e->getMessage());
        }
        
    }



}
//NOTE:might call this from the page that made the request 
//as it makes no sense to call from here
//create new registration
$userDetails = new Registration();
//begin the transaction
$userDetails->beginTransaction();
?>
