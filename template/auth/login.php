<!-- start loader -->
<div id="pageloader-overlay" class="visible incoming">
    <div class="loader-wrapper-outer">
        <div class="loader-wrapper-inner">
            <div class="loader"></div>
        </div>
    </div>
</div>
<!-- end loader -->

<!-- Start wrapper-->
<div class="card card-authentication1 mx-auto my-5">
    <div class="card-body">
        <div class="card-content p-2">
            <div class="text-center">
                <img src="assets/images/unnur.png" alt="logo icon" width="100px">
            </div>
            <div class="card-title text-uppercase text-center py-3">Dashboard Sistemik</div>
            <form method="POST" action="src/auth/authenticate.php">
                <div class="form-group">
                    <label for="exampleInputUsername" class="sr-only">Username</label>
                    <div class="position-relative has-icon-right">
                        <input type="text" name="username" id="exampleInputUsername" class="form-control input-shadow"
                            placeholder="Enter Username">
                        <div class="form-control-position">
                            <i class="icon-user"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword" class="sr-only">Password</label>
                    <div class="position-relative has-icon-right">
                        <input type="password" name="password" id="exampleInputPassword"
                            class="form-control input-shadow" placeholder="Enter Password">
                        <div class="form-control-position">
                            <i class="icon-lock"></i>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-light btn-block">Log In</button>
            </form>
        </div>
    </div>
    <div class="card-footer text-center py-3">
        <?php 
                    if(isset($_SESSION['login_failed'])){
                      echo '<p class="text-warning mb-0">GAGAL LOGIN !!!!</p>';
                    }
                    ?>
    </div>
</div>