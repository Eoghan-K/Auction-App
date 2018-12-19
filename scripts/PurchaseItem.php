<?php
include('DBConnection.php');

class PurchaseItem extends DBConnection{
    private $SQLMoveData, $SQLUpdateImage, $SQLDeleteSale, $SQLDeleteSounds;
    private $buyerId, $itemId;
    private $response;

    public function __construct(){
       
        session_start();
        $this->buyerId = $_SESSION['id'];
        $this->itemId = $_POST['itemId'];
        $this->setupSQLStatements();
    }

    private function setupSQLStatements(){
        $this->SQLMoveData = "INSERT INTO sold_items(item_name, item_keywords, item_short_description, item_description, delivery_cost, Seller_id, price,date_listed, buyer_id) 
        SELECT i.item_name, i.item_keywords, i.item_short_description, i.item_description, i.delivery_cost, i.seller_id, i.starting_price, i.date_listed, :buyerId FROM item AS i WHERE i.item_id = :itemId";
        
        $this->SQLDeleteSounds = "DELETE FROM item_sounds WHERE item_id= :itemId";
        $this->SQLDeleteSale = "DELETE FROM item WHERE item_id = :itemId";
        
        $this->SQLUpdateImage = "UPDATE item_images SET sold_item_id = :soldItemId, item_id = 0 WHERE item_id = :itemId";
    }

    public function purchaseItem(){
        if(isset($this->buyerId) && $this->buyerId > 0){ 
        //NOTE This should not be executed until after payment has been cleared
        try{
            $PDOConnection = $this->getConnection();
            $PDOConnection->beginTransaction();
                //move data to sold items table to store purchase and sale history
                $query = $PDOConnection->prepare($this->SQLMoveData);
                    $query->execute(array('buyerId'=>$this->buyerId, 'itemId'=>$this->itemId));
                    $id = $PDOConnection->lastInsertId();
                //update the last inserted row with more needed data
                $query = $PDOConnection->prepare($this->SQLUpdateImage);
                    $query->execute(array('soldItemId'=>$id, 'itemId'=>$this->itemId));
                 //delete related sounds
                 $query = $PDOConnection->prepare($this->SQLDeleteSounds);
                 $query->execute(array('itemId'=>$this->itemId));
                //after row has been stored for history delete it as it is nolonger on sale
                $query = $PDOConnection->prepare($this->SQLDeleteSale);
                    $query->execute(array('itemId'=>$this->itemId));
               
            //commit transaction
            $PDOConnection->commit();
            $this->response = "success";
        }catch(PDOException $e){
            //something went wrong rollback to original state
            $PDOConnection->rollBack();
            //after rollback we must remove the images and related rows in the table
            $this->response = "rolled back: " . $e->getMessage();
            //redirect to another page and display error
        }
        }else{
            $this->response = "NotLoggedIn";
        }
        $resp['message'] = $this->response;
        echo json_encode($resp);
    }

    private function EmailUser(){
        //this function should send an email to both the buyer and seller
        //notifying them of the sale completion.
    }

    protected function validateAndSanitize(){
        //unneeded
        //only included to please dbconnection abstract class
    }

}

$buy = new PurchaseItem();
$buy->purchaseItem();
?>
