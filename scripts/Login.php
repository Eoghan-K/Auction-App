<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("DBConnection.php");

class Login extends DBConnection{
  private $PDOConnection;
  private $email;
  private $password;

  public function __construct($data){
    $this->config =parse_ini_file('../Config.ini');

    try{
        $this->PDOConnection = new PDO("mysql:host=".$this->config['dburl']."; dbname=".$this->config['dbname'],$this->config['username'], $this->config['password'],
        array(PDO::ATTR_PERSISTENT => true ));
        $this->PDOConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Connection status: " . $e->getCode() . " Connection error message: " . $e->getMessage();
        die("The Connection to the database failed");
    }

    foreach($data as $key => $value){
      $this->$key = $value;
    }

    $user = $this->findUser($this->email);
    if ($user) {
      $this->authenticate($this->password, $user['user_password']);
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
      // TODO: create user session
      header( 'Location: userPage.php' );
    } else {
      header( 'Location: login.php' );
    }
  }

  protected function validateAndSanitize(){
    // TODO: validate user input
  }

}

$login = new Login($_POST);

?>
