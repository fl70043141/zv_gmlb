<?php
	
	$result = array(
                        'id'=>"",
                        'floor_name'=>"",
                        'short_name'=>"",
                        'hotel_id'=>"",
                        'descreption'=>"",
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
                            <?php echo form_open_multipart("floors/validate"); ?> 
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong><?=$action?></strong> Floor</h3>
                                </div>
                                 
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Floor Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('floor_name', set_value('floor_name',$result['floor_name']), 'id="floor_name" class="form-control" placeholder="Enter Floor Name"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('floor_name');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Short Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('short_name', set_value('short_name',$result['short_name']), 'id="short_name" class="form-control" placeholder="Enter Street Address"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('short_name');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="col-md-3 control-label">Hotel<span style="color: red">*</span></label>
                                                  <div class="col-md-9">                                            
                                                      <div class="input-group">
                                                          <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                           <?php  echo form_dropdown('hotel_id',$hotel_list,set_value('hotel_id',$result['hotel_id']),' class="form-control select" data-live-search="true" id="hotel_id"'.$o_dis.'');?>
                                                       </div>                                            
                                                      <span class="help-block"><?php echo form_error('hotel_id');?>&nbsp;</span>
                                                  </div>
                                              </div>
                                          </div>
                                        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Description</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group"> 
                                                             <?php echo form_textarea('descreption', set_value('descreption',$result['descreption']), 'id="descreption"  class="form-control" placeholder="Enter descreption"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('descreption');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Floor Active</label>
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
                                <div class="panel-footer">
                                    <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $result['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url('floors'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url('floors'),'OK','class="btn btn-primary"');
                                    } ?>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>    