<?PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    abstract class DBConnection{
        private $config;
        private $PDOConnection;
        
        //force implementation of function through abstraction
        //think of this as an interface with some base functionality already implemented
        abstract protected function validateAndSanitize();

        //NOTE these functions should be converted to private after begingTransaction has been implemented into search and registration scripts
        public function connectionSetup(){
            $this->config =parse_ini_file('../Config.ini');

            try{
            $this->PDOConnection = new PDO("mysql:host=".$this->config['dburl']."; dbname=".$this->config['dbname'],$this->config['username'], $this->config['password']);
                $this->PDOConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo $e->getMessage();
                die("ded");
            }
        }

        public function getConnection(){
            return $this->PDOConnection;
        }
        
        public function beginQuery($query, $keyValPairArr){
            //this function will be used to send querys to the database all the developer will have to do is
            //supply the function with a valid query and a valid key value pair array
            try{
                $this->connectionSetup();
                //$this->PDOConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->PDOConnection->prepare($query);
                $this->PDOConnection->execute($keyValuePairArr);
                return $this->PDOConnection->fetchALL(PDO::FETCH_ASSOC);
            }catch(Exception $e){
                die("Something has gone wrong when trying to query the database: " . $e->getMessage());
            }
        }

        public function conductTransaction($query, $keyValPairArr){

        }
        
    }
    
    /*
    
    how to connect to the database and send querys
    in your own script via this script using PDO
    step 1: include this script in top of file
    
    include("DBConnection.php");
    
    step 2: inherit this scripts class
    
    class ClassName extends DBConnection
    
    step 3: call connectionSetup() function and save in variable 
    via the getConnection() function
    
    $this->connectionSetup();
    $conectionVar = $this->getConnection();
    
    step 4: next prepare your sql statement
    
    $connectionVar->prepare("SELECT * FROM items WHERE itemName = :nameKeyword AND item_price > :priceKeyword");
    
    the :nameKeyword and the priceKeyword are your personal keywords like variable names
    you will see why soon but they are essentially equal to the ? symbol in a mysqli prepared statement
    the only difference is you name them yourself
    
    step 5: now you can execute your query and input the users data
    
    $connectionVar->execute(array('nameKeyword'=>$userInput, 'priceKeyword'=$userInput);
    
    step 6: get your results
    
    $resultsArr = $connectionVar->fetchALL(PDO::FETCH_ASSOC);
    
    after all this you can use your data in what ever mannor you want
    
    
    */
?>