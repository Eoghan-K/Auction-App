<?php
include("DBConnection.php");

class SellItemDB extends DBConnection{

    private $itemName, $itemPrice, $deliveryCost, $shortDescription, 
            $fullDescription, $keywords, $condition, $isAuction;
    private $nameSound, $keywordSound;
    private $sqlSaleDetails, $sqlSaleSound, $sqlAuction, $sqlUpdateImage, $sqlUpdatsSale;
    private $imageDetails;
    private $imagesPresent;
    private $response;
    private $uploaded;
    //NOTE should get this from session when session script is complete
    private $sellerID;
    
    public function __construct(){
        $this->uploaded = false;
        $this->response = 'never set';
        
        session_start();
        $this->sellerID = $_SESSION['id'];
        $this->isAuction = $_POST['isAuction'];
        //check, clean and set variables
        $this->getAndSanitizeVars();
        $this->nameSound = metaphone($this->itemName);
        $this->keywordSound = metaphone($this->keywords);
        //set sql query strings
        $this->setupSQLStrings();
    }

    public function processRequest(){
        //if user is logged in proceed else return error
        if(isset($this->sellerID) && $this->sellerID > 0){
            if(isset($_POST['imageDetails'])){
                $this->imagesPresent = true;
                //this should contain an array of elements
                $this->imageDetails = json_decode($_POST['imageDetails'], true);
            }else{
                $this->imagesPresent = false;
            }
         
            $this->startTransaction();
            $arr['imageUploaded'] = $this->imageDetails[0]['message'];
            $arr['message'] = $this->response;
            echo json_encode($arr);
        }else{
            $arr['message'] = "NotLoggedIn";
            echo json_encode($arr);
        }
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
       
    }

    private function setupSQLStrings(){
        //create function to insert the actual item
        $this->sqlSaleDetails = "INSERT INTO item (item_name, item_keywords, item_short_description, item_description, starting_price, delivery_cost, seller_id) 
                    VALUES (:itemName, :itemKeywords, :itemShortDescription, :itemFullDescription, :startingPrice, :deliveryCost, :sellerID)";
        //create query to insert sounds related to the actual item
        $this->sqlSaleSound = "INSERT INTO item_sounds (item_name_sounds, keyword_sounds, item_id) VALUES (:itemSound, :keywordSound, :itemID)";
        //create query to insert auction details if the actual item is an auction
        $this->sqlAuction = "INSERT INTO auctions (item_id, current_offer) VALUES (:itemID, :startingPrice)";
        //this query updates the images related to the sale I did not want a long concurrent query so this is my chosen method
        $this->sqlUpdateImage = "UPDATE item_images SET item_id = :saleId ,image_url = :imageUrl WHERE item_images_id = :id";
        //update sales details with the auction id
        $this->sqlUpdatsSale = "UPDATE item SET auction_id = :aucId WHERE item_id = :itemId";
    }

    private function startTransaction(){
        $PDOConnection;
        $query;
        try{
            //even though the connection maybe set we should still get a fresh version of the 
            //connection to ensure the variable has not been altered
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
            
            //if images have been uploaded update the database to reflect this
            if($this->imagesPresent){
                $count = sizeof($this->imageDetails);
                
                for($i = 0; $i < $count; $i++){
                    //(saleID,image_url) VALUES(:saleId, :imageUrl) WHERE item_images_id = :id";
                    $imageName = $this->imageDetails[$i]['imageName'];
                    $imageId = $this->imageDetails[$i]['id'];
                    $query = $PDOConnection->prepare($this->sqlUpdateImage);
                    $query->execute(array('saleId'=>$itemID, 'imageUrl'=>$imageName, 'id'=>$imageId));
                }
                $this->uploaded = true;
            }

            //if the sale is an auction then prepare and execute the statement for an auction
            if($this->isAuction){
                //prepare and execute sqlauction query
                $query = $PDOConnection->prepare($this->sqlAuction);
                $query->execute(array('itemID'=>$itemID, 'startingPrice'=>$this->itemPrice));
                //get last inserted id
                $aucId = $PDOConnection->lastInsertId();
                //prepare and execute sqlUpdateSale
                $query = $PDOConnection->prepare($this->sqlUpdatsSale);
                $query->execute(array('aucId'=>$aucId, 'itemId'=>$itemID));
            }

            $PDOConnection->commit();
            $this->response = 'success';
            //need a page to redirect to
        }catch(PDOException $e){
            $PDOConnection->rollBack();
            //after rollback we must remove the images and related rows in the table
            $this->response = "rolled back: " . $e->getMessage();
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
$upload = new SellItemDB();
$upload->processRequest();
?>