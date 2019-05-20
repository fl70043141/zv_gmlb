<?php
	
	$result = array(
                        'id'=>"",
                        'hotel_name'=>"",
                        'street_address'=>"",
                        'city'=>"",
                        'state'=>"",
                        'country'=>"",
                        'zipcode'=>"",
                        'phone'=>"",
                        'fax'=>"",
                        'other_phone'=>"",
                        'email'=>"",
                        'website'=>"",
                        'hotel_type'=>"",
                        'hotel_grade'=>"",
                        'reg_no'=>"",
                        'logo'=>"",
                        'status'=>"",
                        );   	
	
	 
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
                            <?php echo form_open_multipart("hotels/validate"); ?> 
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong><?=$action?></strong> User</h3>
                                </div>
                                 
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <h4>Hotel Information</h4>
                                            <hr>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Hotel Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('hotel_name', set_value('hotel_name',$result['hotel_name']), 'id="hotel_name" class="form-control" placeholder="Enter Hotel Name"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('hotel_name');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Street Address<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('street_address', set_value('street_address',$result['street_address']), 'id="street_address" class="form-control" placeholder="Enter Street Address"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('street_address');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">City<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('city', set_value('city',$result['city']), 'id="city" class="form-control" placeholder="Enter city"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('city');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">State</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('state', set_value('state',$result['state']), 'id="state" class="form-control" placeholder="Enter State"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('state');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                              <div class="form-group">
                                                  <label class="col-md-3 control-label">Country<span style="color: red">*</span></label>
                                                  <div class="col-md-9">                                            
                                                      <div class="input-group">
                                                          <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                           <?php  echo form_dropdown('country',$country_list,set_value('country',$result['country']),' class="form-control select" data-live-search="true" id="country"'.$o_dis.'');?>
                                                       </div>                                            
                                                      <span class="help-block"><?php echo form_error('country');?>&nbsp;</span>
                                                  </div>
                                              </div>
                                          </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Zip Code</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('zipcode', set_value('zipcode',$result['zipcode']), 'id="zipcode" class="form-control" placeholder="Enter Zip Code" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('zipcode');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Phone<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('phone', set_value('phone',$result['phone']), 'id="phone" class="form-control" placeholder="Enter Phone Number" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('phone');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Fax</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('fax', set_value('fax',$result['fax']), 'id="fax" class="form-control" placeholder="Enter Fax Number" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('fax');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Other Phone</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('other_phone', set_value('other_phone',$result['other_phone']), 'id="other_phone" class="form-control" placeholder="Enter Secendory Phone Number.." style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('other_phone');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Email</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('email', set_value('email',$result['email']), 'id="email" class="form-control" placeholder="Enter Hotel Email Address.." style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('email');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Web site</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('website', set_value('website',$result['website']), 'id="website" class="form-control" placeholder="Enter Website URL.." style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('website');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         
                                       
                                        <div class="col-md-6">
                                            <h4>Other Information</h4> 
                                                    <hr>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Hotel type<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('hotel_type', set_value('hotel_type',$result['hotel_type']), 'id="hotel_type" class="form-control" placeholder="Enter Hotel Type" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('hotel_type');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Hotel Grade</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('hotel_grade', set_value('hotel_grade',$result['hotel_grade']), 'id="hotel_grade" class="form-control" placeholder="Eg: 3 Star" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('hotel_grade');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Registration No</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('reg_no', set_value('reg_no',$result['reg_no']), 'id="reg_no" class="form-control" placeholder="Enter registraion Number" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('reg_no');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Hotel Logo</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_upload('logo', set_value('logo',$result['logo']), 'id="logo" class="form-control" placeholder="Enter registraion Number" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('logo');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Hotel Active</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('status', set_value('status','1'),$result['status'], 'id="status" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('status');?>&nbsp;</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        

                                </div>
                                <div class="panel-footer">
                                    <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $result['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url('hotels'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url('hotels'),'OK','class="btn btn-primary"');
                                    } ?>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>    