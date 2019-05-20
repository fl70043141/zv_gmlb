
<script>
    
    $(document).ready(function(){ 
		event.preventDefault();
           check_show_extras();
        $('#dropdown_id').change(function(){ 
           check_show_extras();
        });
        
        function check_show_extras(){
             if($('#dropdown_id').val() == 6){
                $('#variety_div').show();
            }else{
                $('#variety_div').hide();
            }
        }
    }); 
</script>
<?php
	
	$result = array(
                        'id'=>"",
                        'dropdown_value'=>"", 
                        'dropdown_id'=>"", 
                        'ri_value'=>"", 
                        'sg_value'=>"", 
                        'parent_id'=>"", 
                        'status'=>"1"
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
                            <?php echo form_open_multipart("DropDownList/validate"); ?> 
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong><?=$action?></strong> Customer</h3>
                                </div>
                                 
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row"><h5>Customer Information</h5>
                                         <hr> 
                                     <div class="col-md-6">
                                        
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Dropdown Value<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('dropdown_value', set_value('dropdown_value',$result['dropdown_value']), 'id="dropdown_value" class="form-control" placeholder="Enter Dropdown Value"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('dropdown_value');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                    </div>
                                     <div class="col-md-6">     
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Dropdown Type</label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('dropdown_id',$dropdown_value_list,set_value('dropdown_id',$result['dropdown_id']),' class="form-control select" data-live-search="true" id="dropdown_id"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('dropdown_id');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                    </div>
                                      <div class="col-md-6"> 
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
                                         <div id="variety_div" hidden="hidden">    
                                    <div class="col-md-12">  
                                        <hr>
                                        <div class="col-md-6">     
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Identification Parent</label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('parent_id',$dropdown_identification_list,set_value('parent_id',$result['parent_id']),' class="form-control select" data-live-search="true" id="dropdown_id"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('parent_id');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                         <div class="col-md-12 row">  
                                            <div class="col-md-6"> 
                                               <div class="form-group">
                                                   <label class="col-md-3 control-label">RI<span style="color: red"></span></label>
                                                   <div class="col-md-9">    
                                                       <?php echo form_input('ri_value', set_value('ri_value',$result['ri_value']), 'id="dropdown_value" class="form-control" placeholder="Enter RI Value"'.$dis.' '.$o_dis.' '); ?>
                                                       <span class="help-block"><?php echo form_error('ri_value');?>&nbsp;</span>
                                                   </div> 
                                               </div>
                                           </div>
                                            <div class="col-md-6"> 
                                               <div class="form-group">
                                                   <label class="col-md-3 control-label">SG<span style="color: red"></span></label>
                                                   <div class="col-md-9">    
                                                       <?php echo form_input('sg_value', set_value('sg_value',$result['sg_value']), 'id="sg_value" class="form-control" placeholder="Enter SG Value"'.$dis.' '.$o_dis.' '); ?>
                                                       <span class="help-block"><?php echo form_error('sg_value');?>&nbsp;</span>
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

                                    <?php echo anchor(site_url('DropDownList'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url('DropDownList'),'OK','class="btn btn-primary"');
                                    } ?>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>    