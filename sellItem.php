<?php

    include "includes/header.php";

?>
<!--i.item_short_description, i.item_description, img.item_images_id,-->
<div id="form-wrapper" class="container">
    <div class="col-6">
        <div class="row">
            <form method="post" action="">
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
            <h2>this is where the image upload option will be</h2>
        </div>
    </div>
    
</div>

<?php

    include "includes/footer.php";

?>