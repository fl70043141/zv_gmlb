
<script>
    
    $(document).ready(function(){ 
		event.preventDefault();
        $('.select_field').click(function(){ 
       
        });
    }); 
</script>
<?php
	
	$result = array(
                        'id'=>"",
                        'agent_name'=>"",
                        'short_name'=>"",
                        'agent_type_id'=>"",
                        'description'=>"",
                        'reg_no'=>"",
                        'hotel_representative'=>"",
                        'address'=>"",
                        'city'=>"",
                        'state'=>"",
                        'postal_code'=>"",
                        'country'=>"",
                        'contact_person'=>"",
                        'phone'=>"",
                        'fax'=>"",
                        'email'=>"",
                        'website'=>"",
                        'commision_plan'=>"1",
                        'commission_value'=>"0",
                        'credit_limit'=>"0",
                        'status'=>""
                        );   	
	
	 
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Edit':
		if(!empty($property_data[0])){$result= $property_data[0];} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Delete':
		if(!empty($property_data[0])){$result= $property_data[0];} 
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
		$check_bx_dis		= 'disabled'; 
	break;
      
	case 'View':
		if(!empty($property_data[0])){$result= $property_data[0];} 
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
                            <?php echo form_open_multipart("agents/validate"); ?> 
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong><?=$action?></strong> Customer</h3>
                                </div>
                                 
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                        
                                         <h5>Customer Information</h5>
                                         <hr> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Customer Name<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('agent_name', set_value('agent_name',$result['agent_name']), 'id="agent_name" class="form-control" placeholder="Enter Business Agent Name"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('agent_name');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Short Name<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('short_name', set_value('short_name',$result['short_name']), 'id="short_name" class="form-control" placeholder="Enter Street Address"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('short_name');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Customer Type<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('agent_type_id',$agent_type_list,set_value('agent_type_id',$result['agent_type_id']),' class="form-control select" data-live-search="true" id="agent_type_id" '.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('agent_type_id');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                         
                                           
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group"> 
                                                        
                                                         <?php echo form_textarea(array('name'=>'description','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter description' ),$result['description'],$dis.' '.$o_dis.' '); ?>

                                                    </div>                                            
                                                    <span class="help-block"><?php echo form_error('description');?><br></span>
                                                </div>
                                            </div> 
                                            
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Reg Number</label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('reg_no', set_value('reg_no',$result['reg_no']), 'id="reg_no" class="form-control" placeholder="Enter Registration Number"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('reg_no');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                         
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Active</label>
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
                                         
                                          <h5>Contact Information</h5>
                                         <hr> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Phone<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('phone', set_value('phone',$result['phone']), 'id="phone" class="form-control" placeholder="Enter Phone Number"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('phone');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Fax</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('fax', set_value('fax',$result['fax']), 'id="fax" class="form-control" placeholder="Enter Fax Number"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('fax');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('email', set_value('email',$result['email']), 'id="email" class="form-control" placeholder="Enter Email Address"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('email');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Website</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('website', set_value('website',$result['website']), 'id="website" class="form-control" placeholder="Enter Website URL"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('website');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                             
                                     </div>
                                        
                                        
                                    <div class="col-md-6">
                                       <h5>Address Information </h5>
                                       <hr>    
                                             
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Street Address<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('address', set_value('address',$result['address']), 'id="address" class="form-control" placeholder="Enter Street Address"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('address');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                             
                                            
                                            <div class="form-group col-md-12">
                                                <div class="col-md-7">
                                                    <label class="col-md-5 control-label">City<span style="color: red">*</span></label>
                                                    <div class="col-md-7">    
                                                         <?php echo form_input('city', set_value('city',$result['city']), 'id="city" class="form-control" placeholder="Enter City"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('city');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                
                                                <div class="col-md-5">
                                                    <label class="col-md-4 control-label">Postcode</label>
                                                    <div class="col-md-8">    
                                                         <?php echo form_input('postal_code', set_value('postal_code',$result['postal_code']), 'id="postal_code" class="form-control" placeholder="Enter Postal Code"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('postal_code');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                       
                                       
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">State</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('state', set_value('state',$result['state']), 'id="state" class="form-control" placeholder="Enter State Province"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('state');?>&nbsp;</span>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Country</label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('country',$country_list,set_value('country',$result['country']),' class="form-control select" data-live-search="true" id="country"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('country');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                       
                                    </div>
                                            
                                       
                                    <div class="col-md-6 ">
                                       <h5>Commissions </h5>
                                       <hr>         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Plan</label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('commision_plan',array(''=>'Select Commission Plan','1'=>'% Percentage','2'=>'Fixed Amount'),set_value('commision_plan',$result['commision_plan']),' class="form-control select" data-live-search="true" id="commision_plan"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('commision_plan');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                       
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Value</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('commission_value', set_value('commission_value',$result['commission_value']), 'id="commission_value" class="form-control" placeholder="Enter Commission Amount or Value"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('commission_value');?>&nbsp;</span>
                                                    </div>
                                            </div>
                                       
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Credit Limit</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('credit_limit', set_value('credit_limit',$result['credit_limit']), 'id="credit_limit" class="form-control" placeholder="Enter Credit Limit"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('credit_limit');?>&nbsp;</span>
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

                                    <?php echo anchor(site_url('agents'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url('agents'),'OK','class="btn btn-primary"');
                                    } ?>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>    