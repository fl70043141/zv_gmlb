
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
                        'property_name'=>"",
                        'short_name'=>"",
                        'property_type_id'=>"",
                        'tarrif_type_id'=>"",
                        'time_base_id'=>"",
                        'hotel_id'=>"",
                        'floor_id'=>"",
                        'description'=>"",
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
                            <?php echo form_open_multipart("property/validate"); ?> 
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong><?=$action?></strong> Property</h3>
                                </div>
                                 
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                        
                                         <h5>Property Information</h5>
                                         <hr> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Property Name<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('property_name', set_value('property_name',$result['property_name']), 'id="property_name" class="form-control" placeholder="Enter Property Name"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('property_name');?>&nbsp;</span>
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
                                                <label class="col-md-3 control-label">Property Type<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('property_type_id',$property_type_list,set_value('property_type_id',$result['property_type_id']),' class="form-control select" data-live-search="true" id="property_type_id"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('property_type_id');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                         
                                           
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group"> 
                                                         <?php echo form_textarea('description', set_value('description',$result['description']), 'id="description"  class="form-control" placeholder="Enter description"'.$dis.' '.$o_dis.' '); ?>

                                                    </div>                                            
                                                    <span class="help-block"><?php echo form_error('description');?></span>
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
                                             
                                     </div>
                                        
                                        
                                    <div class="col-md-6">
                                       <h5>Tariff </h5>
                                       <hr>    
                                             
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Tariff Type<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('tarrif_type_id',$tarrif_type_list,set_value('tarrif_type_id',$result['tarrif_type_id']),' class="form-control select" data-live-search="true" id="tarrif_type_id"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('tarrif_type_id');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                             
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Time Base<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('time_base_id',$time_base_list,set_value('time_base_id',$result['time_base_id']),' class="form-control select" data-live-search="true" id="time_base_id"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('time_base_id');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                       
                                        
                                    </div>
                                            
                                       
                                    <div class="col-md-6 ">
                                       <h5>Hotel </h5>
                                       <hr>         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Hotel<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('hotel_id',$hotel_list,set_value('hotel_id',$result['hotel_id']),' class="form-control select" data-live-search="true" id="hotel_id"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('hotel_id');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                       
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Floor</label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('floor_id',$floor_list,set_value('floor_id',$result['floor_id']),' class="form-control select" data-live-search="true" id="floor_id"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('floor_id');?>&nbsp;</span>
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

                                    <?php echo anchor(site_url('property'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url('property'),'OK','class="btn btn-primary"');
                                    } ?>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>    