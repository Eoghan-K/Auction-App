<?php
    include "includes/header.php";
?>

<div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block" src="images/image1.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block" src="images/image2.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block" src="images/image3.jpg" alt="Third slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="container text-center">
    <h3>Item Description</h3><br>
    <div class="row">
        <div class="col-sm-4">
            <img src="" class="img-responsive" style="width:100%" alt="Image">
            <p>Image 1</p>
        </div>
        <div class="col-sm-4">
            <img src="" class="img-responsive" style="width:100%" alt="Image">
            <p>Image 2</p>
        </div>
        <div class="col-sm-4">
            <div class="well">
                <p>descption</p>
            </div>
            <div class="well">
                <p>descption </p>
            </div>
        </div>
    </div>
</div>

<?php
    
    include "includes/bootstrapScripts.php";

?>
