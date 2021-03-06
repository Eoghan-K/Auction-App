<?php
	include "includes/header.php";
	include "scripts/Item.php";
	
	$item = null;
	$images = null;
	
	if ( isset( $_GET[ "id" ] ) ) {
		
		$id = $_GET[ "id" ];
		$i = new Item( $id );
		$item = $i->getItem();
		$images = $i->getImages();
	} else {
		header( 'location: ../index.php' );
	}

?>
	
<!--	<div id="myCarousel" class="carousel slide" data-ride="carousel">-->
<!--		-->
<!--		<ol class="carousel-indicators">-->
<!--			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>-->
<!--			<li data-target="#myCarousel" data-slide-to="1"></li>-->
<!--		</ol>-->
<!--		-->
<!--		-->
<!--		<div class="carousel-inner" role="listbox">-->
<!--			<div class="item active">-->
<!--				<img src="images/uploaded/sales/--><?php //echo $images[ 0 ][ 'image_url' ] ?><!--" alt="Image">-->
<!--				<div class="carousel-caption">-->
<!--					<h3>Header 1</h3>-->
<!--					<p>Sub Header 1.</p>-->
<!--				</div>-->
<!--			</div>-->
<!--			-->
<!--			<div class="item">-->
<!--				<img src="images/uploaded/sales/--><?php //echo $images[ 1 ][ 'image_url' ] ?><!--" alt="Image">-->
<!--				<div class="carousel-caption">-->
<!--					<h3> Header 2 </h3>h3>-->
<!--					<p>Sub Header 2</p>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		-->

<!--		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">-->
<!--			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>-->
<!--			<span class="sr-only">Previous</span>-->
<!--		</a>-->
<!--		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">-->
<!--			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>-->
<!--			<span class="sr-only">Next</span>-->
<!--		</a>-->
<!--	</div>-->
	
	<div class="container text-center">
		<h3><?php echo $item['item_name'] ?><echo print_r($_GET);h3><br>
		<div class="row">
			<?php  for ($j = 0; $j < sizeof($images); $j++){ ?>
				<div class="col-sm-4">
					<img src="images/uploaded/sales/<?php echo $images[ $j ][ 'image_url' ] ?>"
					     class="img-responsive"
					     style="width:100%"
					     alt="Image"
					>
					<p><?php echo $images[ $j ][ 'image_name' ] ?></p>
				</div>
			<?php }?>
			<div class="col-sm-4">
				<div class="well">
					<p>Description</p>
				</div>
				<div class="well">
					<p><?php echo $item['item_description'] ?></p>
				</div>
			</div>
		</div>
		<div class="row">
		
			<?php if($item['auction_id'] === "0"){ ?>
			<button type="button" onclick="purchaseItem(<?=$id?>)" class="btn btn-success">purchase Item</button>
			<?php	}else{	?>
			<!--move styles to css when finished-->
			<input type="text" id="bidAmount" placeholder="bid amount" style="width:160px;"/>
			<input type="text" id="bidGroup" placeholder="bid group" style="width:160px;"/>
			<button type="button" onclick="bidonItem(<?=$id?>)" class="btn btn-success">Place bid</button>
			<?php } ?>

		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="scripts/JavaScript/AjaxRequests.js"></script>
	<script src="scripts/JavaScript/itemPage.js"></script>
<?php
	
	include "includes/footer.php";

?>