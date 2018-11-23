 <?php
 
     include "includes/header.php";

     $name = $_POST['name'];
     $email = $_POST['email'];
     $message = $_POST['message'];
    
    $from = 'From: topChoiceAuctions'; 
    $to = 'demo@topChoiceAuctions.com'; 
    $subject = 'Greetings';
    
    $body = "From: $name\n E-Mail: $email\n Message:\n $message";



 ?>
 
<div class="container-fluid">
    <div class="row">
        <div class="col-12" id="header">
            <div class="row image_shading">
                <div id="headText" >
                    <h1>Contact Us</h1>
                    <h2>We would love to hear from you</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div id="contact_options" class="col">
        
        
        <div class="row seperate_from_top">
            <div id="contact_details" class="col-md-6 order-last contact_cont">
                <h1 class="row">Contact Details</h1>
                <p class="row">If you would like to contact us you can use any of the details below or use the form supplied on this page</p>
                <br>
                <p class="row"><strong>for any support or querys:</strong></p>
                <p class="row"><strong>Phone Number:</strong> &nbsp &nbsp 0255465</p>
                <p class="row"><strong>Email:</strong> &nbsp &nbsp fake.email@fake.ie</p>
                <br>
                <p class="row"><strong>Ireland Headquarters:</strong></p>
                <p class="row">123 easy street,<br> Dublin 1,<br> Dublin,<br> Ireland</p>
                
            </div>
            
            
    <?php        
            if ($_POST['submit']) {
        if (mail ($to, $subject, $body, $from)) { 
            echo '<p>Your message has been sent!</p>';
        } else { 
            echo '<p>Something went wrong, go back and try again!</p>'; 
        }
    }
    ?>
    
    
            <div id="contact_form" class="col-md-6 contact_cont">
                <h1>Contact us directly</h1>
                <form id="comment_form" action="index.php" method="post">
				    	<input type="text" name="name" placeholder="name" class="form-control"><br/>
					    <input type="email" name="email" placeholder="Type your email" class="form-control"><br/>
					    <input type="Subject" name="Subject" placeholder="Subject" class="form-control"><br/>
					    <textarea name="comment" rows="8" class="form-control"></textarea><br/>
					    <input type="submit" class="btns" name="submit" value="Submit"><br><br>
			    </form>
            </div>
           </div>
        </div>
 </div>
</div>

 <?php
 
 include "includes/footer.php";
 
 ?>