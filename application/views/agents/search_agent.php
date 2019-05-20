<style>
   .select2-dropdown {
  z-index: 9001;
}
    
</style>
<script>
    
$(document).ready(function(){  
//	get_results();
    $("#agent_name").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
    $("#agent_type").change(function(){ 
		event.preventDefault();
		get_results();
    }); 
    $("#status").click(function(){  
//		event.preventDefault();
		get_results();
    });
	  
	
	function get_results(){
                 $.ajax({
			url: "<?php echo site_url('Agents/search_agent');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_search").html(result);
                             
                              $('.datatable').DataTable();
                            }
                });
	}
});
</script>
 


<div class="row">
<div class="col-md-12">
                             
			<?php echo form_open("", 'id="form_search" class="form-horizontal"')?>               
                                
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
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title"><strong>Search</strong> Customer / Agent</h3>
                                    <a href="<?php echo base_url('agents/add');?>" class="pull-right btn btn-default"><span class="fa fa-plus"></span> Add New Customer</a>
                                </div>
                                
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                      <?php echo form_input(array('name'=>'agent_name', 'id' => 'agent_name', 'class'=>'form-control','placeholder'=>'serach by Agent Name')); ?>
                                                    </div>                                            
                                                    <!--<span class="help-block">This is sample of text field</span>-->
                                                </div>
                                            </div> 
                                        </div>
                                         
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="col-md-3 control-label">Customer Type</label>
                                                  <div class="col-md-9">                                            
                                                      <div class="input-group col-md-12" >
                                                          <!--<span class="input-group-addon"><span class="fa fa-search"></span></span>-->
                                                           <?php  echo form_dropdown('agent_type',$agent_type_list,set_value('agent_type'),' class="form-control select" data-live-search="true" id="agent_type"');?>
                                                       </div>                                            
                                                      <span class="help-block"><?php echo form_error('agent_type');?>&nbsp;</span>
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
                                                                <?php echo form_checkbox('status', set_value('status','1'),TRUE, 'id="status" placeholder=""'); ?>
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
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <a id="search_btn" class="btn btn-primary pull-right"><span class="fa fa-search"></span>Search</a>
                                </div>
                            </div>
                            <?php echo form_close(); ?>               
                                    
                         
                            
                        </div>
     <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    <h3 class="panel-title">Customer List</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    </ul>                                
                                </div>
                                <div  id="result_search" class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Agent</th>
                                                <th>Short Name</th>
                                                <th>Type</th>
                                                <th>City</th>
                                                <th>Contact</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                          <?php
                                           $i = 0;
                                            foreach ($agent_list as $row){ 
                                                echo '
                                                    <tr>
                                                        <td>'.($i+1).'</td>
                                                        <td>'.$row['agent_name'].'</td>
                                                        <td>'.$row['short_name'].'</td>
                                                        <td>'.$row['agent_type_name'].'</td> 
                                                        <td>'.$row['city'].'</td> 
                                                        <td>'.$row['phone'].'</td> 
                                                        <td>
                                                            <a href="'.  base_url('agents/view/'.$row['id']).'"><span class="fa fa-eye"></span></a> |
                                                            <a href="'.  base_url('agents/edit/'.$row['id']).'"><span class="fa fa-pencil"></span></a> |
                                                            <a href="'.  base_url('agents/delete/'.$row['id']).'"><span class="fa fa-trash"></span></a> 
                                                        </td>  ';
                                                $i++;
                                            }
                                           ?>  
                                             
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END DEFAULT DATATABLE -->

     </div>
</div>
