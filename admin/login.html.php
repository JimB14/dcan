<?php
// Include functions
$description = 'Login';
$title = 'Login';
include 'includes/header.php';
include 'includes/helper.php';
?>


<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6 col-md-offset-3 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-xs-offset-1 col-xs-10 col-xs-offset-1">

            <div class="border-box p3 bg-fff">
                <h1 style="margin-bottom:10px;">Log In</h1>

                <?php if (isset($loginError)): ?>
                    <div class="alert alert-danger" role="alert">*<?php htmlout($loginError); ?></div>
                    <p><?php endif; ?></p>

                <form action="" method="post" id="login">
                    <div class="form-group">
                        <label for="email">Email </label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required autofocus>
                    </div><!-- // .form-group -->

                    <div class="form-group">
                        <label for="password">Password </label> 
                        <input type="text" class="form-control" name="password" placeholder="Password" id="password" required>
                    </div><!-- // .form-group -->

                    <button class="btn btn-primary btn-block" type="submit" name="action" value="login">Login</button>
                </form>

                <!--<p><a href=".">Return to home</a></p>-->

            </div><!-- // .box-general -->

        </div><!-- // .col-md-5 -->       
    </div><!-- // .row -->
</div><!-- // .container -->