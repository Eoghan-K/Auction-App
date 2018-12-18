<?php

include "includes/header.php";
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-12" id="header">
            <div class="row image_shading">

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

                    <p class="row"><strong>Contact Us Here:</strong></p>
                    <p class="row"><strong>Phone Number:</strong> &nbsp &nbsp 01-234-5678 </p>
                    <p class="row"><strong>----------OR----------</strong></p>
                    <a href="mailto:topChoiceAuctions@gmail.com?subject=Contact%20Us">Send Us an Email here!</a><br>
                    <br>
                    <p class="row"><strong>Ireland Headquarters:</strong></p>
                    <p class="row">National College of Ireland, <br> IFSC, <br> Dublin 1,<br> Ireland</p>


                </div>
                <div id="contact_form" class="col-md-6 contact_cont">
                    <h1>Contact us directly</h1>
                    <form id="contact-form" method="post" action="contact.php" role="form">

                        <div class="messages"></div>

                        <div class="controls">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_name">First Name *</label>
                                        <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter your First Name *" required="required" data-error="Firstname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_lastname">Last Name *</label>
                                        <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Please enter your Last Name *" required="required" data-error="Lastname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_email">Email Address *</label>
                                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your Email Address *" required="required" data-error="Valid email is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_need">Please specify your need *</label>
                                        <select id="form_need" name="need" class="form-control" required="required" data-error="Please specify your need.">
                                            <option value=""></option>
                                            <option value="Request Quotation">Request Quotation</option>
                                            <option value="Request General Help">Request General Help</option>
                                            <option value="Request Order Status">Request Order Status</option>
                                            <option value="Report A Bug">Report A Bug</option>
                                            <option value="Report A User">Report A User</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="form_message">Message *</label>
                                        <textarea id="form_message" name="message" class="form-control" placeholder="Message for me *" rows="4" required="required" data-error="Please, leave us a message."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success btn-send" value="Send message">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-muted">
                                        <strong>* These fields are required.</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

include "includes/bootstrapScripts.php";
?>
