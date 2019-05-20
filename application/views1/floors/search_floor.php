
<script>
    
$(document).ready(function(){  
//	get_results();
    $("#floor_name").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
    $("#hotel").change(function(){ 
		event.preventDefault();
		get_results();
    });
	 
    $("#search_btn").click(function(){
		event.preventDefault();
		get_results();
    });
	
	
	function get_results(){
        $.ajax({
			url: "<?php echo site_url('Floors/search_floor');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_search").html(result);
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
                                    <h3 class="panel-title"><strong>Search</strong> Floors</h3>
                                    <a href="<?php echo base_url('floors/add');?>" class="pull-right btn btn-default"><span class="fa fa-plus"></span> Add New Floor</a>
                                </div>
                                
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                      <?php echo form_input(array('name'=>'floor_name', 'id' => 'floor_name', 'class'=>'form-control','placeholder'=>'serach by Floor Name')); ?>
                                                    </div>                                            
                                                    <!--<span class="help-block">This is sample of text field</span>-->
                                                </div>
                                            </div> 
                                        </div>
                                         
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="col-md-3 control-label">Hotel<span style="color: red">*</span></label>
                                                  <div class="col-md-9">                                            
                                                      <div class="input-group">
                                                          <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                           <?php  echo form_dropdown('hotel',$hotel_list,set_value('hotel'),' class="form-control select" data-live-search="true" id="hotel"');?>
                                                       </div>                                            
                                                      <span class="help-block"><?php echo form_error('hotel');?>&nbsp;</span>
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
                                    <h3 class="panel-title">Hotel List</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    </ul>                                
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Floor Name</th>
                                                <th>Short Name</th>
                                                <th>Hotel</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="result_search">
                                          <?php
                                           $i = 0;
                                            foreach ($floor_list as $row){ 
                                                echo '
                                                    <tr>
                                                        <td>'.($i+1).'</td>
                                                        <td>'.$row['floor_name'].'</td>
                                                        <td>'.$row['short_name'].'</td>
                                                        <td>'.$row['hotel_name'].'</td> 
                                                        <td>
                                                            <a href="'.  base_url('floors/view/'.$row['id']).'"><span class="fa fa-eye"></span></a> |
                                                            <a href="'.  base_url('floors/edit/'.$row['id']).'"><span class="fa fa-pencil"></span></a> |
                                                            <a href="'.  base_url('floors/delete/'.$row['id']).'"><span class="fa fa-trash"></span></a> 
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
