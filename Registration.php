<?PHP
//require_once("./include/membersite_config.php");
if(isset($_POST['submitted']))
{
   if($fgmembersite->Login())
   {
        $fgmembersite->RedirectToURL("index.php");
   }
}
    include "includes/header.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Login</title>
      <link rel="STYLESHEET" type="text/css" href="style/style.css" />
      <!--<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>-->
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Sign Up</h5>
            <form class="form-signin">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Email Address" required autofocus>
                <label for="inputEmail" onclick="document.getElementById('inputEmail').focus();">Email</label>
              </div>
              
              <div class="form-label-group">
                <input type="Username" id="Username" class="form-control" placeholder="Username" required autofocus>
                <label for="inputUsername" onclick="document.getElementById('inputUsername').focus();">Username</label>
              </div>
              
              <div class="form-label-group">
                <input type="name" id="inputName1" class="form-control" placeholder="First Name" required autofocus>
                <label for="inputName1" onclick="document.getElementById('inputName1').focus();">First Name</label>
              </div>
                
              <div class="form-label-group">
                <input type="name" id="inputName2" class="form-control" placeholder="Last Name" required autofocus>
                <label for="inputName2" onclick="document.getElementById('inputName2').focus();">Second Name</label>
              </div>

              <div class="form-label-group">
                <input type="text" id="homeAddress" class="form-control" placeholder="Home Address" required autofocus>
                <label for="homeAddress" onclick="document.getElementById('homeAddress').focus();">Home Address</label>
              </div>

              <div class="form-label-group">
                <input type="text" id="postCode" class="form-control" placeholder="Post Code" required autofocus>
                <label for="postCode" onclick="document.getElementById('postCode').focus();">Post Code</label>
              </div>

              <div class="form-label-group">
                <input type="text" id="phoneNumber" class="form-control" placeholder="Phone Number" required autofocus>
                <label for="phoneNumber" onclick="document.getElementById('phoneNumber').focus();">Phone Number</label>
              </div>
              
              <div class="form-label-group">
                
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword" onclick="document.getElementById('inputPassword').focus();">Password</label>
              </div>

              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember password</label>
              </div>
              <button id="submitBtn" class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign Up</button>
              <hr class="my-4">
              
              <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i> Register with Google</button>
              <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class="fab fa-facebook-f mr-2"></i> Register in with Facebook</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
  </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="scripts/JavaScript/AjaxRequests.js"></script>
    <script src="scripts/JavaScript/RegistrationScript.js"></script>

<!--<script type='text/javascript'>
    var frmvalidator  = new Validator("Registration");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    
    frmvalidator.addValidation("email","req","Please provide your email address");
    
    frmvalidator.addValidation("username","req","Please provide your username");
    
    frmvalidator.addValidation("name1","req","Please provide your first name");
    frmvalidator.addValidation("name2","req","Please provide your second name");
    
    frmvalidator.addValidation("password","req","Please provide your password");
</script>-->
</body>
</html>
	

	
	
	
	