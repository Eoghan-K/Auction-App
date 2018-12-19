<?PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    abstract class DBConnection{
        private $config;
        private $PDOConnection;
        private $configPath = "../Config.ini";
        //force implementation of function through abstraction
        //think of this as an interface with some base functionality already implemented
        abstract protected function validateAndSanitize();

        //NOTE these functions should be converted to private after begingTransaction has been implemented into search and registration scripts
        private function connectionSetup(){
            $this->config =parse_ini_file($this->configPath);

            try{
                $this->PDOConnection = new PDO("mysql:host=".$this->config['dburl']."; dbname=".$this->config['dbname'],$this->config['username'], $this->config['password'],
                array(PDO::ATTR_PERSISTENT => true ));
                $this->PDOConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "Connection status: " . $e->getCode() . " Connection error message: " . $e->getMessage();
                die("The Connection to the database failed");
            }
        }

        public function getConnection(){
            if(!isset($this->PDOConnection)){
                $this->connectionSetup();
            }

            return $this->PDOConnection;
        }

        public function updatePath($path){
            //getting the root directory using phps funcions like __dir__ react differently in localhost and hosted on a server
            //so this is my cheap function, if I remember to change this when hosted I will
            $this->configPath = $path;
        }
        //might make another class to be used as a helper class to handle things like 
        //getting strings from config and maybe write errors to an error log
        //as code like this does not belong here
        public function getVarFromConfig($var){
            //I am using a method for this rather than 
            //directly parsing the config in needed classes as I can restrict access and
            //I figure if a php scripts prints its self to the screen at least the location of the config will be kept secret 
            if(isset($var) && $var !== null && $var !== ""){
                switch($var){
                    case "SoSalty":
                    return $this->config['salt'];
                    break;
                }
            }
        }
        
        //is used to send querys to the database all the developer has to do is
        //supply the function with a valid query and a valid key value pair array
        public function beginQuery($query, $keyValPairArr, $fetch = true){
            //check the values are valid
            if(isset($query) && isset($keyValPairArr) && $query !== null && $query !== "" && $keyValPairArr !== null){
                //setup the connection the the database
                $this->getConnection();
                //try connect query the database if fails catch the error and print to screen 
                try{
                    //prepare the statement sent to the funcion
                    $query = $this->PDOConnection->prepare($query);
                    //execute the query with the array of values sent to the function
                    $query->execute($keyValPairArr);
                    //get all the results and return
                    if($fetch){
                        return $query->fetchALL(PDO::FETCH_ASSOC);
                    }else{
                        return true;
                    }
                }catch(PDOException $e){
                    //NOTE these errors will eventually have to be moved to an error log
                    die("Something has gone wrong when trying to query the database: " . $e->getMessage());
                }
            }else{
                die("not all parameters were set please ensure your script is setup correctly");
            }
        }

        public function conductTransaction($query, $keyValPairArr){
            //this will be used for complex sql transactions 
            //that simple querys cannot solve
        }
        
    }
?>