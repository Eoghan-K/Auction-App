<?php

    include "includes/header.php";

?>

<div class="container-fluid">
    <div id="details" class="row"></div>
    <div id="contact_options" class="row">
        <div id="contact_form" class="col">
            <h1>Contact Us</h1>
            <form id="comment_form" action="contactForm.php" method="POST">
					<input type="text" name="name" class="form-contol"><br/>
					<input type="email" name="email" placeholder="Type your email" class="form-control"><br/>
					<input type="Subject" name="Subject" placeholder="Subject" class="form-control"><br/>
					<textarea name="comment" rows="8" class="txtboxes" cols="42"></textarea><br/>
					<input type="submit" class="btns" name="submit" value="Send"><br><br>
			</form>
        </div>
        <div id="other_contact_options" class="col"></div>
    </div>
</div>
<?php

include "includes/footer.php";

?>