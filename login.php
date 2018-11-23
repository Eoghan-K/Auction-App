<?php
  include "includes/header.php";
?>

<div class="container-fluid bg-light py-3">
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body">
        <h3 class="text-center mb-4">Login</h3>
        <div class="alert alert-danger">
          <a class="close font-weight-light" data-dismiss="alert" href="#">×</a>The E-mail and password did not match.
        </div>

        <form action="scripts/Login.php" method="POST">

          <div class='form-group has-success'>
            <label class="label label-default" for='email'>E-mail*:</label>
            <input class="form-control input-lg" type='email' name='email' id='email' placeholder="E-mail" required autofocus>
          </div>

          <div class='form-group has-success'>
            <label for='password'>Password*:</label>
            <input class="form-control input-lg" type='password' name='password' id='password' placeholder="Pasword" required>
          </div>

          <input class="btn btn-lg btn-primary btn-block" value="Log Me In" type="submit">

        </form>

      </div>
    </div>
  </div>
</div>

<?php
  include "includes/footer.php";
?>
