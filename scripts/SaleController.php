<?php
include("DBConnection.php");

class SaleController extends DBConnection{

    //item variables 
    private $itemName, $itemPrice, $deliveryCost, $shortDescription, 
            $fullDescription, $keywords, $condition, $isAuction;
    private $nameSound, $keywordSound, $endDate;
    private $imageDetails, $imagesPresent, $uploaded;
    //variables for querys related to item sale insertion
    private $sqlSaleDetails, $sqlSaleSound, $sqlAuction, $sqlUpdateImage, $sqlUpdatsSale;
    //variables for querys related to item sale deletion
    private $sqlChkOwnership, $sqlDeleteSale, $sqlDeleteBids, $sqlDeleteAuctions, $sqlDeleteImages, $sqlDeleteSounds;
    //variables for querys related to item sale updates
    private $sqlSelectItem, $sqlUpdateDetails, $sqlUpdateSounds, $sqlUpdateAuction;
    //response variable
    private $response;
    //current logged in user variable
    private $sellerID;
    
    public function __construct(){
        $this->uploaded = false;
        $this->response = 'never set';
        session_start();
        $this->sellerID = $_SESSION['id'];
        
        //set sql query strings
        $this->setupSQLStrings();
    }

    

    

    private function setupSQLStrings(){
        //create function to insert the actual item
        //TODO FORGOT TO ADD ITEM CONDITION also need to add expiry date
        $this->sqlSaleDetails = "INSERT INTO item (item_name, item_keywords, item_short_description, item_description, starting_price, delivery_cost, seller_id) 
                    VALUES (:itemName, :itemKeywords, :itemShortDescription, :itemFullDescription, :startingPrice, :deliveryCost, :sellerID)";
        //create query to insert sounds related to the actual item
        $this->sqlSaleSound = "INSERT INTO item_sounds (item_name_sounds, keyword_sounds, item_id) VALUES (:itemSound, :keywordSound, :itemID)";
        //create query to insert auction details if the actual item is an auction
        $this->sqlAuction = "INSERT INTO auctions (item_id, current_offer, End_date) VALUES (:itemID, :startingPrice, :endDate)";
        //this query updates the images related to the sale I did not want a long concurrent query so this is my chosen method
        $this->sqlUpdateImage = "UPDATE item_images SET item_id = :saleId ,image_url = :imageUrl WHERE item_images_id = :id";
        //update sales details with the auction id
        $this->sqlUpdatsSale = "UPDATE item SET auction_id = :aucId WHERE item_id = :itemId";
        
        //check if user actually owns the item before being allowed to preform any actions on the item
        $this->sqlChkOwnership = "SELECT CASE WHEN EXISTS(SELECT item.item_id FROM item JOIN users ON item.seller_id = users.user_id WHERE item.item_id = :itemId AND users.user_id = :sellerId) 
                                    THEN 1 ELSE 0 END AS isOwner";
        //sql query for deleting a sale and all related items
        //unfortunatlly sql does not support deleting from multiple tables at once
        $this->sqlDeleteBids = "DELETE bid FROM Bids bid JOIN auctions On auctions.auction_id = bid.auction_id WHERE auctions.item_id = :itemId";
        $this->sqlDeleteAuctions = "DELETE auctions FROM auctions WHERE item_id = :itemId";
        $this->sqlDeleteImages = "DELETE item_images FROM item_images WHERE item_id = :itemId";
        $this->sqlDeleteSounds = "DELETE item_sounds FROM item_sounds WHERE item_id = :itemId";
        $this->sqlDeleteSale = "DELETE item FROM item WHERE item_id = :itemId";
        //select all columns from row where the item id and current logged in user id matches a table entry
        $this->sqlSelectItem = "SELECT * FROM item WHERE item_id = :itemId AND users.user_id = :sellerId";
        $this->sqlUpdateDetails = "UPDATE item SET item_name = :itemName, item_keywords = :itemKeywords, item_short_description = :shortDescription, 
        item_description = :fullDescription, starting_price = :price, delivery_cost = :deliveryCost WHERE item_id = :itemId";

        $this->sqlUpdateSounds = "UPDATE item_sounds SET item_name_sounds = :itemSound, keyword_sounds = :keywordsSound WHERE item_id = :itemId";
        //do not allow update if there has already been a bid placed on the item
        $this->sqlUpdateAuction = "UPDATE auctions SET current_offer = :price WHERE item_id = :itemId AND bidder_id IS NULL OR bidder_id = 0";
    }

    public function processSale(){
        $this->isAuction = $_POST['isAuction'];
        
        $this->nameSound = metaphone($this->itemName);
        $this->keywordSound = metaphone($this->keywords);
        //if user is logged in proceed else return error
        if(isset($this->sellerID) && $this->sellerID > 0){
            if(isset($_POST['imageDetails'])){
                $this->imagesPresent = true;
                //this should contain an array of elements
                $this->imageDetails = json_decode($_POST['imageDetails'], true);
            }else{
                $this->imagesPresent = false;
            }
         
            
            return "success";
        }else{
            
            return "NotLoggedIn";
        }
    }

    public function createSale(){
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
                //not even sure what I wanted this bool for
                $this->uploaded = true;
            }

            //if the sale is an auction then prepare and execute the statement for an auction
            if($this->isAuction){
                //prepare and execute sqlauction query
                $query = $PDOConnection->prepare($this->sqlAuction);
                $query->execute(array('itemID'=>$itemID, 'startingPrice'=>$this->itemPrice, 'endDate'=>$this->endDate));
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
        //$arr['imageUploaded'] = $this->imageDetails[0]['message'];
        $arr['message'] = $this->response;
        echo json_encode($arr);
        
    }

    public function UpdateSale(){
        $PDOConnection;
        $query;
        $itemId = $_POST['item_id'];
        try{
            $PDOConnection = $this->getConnection();
            $query = $PDOConnection->prepare($this->sqlSelectItem);
            $query->execute(array('itemId'=>$itemId, 'sellerId'=>$this->sellerID));
            $result = $query->fetch();
            $this->checkUpdated($result);
            //the query will only retrieve row where the user and item id match 
            //so if its null then the user does not own the item
            //NOTE must change to webtoken as Id is not safe
            if($result !== null && $result['item_id'] !== null){
                $query = $PDOConnection->prepare($this->sqlUpdateDetails);
                $query->execute(array('itemName'=>$this->itemName,'itemKeywords'=>$this->keywords, 'shortDescription'=>$this->shortDescription, 'fullDescription'=>$this->fullDescription, 'price'=>$this->itemPrice,'deliveryCost'=>$this->deliveryCost,'itemId'=>$itemId));
                
                $query = $PDOConnection->prepare($this->sqlUpdateSounds);
                $query->execute(array('itemSounds'=>$this->nameSound,'keywordsSound'=>$this->keywordSound));
                
                if($this->imagesPresent){
                    $count = sizeof($this->imageDetails);
                
                    for($i = 0; $i < $count; $i++){
                        //(saleID,image_url) VALUES(:saleId, :imageUrl) WHERE item_images_id = :id";
                        $imageName = $this->imageDetails[$i]['imageName'];
                        $imageId = $this->imageDetails[$i]['id'];
                        $query = $PDOConnection->prepare($this->sqlUpdateImage);
                        $query->execute(array('saleId'=>$itemId, 'imageUrl'=>$imageName, 'id'=>$imageId));
                    }
                    //not even sure what I wanted this bool for
                    $this->uploaded = true;
                }

                if($this->isAuction){
                    $query = $PDOConnection->prepare($this->sqlUpdateAuction);
                    $query->execute(array('price'=>$this->itemPrice,'itemId'=>$this->$itemId));
                }
                $this->response = "success";
            }
            $this->response = "You do not own this item";
            $PDOConnection->rollBack();
            //TODO: if items title or keywords have been updated then update the items sound
            //REMINDER: do not update auction table unless item has not been bidded on
        }catch(PDOException $e){
            $PDOConnection->rollBack();
            //after rollback we must remove the images and related rows in the table
            $this->response = "rolled back: " . $e->getMessage();
            //redirect to another page and display error
        }
        $resp['message'] = $this->response;
        echo json_encode($resp);
    }

    private function checkUpdated($res){
        //check if items are set if they are keep the new entry if not get the database entry to ensure data in the database is not overwritten by null or ""
        $this->itemName = isset($this->itemName) && trim($this->itemName) !== "" ? $this->itemName : $res['item_name'];
        $this->deliveryCost = isset($this->deliveryCost) ? $this->deliveryCost : $res['delivery_cost'];
        $this->shortDescription = isset($this->shortDescription) && trim($this->itemName) !== "" ? $this->shortDescription : $res['item_short_description'];
        $this->fullDescription = isset($this->fullDescription) && trim($this->itemName) !== "" ? $this->fullDescription : $res['item_description'];
        $this->keywords = isset($this->keywords) && trim($this->itemName) !== "" ? $this->keywords : $res['item_keywords'];
        $this->condition = isset($this->condition) && trim($this->itemName) !== "" ? $this->condition : $res['item_condition'];

        
    }

    //this function gives the seller the ability to delete all traces of a posted sale
    //needs some heavy testing as cannot test without page
    public function deleteSale($saleId, $aucId){
        //MIGHT Implement a system where if a user deletes an item that has been bidded on their account gets a strike
        //if they do this on rare occasions and not abusing the system because the current bid is too low for their standards,
        //then the strike will mean nothing
        $PDOConnection;
        $query;
        $itemId = array('itemId'=>$saleId);
        try{
            //even though the connection maybe set we should still get a fresh version of the 
            //connection to ensure the variable has not been altered
            $PDOConnection = $this->getConnection();
            //begin the transaction
            $PDOConnection->beginTransaction();
            //check if user is owner of item before procceding 
            $query = $PDOConnection->prepare($this->sqlChkOwnership);
            $query->execute(array('itemId'=>$saleId, 'sellerId'=>$this->sellerID));
            //prepare and execute the statement for the item deletion
            $result = $query->fetchColumn();
            if(isset($result) && $result == 1){
                if($aucId > 0){
                    $query = $PDOConnection->prepare($this->sqlDeleteBids);
                    $query->execute($itemId);
                    $query = $PDOConnection->prepare($this->sqlDeleteAuctions);
                    $query->execute($itemId);
                }
                $query = $PDOConnection->prepare($this->sqlDeleteImages);
                $query->execute($itemId);
                $query = $PDOConnection->prepare($this->sqlDeleteSounds);
                $query->execute($itemId);
                $query = $PDOConnection->prepare($this->sqlDeleteSale);
                $query->execute($itemId);
                $PDOConnection->commit();
                $this->response = 'success';
                //need a page to redirect to
            }else{
                $PDOConnection->rollBack();
                $this->response = "failed";
            }
            
        }catch(PDOException $e){
            $PDOConnection->rollBack();
            //after rollback we must remove the images and related rows in the table
            $this->response = "rolled back: " . $e->getMessage();
            //redirect to another page and display error
        }
    }

    private function getAndSanitizeVars(){
        //get all variables from the post and sanitize them
        $this->itemName = $this->validateAndSanitize($_POST['item_name']);
        $this->itemPrice = $this->validateAndSanitize($_POST['item_price'], 'float');
        $this->deliveryCost = $this->validateAndSanitize($_POST['delivery_price'], 'float');
        $this->shortDescription = $this->validateAndSanitize($_POST['short_description']);
        $this->fullDescription = $this->validateAndSanitize($_POST['full_description']);
        $this->keywords = $this->validateAndSanitize($_POST['keywords']);
        $this->condition = $this->validateAndSanitize($_POST['condition']);
        $this->endDate = $this->validateAndSanitize($_POST['endDate'], "date");
       
    }

    protected function validateAndSanitize($var, $type = "string"){

        if((!isset($var) || $var === null || $var === "") && $_POST['action'] === "POST" && $type !== 'date'){
            die("variable was not set");
        }else if((!isset($var) || $var === null || $var === "") && $_POST['action'] === "PUT"){
            //if it is not set and the action is put then it is ok to have no entry
            return null;
        }

        if($type === 'float'){
            return filter_var($var,FILTER_VALIDATE_FLOAT);

        }else if($type === 'string'){
            return filter_var($var, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        }else if($type === "date"){
            if(isset($var)){
            $date = array_reverse(explode("/", $var));
            $result;
            for($i = 0; $i < 3; $i++){
                //validate int seems to return false for values like 12
                //not sure why
                $result = filter_var($date[$i],FILTER_VALIDATE_FLOAT);
        
                if($result === false){
                    //invalid date exit loop
                    break;
                }

            }
            }
            if((isset($result) && $result === false) || !isset($var)){
                //date is invalid get current and add one month
                    //if month is equal return 1 else return month + 1
                $month = date("m") === 12 ? 1 : date("m") + 1;
                $tempDate = explode("-",date("Y-d"));
                $time = mktime(11,55,00,$month,$tempDate[1],$tempDate[0]);
                $date = date("Y-m-d h:i:s", $time);
                return $date;
            }else{
                return implode("-",$date);  
            }

        }else{
            die('this variable type has not yet been setup for filtering and validation');
        }
    }
}

$controller = new SaleController();

//php does not directly support put and delete so I will just use POST in replace of them
if($_POST['action'] === "POST"){
    //check, clean and set variables
    $controller->getAndSanitizeVars();
    $res = $controller->processSale();
    if($res = "NotLoggedIn"){
        $arr['message'] = "NotLoggedIn";
        echo json_encode($arr);
    }else{
        $controller->createSale();
    }
}else if($_POST['action'] === "DELETE"){
    $controller->deleteSale($_POST['saleId'],$_POST['aucId']);
}else if($_POST['action'] === "PUT"){
    //check, clean and set variables
    $controller->getAndSanitizeVars();
    $res = $controller->processSale();
    if($res = "NotLoggedIn"){
        $arr['message'] = "NotLoggedIn";
        echo json_encode($arr);
    }else{
        $controller->updateSale();
    }
    
}else{
    $resp['message'] = "action Not setup";
    echo json_encode($resp);
}

?>