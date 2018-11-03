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
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body>

<div id='fg_membersite'>
<form id='login' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Login</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>

<div class='short_explanation'>* required fields</div>

<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<div class='container'>
    <label for='username' >UserName*:</label><br/>
    <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
    <span id='login_username_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='password' >Password*:</label><br/>
    <input type='password' name='password' id='password' maxlength="50" /><br/>
    <span id='login_password_errorloc' class='error'></span>
</div>

<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>
<div class='short_explanation'><a href='reset-pwd-req.php'>Forgot Password?</a></div>
</fieldset>
</form>


<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("login");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("username","req","Please provide your username");
    
    frmvalidator.addValidation("password","req","Please provide the password");

// ]]>
</script>
</div>

<div class="container-fluid bg-light py-3">
    <div class="row">
        <div class="col-md-6 mx-auto">
                <div class="card card-body">
                    <h3 class="text-center mb-4">Sign-up</h3>
                    <div class="alert alert-danger">
                        <a class="close font-weight-light" data-dismiss="alert" href="#">×</a>Password is too short.
                    </div>
                    <fieldset>
                        <div class="form-group has-error">
                            <input class="form-control input-lg" placeholder="E-mail Address" name="email" type="text">
                        </div>
                        <div class="form-group has-success">
                            <input class="form-control input-lg" placeholder="Password" name="password" value="" type="password">
                        </div>
                        <div class="form-group has-success">
                            <input class="form-control input-lg" placeholder="Confirm Password" name="password" value="" type="password">
                        </div>
                        <div class="form-group">
                            <select class="form-control input-lg">
                                <option selecterd="">Sequrity Question</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control input-lg" placeholder="Sequrity Answer" name="answer" value="" type="text">
                        </div>
                        <div class="checkbox">
                            <label class="small">
                                <input name="terms" type="checkbox">I have read and agree to the <a href="#">terms of service</a>
                            </label>
                        </div>
                        <input class="btn btn-lg btn-primary btn-block" value="Sign Me Up" type="submit">
                    </fieldset>
                </div>
        </div>
    </div>





</body>
</html>
	
	
	
	