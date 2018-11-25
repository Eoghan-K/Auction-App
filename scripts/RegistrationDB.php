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
    private $passwordVal;
    private $homeAddress, $emailAddress, $phoneNumber, $postCode;
    private $sql;
    private $PDOConnection;
    private $config;
    
    
    public function __construct(){
        $this->config = "SoSalty";
        //ensure all user posted data is safe to store in database
        $stringArr = $this->validateAndSanitize();
        //create sql statement
        //alias being used because password seems to be a sql keyword
        $this->sql = "INSERT INTO users (first_name, second_name, username, user_password, email_address, home_address, post_code, phone_number)
                    VALUES (:firstname, :secondname, :username, :passwordVal, :email, :homeAddress, :postCode, :phoneNumber)";
        //these are the values related to the sql query all stored in an array for transportation
        $values = array('firstname'=>$this->firstName, 'secondname'=>$this->secondName, 'username'=>$this->username, 'passwordVal'=>$this->passwordVal, 
        'email'=>$this->emailAddress, 'homeAddress'=>$this->homeAddress, 'postCode'=>$this->postCode, 'phoneNumber'=>$this->phoneNumber);
        
        if(!$this->beginQuery($this->sql, $values, false)){
            $arr['message'] = 'success';
            return json_encode($arr);
        }

    }

    protected function validateAndSanitize(){
        //check that variables actually exist and if so clean them
        $this->firstName = $this->checkAndCleanString($_POST['firstname']);
        $this->secondName = $this->checkAndCleanString($_POST['secondname']);
        $this->username = $this->checkAndCleanString($_POST['username']);
        $this->passwordVal = $this->checkAndCleanString($_POST['password']);
        $this->emailAddress =$this->checkAndCleanString($_POST['email'], "email");
        $this->homeAddress = $this->checkAndCleanString($_POST['homeAddress']);
        $this->postCode = $this->checkAndCleanString($_POST['postCode']);
        $this->phoneNumber = $this->checkAndCleanString($_POST['phoneNumber'], "phone number");

        //hash and salt password using blowfish crypt
        $this->passwordVal = crypt($this->passwordVal, $this->getVarFromConfig($this->config));//$this->config['salt']);
    }

    //this function checks if null or empty and if not then proceeds to clean variables of potentially dangerious chars
    private function checkAndCleanString($var, $type = "simpleString"){

        if($var === null || $var === ""){
            //TODO redirect to registration page and inform the user to fill in missing data
            
            exit("data was null");
        }
        $var = stripslashes($var);
        //I want to use this method to clean vars aswell but I cannot get filter_input to work so I might just use it to check if null
        if($type === "email"){
            if(filter_var($var, FILTER_VALIDATE_EMAIL)){
                $var = filter_var($var, FILTER_SANITIZE_STRING, FILTER_SANITIZE_EMAIL);
                $var = filter_var($var, FILTER_VALIDATE_EMAIL);
                return $var;
            }
        }else if($type === "phone number"){
            if(filter_var($var, FILTER_VALIDATE_INT)){
                $var = filter_var($var, FILTER_SANITIZE_NUMBER_INT);
                return $var;
            }
        }else{
            $var = filter_var($var, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            return $var;
        }
        
        //if($var === false || $var === ""){
            //TODO redirect to page telling user to enter valid data
            exit("please enter valid data: " . $type . " " . $var);  
        //}
        
    }

}
//NOTE:might call this from the page that made the request 
//as it makes no sense to call from here
//create new registration
$userDetails = new Registration();

?>
