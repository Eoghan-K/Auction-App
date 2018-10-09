<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("DBConnection.php");

class SearchDB extends DBConnection{

    private $originalData, $data, $dataDecon, $dataSound;
    private $filteredResults, $allResultsIDs, $countItems;
    private $PDOConnection;
    private $sqlSearchSound, $sqlSearchString, $sqlAllDetails;

    public function __construct($data){
        $this->countItems = 0;
        //originalData is the data unaltered
        $this->originalData = $data;
         //add wildcards to the data string
        $this->data = '%' . $data . '%';
        //sound out the entire string (must do this before adding wildcards to the data string)
        $this->dataSound = "%" . metaphone($this->originalData) . "%";
        //split the string up into individual words if there are multiple (must do this before adding wildcards to data string)
        $this->dataDecon = explode(" ", $this->originalData);
       
        //setup arrays to store results
        $this->allResultsIDs = array();
        $this->filteredResults = array();
        //create and get the connection to database
        $this->connectionSetup();
        $this->PDOConnection = $this->getConnection();
        $this->PDOConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //create the statements for future use
        $this->createSqlStatements();
    }
    
    private function createSqlStatements(){
        //create sql statement for strings with original values
        //select necessary fields from item if the item name or keywords match (in some way (contains wildcards)) to the users input
        $this->sqlSearchString = "SELECT i.item_id, i.item_name, i.item_short_description, i.date_listed, i.auction_id, img.image_url, img.image_name,
        CASE WHEN auction_id > 0 
        THEN (SELECT a.current_offer FROM auctions AS a WHERE auction_id = a.auction_id) 
        ELSE starting_price END AS starting_price
        FROM item AS i 
        JOIN item_images AS img ON i.item_id=img.item_id AND img.item_image_num=1 
        WHERE i.item_name LIKE :input OR i.item_keywords LIKE :input";
        //create sql statement for the sounds of the values the user sent
        //select necessary fields from item if the item name or keyword sound similar to the users input 
        $this->sqlSearchSound = 'SELECT i.item_id, i.item_name, i.item_short_description, i.date_listed, i.auction_id, img.image_url, img.image_name,
        CASE WHEN i.auction_id > 0 
        THEN (SELECT current_offer FROM auctions AS a WHERE auction_id = a.auction_id) 
        ELSE starting_price END AS starting_price 
        FROM item_sounds AS sound 
		JOIN item AS i ON sound.item_id=i.item_id
		JOIN item_images AS img ON i.item_id=img.item_id AND img.item_image_num=1
        WHERE sound.item_name_sounds LIKE :input OR sound.keyword_sounds LIKE :input';
        
        //this sql statement gets the rest of the items details that were excluded from previous request
        /*
            inorder to save space the user will have to select an item to request further data 
            from the server details like item description, seller details 
            and any extra images the users has supplied.
            These details can be quite large especially when the user could have 100s-1000s of results
            so requesting them only when needed will save space and hopefully reduce request times.
        */
        $this->sqlAllDetails = "SELECT i.item_description, img.item_images_id, img.image_name, img.image_url, seller.user_id, seller.username
        FROM item AS i 
        JOIN users AS seller ON i.seller_id=seller.user_id
        JOIN item_images AS img ON i.item_id=img.item_id
        WHERE i.item_id = :input";
    }

    public function commenceSearch(){
        //if the string length is greater than 2 then begin search
        //otherwise ask user to enter a valid search (something with more than 2 letters)
        if(strlen($this->originalData) > 2){
            //begin searching for whole string
            $this->queryDB($this->data, 'string');
            $this->queryDB($this->dataSound, 'sound');
            //if the array contains more than one value then begin
            if(count($this->dataDecon) > 1){
                //begin itterating through array containing the exploded value
                foreach($this->dataDecon as $val){
                    //convert value to a sound and add wild cards
                    $valSound = '%' . metaphone($val) . '%';
                    //begin searching for individual values
                    $this->queryDB($val, 'string');
                    $this->queryDB($valSound, 'sound');
                }
            }
            
            return json_encode($this->filteredResults);
        }else{
            /*
                TODO check this before sending user to this script
                if user somehow ends up on this script
                redirect back to original page and display error
            */
            echo "searches must be more than 2 letters long";
        }
    }
    
    private function queryDB($value, $type){
        $query;
        
        switch($type){
            case 'string':
                $query = $this->PDOConnection->prepare($this->sqlSearchString);
                break;
            case 'sound':
                $query = $this->PDOConnection->prepare($this->sqlSearchSound);
                break;
            case 'missingDetails':
                $query = $this->PDOConnection->prepare($this->sqlAllDetails);
                break;
        }
        
        $query->execute(array('input'=>$value));
        $results = $query->fetchALL(PDO::FETCH_ASSOC);
        //echo $results->rowCount();
        $this->inspectAndCompileResults($results,$type);
    }
    
    private function inspectAndCompileResults($results, $type){
        if(!isset($results) || !isset($type)){
            exit("SearchDB: please ensure all data has been passed to function");
        }
        //this function filters out any redundant entries and compiles results into one array
        foreach($results as $key=>$val){
            if(!in_array($val['item_id'], $this->allResultsIDs)){
                //add item id to the allResultsIDs inoreder to keep track of what has already been added
                Array_Push($this->allResultsIDs, $val['item_id']);
                //inserting array inside of array of givin index
                $this->filteredResults[$this->countItems] = array();
                
                if($type != 'missingDetails'){
                    //store all items in array with a key
                    $this->filteredResults[$this->countItems]['item_id'] = $val['item_id'];
                    $this->filteredResults[$this->countItems]['item_name'] = $val['item_name'];
                    $this->filteredResults[$this->countItems]['short_description'] = $val['item_short_description'];
                    $this->filteredResults[$this->countItems]['date'] = $val['date_listed'];
                    $this->filteredResults[$this->countItems]['auction_id'] = $val['auction_id'];
                    $this->filteredResults[$this->countItems]['image_name'] = $val['image_name'];
                    $this->filteredResults[$this->countItems]['image_url'] = $val['image_url'];
                    $this->filteredResults[$this->countItems]['price'] = $val['starting_price'];
                    $this->countItems++;
                }else{
                   
                }
                
            }
        }
    }
    

}

?>