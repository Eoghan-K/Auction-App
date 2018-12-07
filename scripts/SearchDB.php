<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("DBConnection.php");


class SearchDB extends DBConnection{

    private $originalData, $data, $dataDecon, $dataSound;
    private $filteredResults, $allResultsIDs, $countItems;
    private $sqlSearchSound, $sqlSearchString, $sqlAllDetails, $sqlAllImages;
    private $isGrid;

    public function __construct(){
        
        //the below Request is to test if I can get this to work with AJAX
        //if works dont forget to sanitize string
        $data = $_GET['query'];
        $this->isGrid = $_GET['grid'];
        
        if(isset($data) && $data !== null){
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
            //create the statements for future use
            $this->createSqlStatements();
            //below is a test to see if I can get this to work with AJAX
            $this->commenceSearch();
        }else{
            //should never get this far if error checking is done on page to ensure nothing is executed if nothing is entered
            echo "<h2>searches must be more than 2 letters long</h2>";
        }
    }
    
    private function createSqlStatements(){
        //NOTE all sql statements need to be optimized, will do once presentation is over and done with
        //create sql statement for strings with original values
        //select necessary fields from item if the item name or keywords match (in some way (contains wildcards)) to the users input
        $this->sqlSearchString = "SELECT i.item_id, i.item_name, i.item_short_description, i.date_listed, i.auction_id, i.delivery_cost, img.image_url, img.image_name,
        CASE WHEN auction_id > 0 
        THEN (SELECT a.current_offer FROM auctions AS a WHERE i.auction_id = a.auction_id) 
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
        
        /* this sql statement gets the rest of the items details that were excluded from previous request,
            inorder to save space and request times the user will have to select an item to request further data 
            from the server details like item description, seller details 
            and any extra images the users has supplied.
            These details can be quite large especially when the user could have 100s-1000s of results
            so requesting them only when needed will save space and hopefully reduce request times.
            NB inorder to keep MYSQL happy we have grouped by image item ids but the grouping is not important.
        */
        $this->sqlAllDetails = "SELECT i.item_description, img.item_images_id, img.image_name, img.image_url, seller.user_id, seller.username, AVG(userRating.rating) AS rating
        FROM item AS i
        JOIN users AS seller ON i.seller_id=seller.user_id
        JOIN user_rating  AS userRating ON i.seller_id = userRating.user_id
        JOIN item_images AS img ON i.item_id=img.item_id
        WHERE i.item_id = :input GROUP BY img.item_images_id";
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
            
            echo json_encode($this->filteredResults);
        }else{
            /*
                TODO check this before sending user to this script
                if user somehow ends up on this script
                redirect back to original page and display error
            */
            echo "<h2>searches must be more than 2 letters long</h2>";
        }
    }
    
    private function queryDB($value, $type){
        $query;
        
        switch($type){
            case 'string':
                $sql = $this->sqlSearchString;
                break;
            case 'sound':
                $sql = $this->sqlSearchSound;
                break;
            case 'missingDetails':
                $sql = $this->sqlAllDetails;
                break;
        }
        
        $results = $this->beginQuery($sql,array('input'=>$value));
        
        $this->inspectAndCompileResults($results,$type);
    }
    
    private function inspectAndCompileResults($results, $type){
        //no need to keep track of images so store a temp var here
        $image_ids = array();
        if(!isset($results) || !isset($type)){
            exit("SearchDB: please ensure all data has been passed to function");
        }

        if($type !== 'missingDetails'){
            //this function filters out any redundant entries and compiles results into one array
            foreach($results as $key=>$val){
                if(!in_array($val['item_id'], $this->allResultsIDs)){
                    //add item id to the allResultsIDs inoreder to keep track of what has already been added
                    Array_Push($this->allResultsIDs, $val['item_id']);
                    //inserting array inside of array of givin index
                    $this->filteredResults[$this->countItems] = array();
                    
                    //clean all variables to ensure nothing malicious made it into the database and store all items in array with a key
                    $this->filteredResults[$this->countItems]['item_id'] = $val['item_id'];
                    $this->filteredResults[$this->countItems]['item_name'] = $this->validateAndSanitize($val['item_name']);
                    $this->filteredResults[$this->countItems]['short_description'] = $this->validateAndSanitize($val['item_short_description']);
                    $this->filteredResults[$this->countItems]['date'] = $val['date_listed'];
                    $this->filteredResults[$this->countItems]['auction_id'] = $val['auction_id'];
                    $this->filteredResults[$this->countItems]['image_name'] = $this->validateAndSanitize($val['image_name']);
                    //image url is not an actual url so clean it as if it was a normal string
                    $this->filteredResults[$this->countItems]['image_url'] = $this->validateAndSanitize($val['image_url']);
                    $this->filteredResults[$this->countItems]['price'] = $val['starting_price'];
                    $this->filteredResults[$this->countItems]['deliveryCount'] = $val['delivery_cost'];
                    //increase the index
                    $this->countItems++;
                }
            }
        }else{
            //NOTE might actually split querys and get images seperatly but the most images that will return is 4 so it may be unnecessary 
            //this should only have one valid result
           $this->filteredResults[0]['full_description'] = $this->validateAndSanitize($val['item_description']);
           $this->filteredResults[0]['seller_id'] = $val['user_id'];
           $this->filteredResults[0]['seller_name'] = $this->validateAndSanitize($val['username']);
           $this->filteredResults[0]['rating'] = $val['rating']; 
           //there could be multiple images related to the one item
           foreach($results as $key=>$val){
                if(!in_array($val['image_id'], $image_ids)){
                    Array_Push($image_ids, $val['image_id']);
                    //get all images 
                    $this->filteredResults[$this->countItems]['image_id'] = $val['item_images_id'];
                    $this->filteredResults[$this->countItems]['image_name'] = $this->validateAndSanitize($val['image_name']);
                    $this->filteredResults[$this->countItems]['image_url'] = $this->validateAndSanitize($val['image_url']);
                    $this->countItems++;
            }
           }
        }
    }
    
    //this function checks if null or empty and if not then proceeds to clean variables of potentially dangerious chars
    protected function validateAndSanitize($var = null){

        if($var === null || $var === ""){
            //TODO redirect to registration page and inform the user to fill in missing data
            die("data was null");
        }
        
        //I want to use this method to clean vars aswell but I cannot get filter_input to work so I might just use it to check if null
        $var = filter_var($var, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        $var = stripslashes($var);

        if($var === false || $var === ""){
            //TODO redirect to page telling user to enter valid data
            die("please enter valid:" + $type);  
        }
        return $var;
    }

}

$newS = new SearchDB();
?>