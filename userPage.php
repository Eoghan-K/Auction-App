<?php
    include "includes/header.php";
    if ( !($GLOBALS[ 'isLoggedIn' ] )) {
        header( 'location: ./login.php' );
    }
?>
    
    <div class="container user-panel">
        <div class="row my-2">
            <div class="col-lg-8 order-lg-2">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Edit Details</a>
                    </li>
                </ul>
                <div class="tab-content py-4">
                    <div class="user-panel tab-pane active" id="profile">
                        <h5 class="mb-3">User Profile</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>About</h6>
                                <p>enter some about info</p>
                            </div>
                            
                            <div class="col-md-12">
                                <h5 class="mt-2"><span class="fa fa-clock-o ion-clock float-right"></span> Recent Auctions</h5>
                                <table class="table table-sm table-hover table-striped">
                                
                                </table>
                            </div>
                        </div>
                    
                    </div>
                    
                    <div class="tab-pane" id="edit">
                        <form class='user-panel' role="form">
                            <div class="form-group row">
                                <label for='firstName' class="col-lg-3 col-form-label form-control-label">First name</label>
                                <div class="col-lg-9">
                                    <input id='firstName' class="form-control" type="text" value="<?php echo $_SESSION[ "firstName" ]; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for='lastName' class="col-lg-3 col-form-label form-control-label">Last name</label>
                                <div class="col-lg-9">
                                    <input id='lastName' class="form-control" type="text" value="<?php echo $_SESSION[ "lastName" ]; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for='email' class="col-lg-3 col-form-label form-control-label">Email</label>
                                <div class="col-lg-9">
                                    <input id='email' class="form-control" type="email" value="<?php echo $_SESSION[ "email" ]; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for='company' class="col-lg-3 col-form-label form-control-label">Company</label>
                                <div class="col-lg-9">
                                    <input id='company' class="form-control" type="text" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for='website' class="col-lg-3 col-form-label form-control-label">Website</label>
                                <div class="col-lg-9">
                                    <input id='website' class="form-control" type="url" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for='address' class="col-lg-3 col-form-label form-control-label">Address</label>
                                <div class="col-lg-9">
                                    <input id='address' class="form-control" type="text" value="<?php echo $_SESSION[ "address" ]; ?>" placeholder="Street">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-6">
                                    <input class="form-control" type="text" value="" placeholder="City">
                                </div>
                                <div class="col-lg-3">
                                    <input class="form-control" type="text" value="" placeholder="State">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for='username' class="col-lg-3 col-form-label form-control-label">Username</label>
                                <div class="col-lg-9">
                                    <input id='username' class="form-control" type="text" value="<?php echo $_SESSION[ "username" ]; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for='password' class="col-lg-3 col-form-label form-control-label">Password</label>
                                <div class="col-lg-9">
                                    <input id='password' class="form-control" type="password" value="11111122333">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for='confirm-password' class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                                <div class="col-lg-9">
                                    <input id='confirm-password' class="form-control" type="password" value="11111122333">
                                </div>
                            </div>
                            <div class="form-group row">
                                <span class="col-lg-3"></span>
                                <div class="col-lg-9">
                                    <input type="reset" class="btn btn-secondary" value="Cancel">
                                    <input type="button" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 order-lg-1 text-center">
                <img
                    src="https://7scqd403m4t19w69bsgcon10-wpengine.netdna-ssl.com/wp-content/uploads/2017/01/team-female-no-image.png"
                    class="mx-auto img-fluid img-circle d-block" alt="avatar">
                <label for='file' class="mt-2">Upload a different photo</label>
                <input id='file' type="file" class="btn" >
            </div>
        </div>
    </div>

<?php
    include "includes/bootstrapScripts.php";

?>