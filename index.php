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
    
    <div class="container">
      <div class="row">
          <?php for($i = 0; $i < 12; $i++){ ?>
            <div class="item-card col-12 col-sm-6 col-md-3">
                <div class="card">
                  <img class="card-img-top" src="images/card.svg" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">View Item</a>
                  </div>
                </div>
            </div>
            <?php if($i % 4 == 3){ ?>
              </div>
              <div class="row">
            <?php } ?>
            <?php } ?>
            </div>
          </div>

<?php

    include "includes/bootstrapScripts.php";
    
?>