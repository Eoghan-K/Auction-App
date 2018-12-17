<?php
    include "includes/header.php";
    if ( !( $GLOBALS[ 'isLoggedIn' ] ) ) {
        header( 'location: ./login.php' );
    }
?>

<div id="sale-form-wrapper" class="container" >

    <!--TODO redo this entire form-->
    <div class="row" id="smForm">
        <input name="item_name" id='itemName' placeholder="Title" />
        <input name="item_price" id='itemPrice' placeholder="Price" />
        <input name="delivery_price" id='deliveryPrice' placeholder="Price of Delivery" />
    </div>
    
    <div class="row" id="lgForm">
        <!--action should call ajax-->
        <input name="short_description" id='shortDesc' placeholder="short description" />
        <input name="full_description" id='fullDesc' placeholder="full_description" />
        <input name="keywords" id='keywords' placeholder="please enter item keywords seperate with a comma(,)" />
        <input name="condition" id='condition' placeholder="item_condition" />
        
       
    </div>
    <div class="row">
        <div class="col-sm-3" >
            <div class="checkForm">
                <p>Auction</p>
                <input name="isAuction" id="saleType" type="checkbox" />
            </div>
        </div>
        <div class="col-sm-9">
            <div class="checkForm" id="dateContainer">
                <p>End-Date: </p>
                <input type="text" id="endDate" />
            </div>
        </div>
    </div>
    <div id="DragD" title="sellItem"></div>
    <!--include dragdrop-->
    <?php include "includes/DragDrop.php"?>
    <div class="row">
        <input type="submit" id="submitBtn" name="submit" value="submit" />
    </div>
    
</div>

   <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script type="text/javascript" src="scripts/librarys/jquery.dragbetter/jquery.dragbetter.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="scripts/JavaScript/DragDropFileUpload.js"></script>
    <script src="scripts/JavaScript/AjaxRequests.js"></script>
    <script src="scripts/JavaScript/saleForm.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<?php
    include "includes/footer.php";

?>