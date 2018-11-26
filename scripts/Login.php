<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("DBConnection.php");

class Login extends DBConnection{

  public function __construct($data){
    foreach($data as $key => $value){
      $this->$key = $value;
    }
  }

  protected function validateAndSanitize(){}

}

$login = new Login($_POST);

?>
