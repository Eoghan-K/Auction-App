<?php

class ItemUpload extends DBConnection{

    private $itemName, $itemPrice, $deliveryCost, $shortDescription, 
            $fullDescription, $keywords, $condition, $isAuction;
    private $nameSound, $keywordSound;
    private $sqlSaleDetails, $sqlSaleSound, $sqlAuction;
    
    //NOTE should get this from session when session script is complete
    private $sellerID;
    
    public function __construct(){
        $this->getAndSanitizeVars();
        $this->nameSound = metaphone($this->itemName);
        $this->keywordSound = metaphone($this->keywords);

    }

    private function getAndSanitizeVars(){
        $this->itemName = validateAndSanitize($_POST['item_name']);
        $this->itemPrice = validateAndSanitize($_POST['item_price'], 'double');
        $this->deliveryCost = validateAndSanitize($_POST['delivery_price'], 'double');
        $this->shortDescription = validateAndSanitize($_POST['short_description']);
        $this->fullDescription = validateAndSanitize($_POST['full_description']);
        $this->keywords = validateAndSanitize($_POST['keywords']);
        $this->condition = validateAndSanitize($_POST['condition']);
        //TODO get seller id from session

    }

    private function setupSQLStrings(){
        //create function to insert the actual item
        $sqlSaleDetails = "INSERT INTO item (item_name, item_keywords, item_short_description, item_description, starting_price, delivery_cost, seller_id) 
                    VALUES (:itemName, :itemKeywords, :itemShortDescription, :itemFullDescription, :startingPrice, :deliveryCost, :sellerID)";
        //create query to insert sounds related to the actual item
        $sqlSaleSound = "INSERT INTO item_sounds (item_name_sounds, keyword_sounds, item_id) VALUES (:itemSound, :keywordSound, :itemID)";
        //create query to insert auction details if the actual item is an auction
        $sqlAuction = "INSERT INTO auctions (item_id, current_offer) VALUES (:itemID, :startingPrice)";
    }

    private function startTransaction(){
        $PDOConnection;
        try{
            //start and get connection
            $this->connectionSetup();
            $PDOConnection = $this->getConnection();
            //begin the transaction
            $PDOConnection->beginTransaction();
            //prepare and execute the statement for the item details
            $PDOConnection->prepare($this->sqlSaleDetails);
            $PDOConnection->execute(array('itemName'=>$this->itemName, 'itemKeywords'=>$this->keywords, 'itemShortDescription'=>$this->shortDescription, 
            'itemFullDescription'=>$this->fullDescription, 'startingPrice'=>$this->itemPrice, 'deliveryCost'=>$this->deliveryCost, 'sellerID'=>$this->sellerID));
            //get the ID of the table we are trying to commit
            $itemID = $PDOConnection->lastInsertId();
            //prepare and execute the statment for the item sound
            $PDOConnection->prepare($this->sqlSaleSound);
            $PDOConnection-execute(array('itemSound'=>$this->nameSound, 'keywordSound'=>$this->keywordSound, 'itemID'=>$itemID));
            //if the sale is an auction then prepare and execute the statement for an auction
            if($this->isAuction){
                $PDOConnection->prepare($this->sqlAuction);
                $PDOConnection->execute(array('itemID'=>$itemID, 'startingPrice'=>$this->itemPrice));
            }

            $PDOConnection->commit();
        }catch(Exception $e){
            $PDOConnection->rollBack();
        }
        
    }

    protected function validateAndSanitize($var = null, $type = "string"){

        if(!isset($var) && $var === null && $var === ""){
            die("variable was not set");
        }

        if($type === 'double'){
            //find filter for double
        }else if($type === 'string'){
            return filter_var($var, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        }else{
            die('this variable type has not yet been setup for filtering and validation');
        }
    }
}

?>