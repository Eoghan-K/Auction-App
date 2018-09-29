<?php
include("DBConnection.php");
/*
    TODO when html pages are setup must redirection to pages upon success or failure 
    incorperating any errors into the design 
*/

class Registration extends DBConnection{
    private $firstName,$secondName,$username;
    private $homeAddress, $emailAddress, $phoneNumber, $postCode;
    private $sql;
    private $PDOConnection;
    
    
    public function __construct(){
        //ensure all user posted data is safe to store in database
        $stringArr = $this->sanitizeVariables();
        //create sql statement
        $this->sql = "INSERT INTO user (firstname, secondname, username) VALUES (:firstname, :secondname, :username)";
        
    }

    public function sanitizeVariables(){
        //this method cleans variables of illegal Chars
        //begin filering strings
        $this->firstName = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
        $this->secondName = filter_var($_POST['secondname'], FILTER_SANITIZE_STRING);
        $this->username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $this->checkVar($this->firstName);
        $this->checkVar($this->secondName);
        $this->checkVar($this->userName);
    }

    function checkVar($var){

        if($var === null || $var === ""){
            die("data was null");
        }
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
            $query->execute(array('firstname'=>$this->firstName, 'secondname'=>$this->secondName, 'username'=>$this->username));
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
