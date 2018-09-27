<?php

    include "includes/header.php";

?>

<div id="search_wrapper" class="container-fluid">
    <h2>Don't mind the state of this right now had some computer issues, it will be fixed before upload</h2>
    <div id="search_head" class="row">
        <div id="type" class="col">
            <a>all</a>
            <a>Auctions</a>
            <a>standard sale</a>
            <a>filters</a>
        </div>
        <div id="organize" class="col">
            <div class="row">
                <div id="sort" class="col">
                    <span>Sort:</span>
                    <select class="custom-select my-1 mr-sm-2" id="">
                    <option value="1" selected>Relative</option>
                    <option value="2">Low-High</option>
                    <option value="3">High-Low</option>
                    <option value="4">Best Seller</option>
                </select>
            </div>
            <div id="view_type" class="col">
                <img class="icons" src="images/icons/open-iconic-master/svg/list-rich.svg" alt="list">
                <img class="icons" src="images/icons/open-iconic-master/svg/grid-three-up.svg" alt="grid">
            </div>
        </div>
    </div>
    <div class="container">
      <div class="row">
          <?php for($i = 0; $i < 12; $i++){ ?>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card">
                  <img class="card-img-top" src="images/card.svg" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
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
</div>

<?php

include "includes/footer.php";

?>