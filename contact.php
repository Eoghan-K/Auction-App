<?php

include "includes/header.php";
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-12" id="header">
            <div class="row image_shading">
                <div id="headText">
                    <h1>Contact Us</h1>
                    <h2>We would love to hear from you</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="contact_options" class="col">


            <div class="row seperate_from_top">
                <div id="contact_details" class="col-md-6 order-last contact_cont">
                    <h1 class="row">Contact Details</h1>
                    <p class="row">If you would like to contact us you can use any of the details below or use the form
                        supplied on this page</p><br>
                    <p class="row"><strong>for any support or queries:</strong></p>
                    <p class="row"><strong>Phone Number:</strong> &nbsp &nbsp 0255465</p>
                    <p class="row"><strong>Email:</strong> &nbsp &nbsp fake.email@fake.ie</p><br>
                    <p class="row"><strong>Ireland Headquarters:</strong></p>
                    <p class="row">123 easy street,<br> Dublin 1,<br> Dublin,<br> Ireland</p>

                </div>
                <div id="contact_form" class="col-md-6 contact_cont">
                    <h1>Contact us directly</h1>
                    <form id="comment_form" action="contactForm.php" method="POST">
                        <div class='form-group'>
                            <label for='contact_form_name'>Name:</label>
                            <input id='contact_form_name' type="text" name="name" placeholder="name"
                                   class="form-control">
                        </div>

                        <div class='form-group'>
                            <label for='contact_form_email'>Email:</label>
                            <input id='contact_form_email' type="email" name="email" placeholder="Type your email"
                                   class="form-control">
                        </div>

                        <div class='form-group'>
                            <label for='contact_form_subject'>Subject:</label>
                            <input id='contact_form_subject' type="text" name="Subject" placeholder="Subject"
                                   class="form-control">
                        </div>

                        <div class='form-group'>
                            <label for='contact_form_comment'>Comment:</label>
                            <textarea id='contact_form_comment' name="comment" rows="8" class="form-control"
                                      placeholder='Enter your comments here...'></textarea>
                        </div>

                        <input type="submit" class="btn" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

include "includes/bootstrapScripts.php";
?>
