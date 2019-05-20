<?php 
//$this->load->view('includes/pg_hdr');
	  	
	$result = array('auth_id'=>"",'first_name'=>"", 'last_name' => "", 'email' => "", 'tel' => "", 'user_name' => "", 'password' => "",  'confirm_password' => "", 'user_role_id' => "", 'status' => ""); 
	 
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Edit':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Delete':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
		$check_bx_dis		= 'disabled'; 
	break;
      
	case 'View':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'View';
		$view		= 'hidden';
		$dis        = 'readonly';
		$o_dis		= 'disabled'; 
	break;
endswitch;	 

//var_dump($result);
?>
 <div class="row">
                        <div class="col-md-12">
                            
                            <!--Flash Error Msg-->
                             <?php  if($this->session->flashdata('error') != ''){ ?>
					<div class='alert alert-danger ' id="msg2">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<i ></i>&nbsp;<?php echo $this->session->flashdata('error'); ?>
					<script>jQuery(document).ready(function(){jQuery('#msg2').delay(3000).slideUp(2000);});</script>
					</div>
				<?php } ?>
				
					<?php  if($this->session->flashdata('warn') != ''){ ?>
					<div class='alert alert-success ' id="msg2">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<i ></i>&nbsp;<?php echo $this->session->flashdata('warn'); ?>
					<script>jQuery(document).ready(function(){jQuery('#msg2').delay(3000).slideUp(2000);});</script>
					</div>
				<?php } ?>  
                            
                            
                            <br>
                            <?php echo form_open("users/validate"); ?> 
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong><?=$action?></strong> User</h3>
                                </div>
                                 
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">First Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                         <?php echo form_input('first_name', set_value('first_name',$result['first_name']), 'id="first_name" class="form-control" placeholder="Enter First Name"'.$dis.' '.$o_dis.' '); ?>
							
                                                    </div>                                            
                                                    <span class="help-block"><?php echo form_error('first_name');?></span>
                                                </div>
                                            </div>
                                        </div>
                                         
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Last Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                         <?php echo form_input('last_name', set_value('last_name',$result['last_name']), 'id="last_name" class="form-control" placeholder="Enter Last Name"'.$dis.' '.$o_dis.' '); ?>
							
                                                    </div>                                            
                                                    <span class="help-block"><?php echo form_error('last_name');?>&nbsp;</span>
                                                </div>
                                            </div>
                                        </div>
                                         
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span>@</span></span>
                                                         <?php echo form_input('email', set_value('email',$result['email']), 'id="email" class="form-control" placeholder="Enter Email addreess"'.$dis.' '.$o_dis.' '); ?>
                                                     </div>                                            
                                                    <span class="help-block"><?php echo form_error('email');?>&nbsp;</span>
                                                </div>
                                            </div>
                                        </div>
                                          
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Contact Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                         <?php echo form_input('contact', set_value('contact',$result['tel']), 'id="email" class="form-control" placeholder="Enter Contact number"'.$dis.' '.$o_dis.' '); ?>
                                                     </div>                                            
                                                    <span class="help-block"><?php echo form_error('contact');?>&nbsp;</span>
                                                </div>
                                            </div>
                                        </div>
                                         
                                    </div>
                                    <hr>
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">User Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                         <?php echo form_input('username', set_value('username',$result['user_name']), 'id="username" class="form-control" placeholder="User Name"'.$dis.' '.$o_dis.' '); ?>
                                                     </div>                                            
                                                    <span class="help-block"><?php echo form_error('username');?>&nbsp;</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                          
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">User Role</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                         <?php  echo form_dropdown('user_role',$user_role_list,set_value('user_role',$result['user_role_id']),' class="form-control select" data-live-search="true" id="user_role"'.$o_dis.'');?>
                                                     </div>                                            
                                                    <span class="help-block"><?php echo form_error('user_role');?>&nbsp;</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Password</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-lock"></span></span>
                                                         <?php echo form_password('password', set_value('password'), 'id="password" class="form-control" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                     </div>                                            
                                                    <span class="help-block"><?php echo form_error('password');?>&nbsp;</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Confirm Password</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-lock"></span></span>
                                                         <?php echo form_password('confirm_password', set_value('confirm_password'), 'id="confirm_password" class="form-control"  style="z-index: 1;"  placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                     </div>                                            
                                                    <span class="help-block"><?php echo form_error('confirm_password');?>&nbsp;</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">User Active</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                         <label class="switch  switch-small">
                                                            <!--<input type="checkbox"  value="0">-->
                                                            <?php echo form_checkbox('status', set_value('status','1'), 'id="status" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                            <span></span>
                                                        </label>
                                                     </div>                                            
                                                    <span class="help-block"><?php echo form_error('status');?>&nbsp;</span>
                                                </div>
                                            </div>
                                        </div>
                                        

                                </div>
                                <div class="panel-footer">
                                    <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('user_id', $result['auth_id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url('users'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url('users'),'OK','class="btn btn-primary"');
                                    } ?>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>    