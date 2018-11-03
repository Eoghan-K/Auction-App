<?php
include("DBConnection.php");

class SellItemDB extends DBConnection{

    private $itemName, $itemPrice, $deliveryCost, $shortDescription, 
            $fullDescription, $keywords, $condition, $isAuction;
    private $nameSound, $keywordSound;
    private $sqlSaleDetails, $sqlSaleSound, $sqlAuction, $sqlUploadImage;
    
    //NOTE should get this from session when session script is complete
    private $sellerID;
    
    public function __construct(){
        $this->getAndSanitizeVars();
        $this->nameSound = metaphone($this->itemName);
        $this->keywordSound = metaphone($this->keywords);
        $this->setupSQLStrings();
        $this->startTransaction();
    }

    private function getAndSanitizeVars(){
        //get all variables from the post and sanitize them
        $this->itemName = $this->validateAndSanitize($_POST['item_name']);
        $this->itemPrice = $this->validateAndSanitize($_POST['item_price'], 'double');
        $this->deliveryCost = $this->validateAndSanitize($_POST['delivery_price'], 'double');
        $this->shortDescription = $this->validateAndSanitize($_POST['short_description']);
        $this->fullDescription = $this->validateAndSanitize($_POST['full_description']);
        $this->keywords = $this->validateAndSanitize($_POST['keywords']);
        $this->condition = $this->validateAndSanitize($_POST['condition']);
        //TODO get seller id from session
        $this->sellerID = 1;
        $this->isAuction = true;
    }

    private function setupSQLStrings(){
        //create function to insert the actual item
        $this->sqlSaleDetails = "INSERT INTO item (item_name, item_keywords, item_short_description, item_description, starting_price, delivery_cost, seller_id, auction_id) 
                    VALUES (:itemName, :itemKeywords, :itemShortDescription, :itemFullDescription, :startingPrice, :deliveryCost, :sellerID, (SELECT MAX(auction_id)+1 FROM auctions))";
        //create query to insert sounds related to the actual item
        $this->sqlSaleSound = "INSERT INTO item_sounds (item_name_sounds, keyword_sounds, item_id) VALUES (:itemSound, :keywordSound, :itemID)";
        //create query to insert auction details if the actual item is an auction
        $this->sqlAuction = "INSERT INTO auctions (item_id, current_offer) VALUES (:itemID, :startingPrice)";
        //create query to insert the image details for the images pending to be uploaded
        $this->sqlUploadImage = "INSERT INTO MyBrain (knowledge) VALUES (:AbetterSystemThanTheOneInThereAlready)";
    }

    private function startTransaction(){
        $PDOConnection;
        $query;
        try{
            //start and get connection
            $this->connectionSetup();
            $PDOConnection = $this->getConnection();
            //begin the transaction
            $PDOConnection->beginTransaction();
            //prepare and execute the statement for the item details
            $query = $PDOConnection->prepare($this->sqlSaleDetails);
            $query->execute(array('itemName'=>$this->itemName, 'itemKeywords'=>$this->keywords, 'itemShortDescription'=>$this->shortDescription, 
            'itemFullDescription'=>$this->fullDescription, 'startingPrice'=>$this->itemPrice, 'deliveryCost'=>$this->deliveryCost, 'sellerID'=>$this->sellerID));
            //get the ID of the table we are trying to commit
            $itemID = $PDOConnection->lastInsertId();
            //prepare and execute the statment for the item sound
            $query = $PDOConnection->prepare($this->sqlSaleSound);
            $query->execute(array('itemSound'=>$this->nameSound, 'keywordSound'=>$this->keywordSound, 'itemID'=>$itemID));
            //if the sale is an auction then prepare and execute the statement for an auction
            if($this->isAuction){
                $query = $PDOConnection->prepare($this->sqlAuction);
                $query->execute(array('itemID'=>$itemID, 'startingPrice'=>$this->itemPrice));
            }

            $PDOConnection->commit();
            //need a page to redirect to
        }catch(Exception $e){
            $PDOConnection->rollBack();
            echo "rolled back: " . $e;
            //redirect to another page and display error
        }
        
    }

    protected function validateAndSanitize($var = null, $type = "string"){

        if(!isset($var) || $var === null || $var === ""){
            die("variable was not set");
        }

        if($type === 'double'){
            //find filter for double
            return $var;
        }else if($type === 'string'){
            return filter_var($var, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        }else{
            die('this variable type has not yet been setup for filtering and validation');
        }
    }
}
$upload = new ItemUpload();
?>