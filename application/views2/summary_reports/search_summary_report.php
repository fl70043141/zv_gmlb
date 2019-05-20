 
<script>
    
$(document).ready(function(){ 
    
	get_results();
    $("#report_no").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
    
    $("#status").click(function(){  
//		event.preventDefault();
		get_results();
    });
    
    $("#search_btn").click(function(){  
//		event.preventDefault();
		get_results();
    });
	  report_interface_set();
    
    $("#rep_type").change(function(){  
        report_interface_set();
    });
    $("#customer").change(function(){  
        get_results();
    });
    
    function report_interface_set(){
        var rep_type = $('#rep_type').val();
        switch (rep_type) {
                        case 'daily':        

                                $('#daily_div').show();
                                $('#date_monthly').val('');
                                $('#monthly_div').hide();
                                $('#date_yearly').val('');
                                $('#yearly_div').hide();
                                break;
                                
                        case 'monthly':
                                $('#monthly_div').show();
                                $('#date').val('');
                                $('#daily_div').hide();
                                $('#date_yearly').val('');
                                $('#yearly_div').hide();
                                break;
                                
                        case 'annual':
                                $('#yearly_div').show();
                                $('#date').val('');
                                $('#daily_div').hide();
                                $('#date_monthly').val('');
                                $('#monthly_div').hide();
                                break;
                            
                        default:
                            
                            break;
                    }
    }
	
	function get_results(){
                 $.ajax({
			url: "<?php echo site_url('summaryReports/search_summary_report');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_search").html(result);
                             
                              $('.datatable').DataTable();
                            }
                });
	}
        
        $("#date_monthly").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        
        $("#date_year").datepicker( {
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years"
        });
});
</script>
 


<div class="row">
<div class="col-md-12">
                             
			<?php echo form_open("summaryReports/generate_pdf", 'target="_blank" id="form_search" class="form-horizontal"')?>               
                                
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
                                    <h3 class="panel-title"><strong>Search</strong> Lab Reports</h3>
                                    <a href="<?php echo base_url('Reports/add');?>" class="pull-right btn btn-default"><span class="fa fa-plus"></span> Add New Report</a>
                                </div>
                                
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        <h5>Select Columns</h5>
                                          
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Report Columns</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="form-group">  
                                                                <?php  echo form_multiselect('report_columns[]',$report_cols,$report_cols_selected, ' id="report_columns" class="form-control select" multiple data-live-search="true"  ');?> 

                                                        </div>                                            
                                                        <!--<span class="help-block">This is sample of text field</span>-->
                                                    </div>
                                                </div> 
                                            </div>
                                          
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Report Type</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="form-group">  
                                                                <?php echo form_dropdown('rep_type',array('daily'=>'Daily Report','monthly'=>'Monthly Report','annual'=>'Annually',),'daily', ' id="rep_type" class="form-control select"  data-live-search="true"  ');?> 

                                                        </div>                                            
                                                        <!--<span class="help-block">This is sample of text field</span>-->
                                                    </div>
                                                </div> 
                                            </div>
                                    </div>
                           <hr>
                                    <div class="row">
                                        <h5>Search Criteria</h5>

                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Report Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                      <?php echo form_input(array('name'=>'report_no', 'id' => 'report_no', 'class'=>'form-control','placeholder'=>'serach by Report Number')); ?>
                                                    </div>                                            
                                                    <!--<span class="help-block">This is sample of text field</span>-->
                                                </div>
                                            </div> 
                                        </div>

                                        <div id="daily_div" class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Date</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                      <?php echo form_input(array('name'=>'date', 'id' => 'date', 'class'=>'form-control datepicker','placeholder'=>'Select Date','readonly'=>'readonly')); ?>
                                                    </div>                                             
                                                </div>
                                            </div> 
                                        </div>

                                         <div id="monthly_div" class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Date Month </label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                      <?php echo form_input(array('name'=>'date_monthly', 'id' => 'date_monthly', 'class'=>'form-control datepicker','placeholder'=>'Select Date','readonly'=>'readonly')); ?>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div> 
                                        </div>

                                         <div id="yearly_div" class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Date Year </label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                      <?php echo form_input(array('name'=>'date_year', 'id' => 'date_year', 'class'=>'form-control datepicker','placeholder'=>'Select Date','readonly'=>'readonly')); ?>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div> 
                                        </div>
                                       
                                         <hr>
                                         <br>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Customer</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                       <?php echo form_dropdown('customer',$customer_list, set_value('customer'),' class="form-control select" data-live-search="true" id="customer"');?> 

                                                    </div>                                            
                                                    <!--<span class="help-block">This is sample of text field</span>-->
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
                                    <button type="submit" class="pull-right btn-success btn">Print Report</button> 
                                    <a id="search_btn" class="btn btn-primary pull-right"><span class="fa fa-search"></span>Search</a>
                                </div>
                            </div>
                            <?php echo form_close(); ?>               
                                    
                         
                            
                        </div>
     <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    <h3 class="panel-title">Report List</h3>
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
                                                <th>Report Number</th>
                                                <th>Identification</th>
                                                <th>Weight</th>
                                                <th>Shape</th> 
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                           $i = 0;
                                            foreach ($report_list as $row){ 
                                                echo '
                                                    <tr>
                                                        <td>'.($i+1).'</td>
                                                        <td>'.$row['report_no'].'</td>
                                                        <td>'.$row['identification'].'</td>
                                                        <td>'.$row['weight'].'</td>
                                                        <td>'.$row['shape'].'</td> 
                                                        <td>
                                                            <a href="'.  base_url('reports/view/'.$row['id']).'"><span class="fa fa-eye"></span></a> |
                                                            <a href="'.  base_url('reports/edit/'.$row['id']).'"><span class="fa fa-pencil"></span></a> |
                                                            <a href="'.  base_url('reports/delete/'.$row['id']).'"><span class="fa fa-trash"></span></a> 
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
