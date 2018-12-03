<?php
	include "includes/header.php";
?>
	
	<div class="container-fluid bg-light">
		<div class="row">
			<div class="col-md-6 mx-auto">
				<div class="card card-body">
					<h3 class="text-center mb-4">Login</h3>
					<div class="alert alert-danger form-error" id='alert'>
						<a class="close font-weight-light" data-dismiss="alert" href="#">×</a>The E-mail and password did not match.
					</div>
					
					<form id='loginForm' method='post' action='scripts/Login.php'>
						
						<div class='form-group has-success'>
							<label class="label label-default" for='email'>E-mail*:</label>
							<input class="form-control input-lg" type='email' name='email' id='email' placeholder="E-mail"
								required autofocus>
						</div>
						
						<div class='form-group has-success'>
							<label for='password'>Password*:</label>
							<input class="form-control input-lg" type='password' name='password' id='password'
								autocomplete='currentPassword' placeholder="Password" required >
						</div>
						
						<input class="btn btn-lg btn-primary btn-block" value="Log Me In" id='loginBtn' type="submit">
					
					</form>
				
				</div>
			</div>
		</div>
	</div>
	
	<script type='text/javascript'>
		window.onload = () => {
		    const error = document.querySelector('#alert');
			if (window.location.search.substr(1) === 'error') {
				error.classList.remove('form-error');
			}
		}
	</script>

<?php
	include "includes/footer.php";
?>
