<?php

class ItemUpload extends DBConnection{

    private $itemName, $itemPrice, $deliveryCost, $shortDescription, 
            $fullDescription, $keywords, $condition, $isAuction;
    private $nameSound, $keywordSound;
    private $sqlSaleDetails, $sqlSaleSound, $sqlAuction;
    
    
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

    }

    private function setupSQLStrings(){
        //NOTE none of these statements are complete
        
        $sqlSaleDetails = "INSERT INTO items (item_name) VALUES (:itemName)";
        $sqlSaleSound = "INSERT INTO sounds (item_sound, keyword_sound) VALUES (:itemSound, :keywordSound)";
        
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
            $PDOConnection->execute(array('item_name'=>$this->itemName));
            //prepare and execute the statment for the item sound
            $PDOConnection->prepare($this->sqlSaleSound);
            $PDOConnection-execute(array(':itemSound'=>$this->nameSound,":keywordSound"=>$this->keywordSound));
            //if the sale is an auction then prepare and execute the statement for an auction
            if($this->isAuction){
                $PDOConnection->prepare($this->sqlAuction);
                $PDOConnection->execute(array(/*need to setup statement first*/));
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