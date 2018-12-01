<?php
include('../DBConnection.php');

class AuctionChkExp extends DBConnection{
    private $SQLGetExpired, $SQLMoveData, $SQLUpdateImage;
    private $SQLDeleteBids, $SQLDeleteSounds, $SQLDeleteAuction, $SQLDeleteItem, $SQLDeleteBidGroup;
    private $PDOConnection;
    
    public function __construct(){
        $this->updatePath('../../Config.ini');
        $this->SQLGetExpired = "SELECT auction_id, item_id FROM auctions WHERE End_Date <= :current ";
        
        $this->SQLMoveData = "INSERT INTO sold_items(item_name, item_keywords, item_short_description, item_description, delivery_cost, Seller_id, price, buyer_id)
        SELECT i.item_name, i.item_keywords, i.item_short_description, i.item_description, i.delivery_cost, i.seller_id, a.current_offer, a.bidder_id 
        FROM item AS i JOIN auctions AS a ON i.item_id = a.item_id WHERE a.auction_id = :auctionId";
        /* cant get this to work
        $this->SQLDeleteAll = "DELETE itm, auc, bids, snd FROM item AS itm JOIN auctions AS auc ON itm.item_id = auc.item_id 
        JOIN item_sounds AS snd ON itm.item_id = snd.item_id
        JOIN Bids AS bids ON auc.auction_id = bids.auction_id
        WHERE auc.auction_id = :auctionId";*/

        $this->SQLDeleteBids = "DELETE FROM Bids WHERE auction_id = :aucId";
        $this->SQLDeleteSounds = "DELETE FROM item_sounds WHERE item_id= :itemId";
        $this->SQLDeleteAuction = "DELETE FROM auctions WHERE auction_id = :aucId";
        $this->SQLDeleteItem = "DELETE FROM item WHERE item_id = :itemId";
        //user has won the auction so the big group is nolonger needed
        $this->SQLDeleteBidGroup = "DELETE FROM Bids ";

        $this->SQLUpdateImage = "UPDATE item_images SET sold_item_id = :soldItemId, item_id = 0 WHERE item_id = :itemId";
        $this->manageAuctions();
    }


    private function manageAuctions(){
        
        try{
            //get connection
            $this->PDOConnection = $this->getConnection();
            //begin transaction
            $this->PDOConnection->beginTransaction();
                //prepare statement for getting all expired auction ids and the ids of related items
                $query = $this->PDOConnection->prepare($this->SQLGetExpired);
                //bind the current date and time to the query and execute
                $query->execute(array('current'=>date("Y.m.d h:i:s")));
                //get results
                $allIds = $query->fetchALL(PDO::FETCH_ASSOC);

            foreach($allIds as $key=>$val){
                echo $val['auction_id'];
                //preare statement to move all data for items on sale with expired dates to sold table
                $query = $this->PDOConnection->prepare($this->SQLMoveData);
                //bind the auction_id to the prepared statement
                $query->execute(array('auctionId'=>$val['auction_id']));
                //get the last inserted id
                $soldId = $this->PDOConnection->lastInsertId();

                $this->deleteRows($val);

                //prepare statement for updating related images
                $query = $this->PDOConnection->prepare($this->SQLUpdateImage);
                //bind last inserted id and the item for sale id to the statement
                $query->execute(array('soldItemId'=>$soldId, 'itemId'=>$val['item_id']));
            }
            //commit data
            $this->PDOConnection->commit();
            echo "worked";
        }catch(PDOException $e){
            echo "failed";
            //exception was caught abort, ABORT!!!
            $this->PDOConnection->rollBack();

            error_log("Transaction in AuctionsChkExp failed: " . $e, 0);
        }
    }

    private function deleteRows($val){
        //prepare statement for deleting rows related to the sold item
        //And bind data to find related rows
        $query = $this->PDOConnection->prepare($this->SQLDeleteBids);
        $query->execute(array('aucId'=>$val['auction_id']));
        
        $query = $this->PDOConnection->prepare($this->SQLDeleteSounds);
        $query->execute(array('itemId'=>$val['item_id']));
       
        $query = $this->PDOConnection->prepare($this->SQLDeleteAuction);
        $query->execute(array('aucId'=>$val['auction_id']));
        
        $query = $this->PDOConnection->prepare($this->SQLDeleteItem);
        $query->execute(array('itemId'=>$val['item_id']));
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

$auc = new AuctionChkExp();

?>