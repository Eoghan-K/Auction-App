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
                <img class="icons" src="images/icons/open-iconic-master/svg/list-rich.svg" alt="list" onClick="loadInformation(null, false,false)">
                <img class="icons" src="images/icons/open-iconic-master/svg/grid-three-up.svg" alt="grid" onClick="loadInformation(null, true,false)">
            </div>
        </div>
    </div>
    </div>
    <div class="col" id="test">
        
    </div>
      <?php
      
        /*require('scripts/SearchDB.php');
        require('scripts/ConstructPage.php');
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //clean the data before conducting search
          $data = filter_var($_POST['search'], FILTER_SANITIZE_STRING);
          $search = new SearchDB($data);
          $results = $search->commenceSearch();
          $generateItems = new ConstructPage($results, true);
        }*/
      ?>
       
</div>
    <!-- not using footer as I need to organize scripts that are unneeded in other pages -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="scripts/AJAXSTESTSCRIPT.js"></script>
    <script type="text/javascript"> window.loadInformation("<?php echo $_POST['search']; ?>", true,true);</script>
</body>
</html>