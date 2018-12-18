<?php
    include "includes/header.php";

?>
    
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>
        
        
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src=" source " alt="Image">
                <div class="carousel-caption">
                    <h3>Header 1</h3>
                    <p>Sub Header 1.</p>
                </div>
            </div>
            
            <div class="item">
                <img src=" source" alt="Image">
                <div class="carousel-caption">
                    <h3> Header 2 </h3>h3>
                    <p>Sub Header 2</p>
                </div>
            </div>
        </div>
        
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
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