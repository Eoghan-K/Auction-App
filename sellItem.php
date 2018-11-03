<?php

    include "includes/header.php";

?>
<!--drag and drop feature has been referenced from here: https://bootsnipp.com/snippets/featured/bootstrap-drag-and-drop-upload -->
<!--i.item_short_description, i.item_description, img.item_images_id,-->
<div id="form-wrapper" class="container">
    <div class="col-6">
        <div class="row">
            <!--action should call ajax-->
            <form method="POST" action="scripts/uploadItemInfo.php">
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
        <div class="col-6">
            <div class="row" id="legacyUpload">
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="file" name="images[]" multiple />
                </form>
            </div>
            <div class="row" id="dragDropUpload">
                Drag your images here
                <!--file success will be placed here-->
            </div>
            <div class="row progress">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
              </div>
            </div>
        </div>
    </div>
    
</div>

<?php

    include "includes/footer.php";

?>