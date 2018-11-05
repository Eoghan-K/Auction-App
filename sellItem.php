<?php

    include "includes/header.php";

?>
<!--drag and drop feature has been referenced from here: https://bootsnipp.com/snippets/featured/bootstrap-drag-and-drop-upload -->
<!--i.item_short_description, i.item_description, img.item_images_id,-->
<div id="sale-form-wrapper" class="container-fluid">

    <div class="row">
        <div class="col-xl-6">
            <div class="container">
            <div class="row">
                <!--action should call ajax-->
                <form id="RegForm" method="POST" action="scripts/uploadItemInfo.php">
	                <input name="item_name" placeholder="Title" />
                    <input name="item_price" placeholder="Price" />
                    <input name="delivery_price" placeholder="Price of Delivery" />
                    <input name="short_description" placeholder="short description" />
                    <input name="full_description" placeholder="full_description" />
                    <input name="keywords" placeholder="please enter item keywords seperate with a comma(,)" />
                    <input name="condition" placeholder="item_condition" />
                    <!--need to add select box for is auction-->
    	            <input type="submit" name="submit" value="submit" />
                </form>
            </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div id="dragDropUpload" class="container">
                <div class="row">
                     <!--file loading and success will be placed here probably render with php (actually javascript would be better suited to this task)-->
                     <!--TODO remove style when testing is complete-->
                    <div class="col-2 progress" style="background:black;height:50px;">
                      <!-- <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div> -->
                    </div>
                    <div class="col-2 progress" style="background:black;height:50px;">
                      <!-- <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div> -->
                    </div>
                </div>
               <div class="row">
                    <h1 style="margin: auto;" >Drag your images here</h1>
                </div>
                <div class="row">
                    <div style="margin: auto;" id="legacyUploadBtn">or click here to browse</div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php

    include "includes/footer.php";

?>