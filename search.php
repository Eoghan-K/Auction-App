<?php

    include "includes/header.php";

?>

<div id="search_wrapper" class="container">
    <div id="search_head" class="row">
        <div class="col" id="type">
            <div  class="row">
                <a class="toggleBtns toggleBtn-left col active">all</a>
                <a class="toggleBtns toggleBtn-center col">Auctions</a>
                <a class="toggleBtns toggleBtn-right col">standard</a>
                <a class="toggleBtns toggleBtn-singular col" id="filter">filters</a>
            </div>
        </div>
        <div id="organize" class="col">
            <div class="row">
                <span class="col">Sort:</span>
                <select class="custom-select my-1 mr-sm-2 col" id="">
                    <option value="1" selected>Relative</option>
                    <option value="2">Low-High</option>
                    <option value="3">High-Low</option>
                    <option value="4">Best Seller</option>
                </select>
            <div id="view_type" class="col">
                <img class="icons" src="images/icons/open-iconic-master/svg/list-rich.svg" alt="list">
                <img class="icons" src="images/icons/open-iconic-master/svg/grid-three-up.svg" alt="grid">
            </div>
        </div>
    </div>
    </div>
      <?php
        require('scripts/SearchDB.php');
        require('scripts/ConstructPage.php');
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //clean the data before conducting search
          $data = filter_var($_POST['search'], FILTER_SANITIZE_STRING);
          $search = new SearchDB($data);
          $results = $search->commenceSearch();
          $generateItems = new ConstructPage($results, true);
        }
      ?>
       
</div>

<?php

include "includes/footer.php";

?>