<?PHP
    class DBConnection{
        private $config;
        private $PDOConnection;

        public function connectionSetup(){
            $this->config =parse_ini_file('../Config.ini');

            try{
            $this->PDOConnection = new PDO("mysql:host=".$this->config['dburl']."; dbname=".$this->config['dbname'],$this->config['username'], $this->config['password']);
                $this->PDOConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo $e->getMessage();
                die();
            }
        }

        public function getConnection(){
            return $this->PDOConnection;
        }
    }
?>