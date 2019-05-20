<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>BGL System</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
<!--        <link rel="icon" href="<?php echo base_url('templates/favicon.ico'); ?>" type="image/x-icon" />-->
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo  base_url('templates/css/theme-default.css'); ?>"/>
        <!-- EOF CSS INCLUDE -->                                     
    </head>
    <body>
        
        <div class="login-container lightmode" style="background: #ab871636;">
        
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                    <div style="color:#ac8a1d;" class="login-title"><strong>Log In</strong> to BGL System</div>
                   	<?php echo form_open('login/authenticate','id="signin-form_id" class="form-horizontal"'); ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="uname" class="form-control" placeholder="E-mail"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" name="password" class="form-control" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>
                        <div class="col-md-6">
                            <button style="background-color:#ac8a1d; border-color: #bdaa6e;" type="submit" name="login_btn" class="btn btn-info btn-block">Log In</button>
                        </div>
                    </div>
                      
       	<?php echo form_close(); ?>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        &copy; <?php echo date('Y'); ?> Zone Venture Software Solution.
                    </div>
<!--                    <div class="pull-right">
                        <a href="#">About</a> |
                        <a href="#">Privacy</a> |
                        <a href="#">Contact Us</a>
                    </div>-->
                </div>
            </div>
            
        </div>
        
    </body>
</html>






