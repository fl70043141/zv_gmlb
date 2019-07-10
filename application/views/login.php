<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title><?php echo SYSTEM_NAME; ?></title>            
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
                <div style="text-align: center;margin-bottom: 10px;"><img src="<?php echo base_url(COMPANY_LOGO.'/logo_1.png'); ?>"></div>
                <div class="login-body">
                    <div style="color:#5f8bb785;" class="login-title"><strong>Log In</strong> to <?php echo SYSTEM_NAME; ?></div>
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
                            <button style="background-color:#2064a8c4; border-color: #5f8bb785;" type="submit" name="login_btn" class="btn btn-info btn-block">Log In</button>
                        </div>
                    </div>
                      
       	<?php echo form_close(); ?>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        &copy; <?php echo date('Y'); ?> <?php echo SYSTEM_POWERED_BY; ?>
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






