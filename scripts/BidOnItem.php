<?php 
include('DBConnection.php');

class BidOnItem extends DBConnection{
    private $SQLBid, $SQLUpdateAuction, $SQLSelectAuction;
    private $itemId, $bidderId, $bidGroup;
    private $bidAmount;
    private $response;

    public function __construct(){
        $this->itemId = $_POST['itemId'];
        //get from session
        $this->bidderId = 1;
        $this->bidAmount = $_POST['bidAmount'];
        
        if(isset($_POST['bidGroup'])){
            $this->bidGroup = $_POST['bidGroup'];
        }else{
            $this->bidGroup = "noGroup";
        }
        $this->setupSQLStrings();
        
    }

    private function setupSQLStrings(){
        $this->SQLSelectAuction = "SELECT auc.auction_id, auc.current_offer, itm.seller_id FROM auctions AS auc JOIN item AS itm ON itm.item_id = auc.item_id WHERE auc.item_id = :itemId";

        $this->SQLBid = "INSERT INTO Bids(auction_id, bidder_id, bid_amount, bid_group) VALUES (:aucId, :bidderId, :bidAmount, :bidGroup) ON DUPLICATE KEY UPDATE bid_amount = VALUES(bid_amount);";

        $this->SQLUpdateAuction = "UPDATE auctions SET current_offer = :bidAmount, bidder_id = :bidderId WHERE auction_id = :auctionId";
    }

    public function addBidToDB(){
        $PDOConnection;
        try{
            $PDOConnection = $this->getConnection();
            $query = $PDOConnection->prepare($this->SQLSelectAuction);
                $query->execute(array('itemId'=>$this->itemId));
                $auc = $query->fetchALL(PDO::FETCH_ASSOC);
            if($auc['bid_amount'] >= $this->bidAmount ){
                $this->response = "The Cheek of you, the value entered must be higher than the current offer";
            }else if($this->bidderId == $auc['seller_id']){
                $this->response = "SNEAKY, you cannot bid on your own item, nice try tho";
            }else{
                $PDOConnection->beginTransaction();
                    $query = $PDOConnection->prepare($this->SQLBid);
                    $query->execute(array('aucId'=>$auc['auction_id'], 'bidderId'=>$this->bidderId, 'bidAmount'=>$this->bidAmount, 'bidGroup'=>$this->bidGroup));
                    $query = $PDOConnection->prepare($this->SQLUpdateAuction);
                    $query->execute(array('bidAmount'=>$this->bidAmount, 'bidderId'=>$this->bidderId, 'auctionId'=>$auc['auction_id']));
                $PDOConnection->commit();
                $this->response = "success";
            }
        }catch(PDOException $e){
            $this->response = "something went wrong transaction rolled back, error reported is: " . $e;
            $PDOConnection->rollBack();

        }
        echo $this->reponse;
    }

    protected function validateAndSanitize(){
        //unneeded
        //only included to please dbconnection abstract class
    }



}


?>