<?PHP

include("DBConnection.php");

class Search extends DBConnection{

    private $originalData, $data, $dataDecon, $dataSound;
    private $allResults, $filteredResults;
    private $PDOConnection;
    private $sql;

    public function __construct($data){
        //clean the data before conducting search
        $this->originalData = filter_input(INPUT_POST,$data, FILTER_SANITIZE_STRING);
        $this->originalData = stripcslashes($this->data);
        //now that variable is clean store in data for further processing
        $this->data = $this->originalData;
        //sound out the entire string (must do this before adding wildcards to the data string)
        $this->dataSound = "%" . metaphone($this->data) . "%";
        //split the string up into individual words if there are multiple (must do this before adding wildcards to data string)
        $this->dataDecon = explode(" ", $this->data);
        //add wildcards to the data string
        $this->data = "%" . $this->data . "%";
        $this->allResults = array();
        $this->filteredResults = array();
        $this->connectionSetup();
        $this->PDOConnection = $this->getConnection();

    }

    private function commenceSearch(){
        if(strlen($this->originalData) > 2){
            $this->searchSounds($this->data);
            $this->searchSounds($this->dataSound);
        }else{
            /*
                TODO check this before sending user to this script
                if user somehow ends up on this script
                redirect back to original page and display error
            */
            echo "searches must be more than 2 letters long";
        }
    }

    private function searchString(){
        //this function searches for items names or keyword via unmodified values
    }

    private function searchSounds(){
        /*
            this function searches for items names or keywords
            via values that have been broken down into sounds. 
        */
    }


}













?>