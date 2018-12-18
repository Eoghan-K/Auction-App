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


<!--

<?php
///*
// * Just General Configuration put in here.
// *
// */
//
////This email address will be in the 'From' field of the automated email
//$from = 'Demo contact form <demo@domain.com>';
//
//// This is the email that it will be sent to.
//$sendTo = 'Demo contact form <demo@domain.com>';
//
//// The subject of the email itself
//$subject = 'New message from contact form';
//
//// name of the fields of the form, as well as general translations for them
//// Array variable name --> Text that will appear in the created email.
//$fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message');
//
//// This message will be displayed if everything went well.
//$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
//
//// This message will be displayed if everything went wrong.
//$errorMessage = 'There was an error while submitting the form. Please try again later';
//
///*
// *  Now we can send the email.
// */
//
//// Remember, you can turn this off by using the following code snippet: 'error_reporting(0);'
//// Turn if off if you are not debugging and / or do not need error reporting
//error_reporting(E_ALL & ~E_NOTICE);
//
//
//// try catch.
//
//try
//{
//
//    if(count($_POST) == 0) throw new \Exception('Form is empty');
//
//    $emailText = "You have a new message from your contact form\n=============================\n";
//
//    foreach ($_POST as $key => $value) {
//        // If the field exists in the $fields array, include it in the email
//        if (isset($fields[$key])) {
//            $emailText .= "$fields[$key]: $value\n";
//        }
//    }
//
//    // All the neccessary headers for the email.
//    $headers = array('Content-Type: text/plain; charset="UTF-8";',
//        'From: ' . $from,
//        'Reply-To: ' . $from,
//        'Return-Path: ' . $from,
//    );
//
//    // Send email
//    mail($sendTo, $subject, $emailText, implode("\n", $headers));
//
//    $responseArray = array('type' => 'success', 'message' => $okMessage);
//}
//catch (\Exception $e)
//{
//    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
//}
//
//
//// if requested by AJAX request return JSON response
//if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
//    $encoded = json_encode($responseArray);
//
//    header('Content-Type: application/json');
//
//    echo $encoded;
//}
//// else just display the message
//else {
//    echo $responseArray['message'];
//}
//?>

-->

<?php

include "includes/bootstrapScripts.php";
?>
