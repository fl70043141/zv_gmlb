
<script>
    
    $(document).ready(function(){ 
		event.preventDefault(); 
        $('#variety').change(function(){  
            get_ri_sg();
        });
        $('#load_ri_sg').click(function(){  
            alert();
            get_ri_sg();
        });
        $('#identification').change(function(){  
            get_variety_drpdwn();
        });
        $('#comments1').change(function(){  
            $('#comments').val($('#comments1').val());
        });
        $('#phenomonon1').change(function(){   
            $('#phenomonon').val($('#phenomonon1').val());
        });
        
        function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
//                alert(input.id);

                    reader.onload = function (e) {
                        if(input.id=='pic1'){
                            $('#img_1').attr('src', e.target.result);
                        }
                        if(input.id=='pic2'){
                            $('#img_2').attr('src', e.target.result);
                        }
                        if(input.id=='pic3'){
                            $('#img_3').attr('src', e.target.result);
                        }
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".fl_file").change(function(){
                readURL(this);
            });
            
            $('.thumbnail').click(function(){ 
                      var title = $(this).parent('a').attr("src");
                      $(".model_img").attr("src",this.src); 
                      $('#myModal').modal({show:true});
                      
              }); 
              
              function get_ri_sg(){
                  var var_drp_dwn= parseInt($('#variety').val()); 
                    $.ajax({
                           url: "<?php echo site_url('reports/get_ri_sg_for_variety');?>",
                           type: 'post',
                           data : {drp_dwn_id: var_drp_dwn},
                           success: function(result){
                                   var obj = JSON.parse(result);
                                   $('#ri_text_value').val(obj['ri_value']);
                                   $('#sg_text_value').val(obj['sg_value']); 
                               }
                   });
                   }
              function get_variety_drpdwn(){
                  var idnfcn_id = parseInt($('#identification').val()); 
                    $.ajax({
                           url: "<?php echo site_url('reports/get_dropdown_variety_data');?>",
                           type: 'post',
                           data : {idnfcn_id: idnfcn_id},
                           success: function(result){
                                var obj1 = JSON.parse(result);
                                $('#variety').empty();
                                var $select = $('#variety');
                                $(obj1).each(function (index, o) {    
                                     var $option = $("<option/>").attr("value", o.id).text(o.dropdown_value);
                                     $select.append($option);
                                 });
                                $('#variety').select2(); 
                               }
                   });
                   
	}
        
            $("#single_sync").click(function(){
//                single_report_sync();
            });
              function single_report_sync(){
                   alert($('input[name=id]').val())
                   $.ajax({
                           url: "<?php echo site_url('ReportSync/sync_local_remote');?>",
                           type: 'post',
                           data : {syngle_report_id: $('input[name=id]').val()},
                           success: function(result){
                               
                               }
                   });
                   }
    }); 
</script>
<style>
    .modal-dialog {width:800px;}
    .thumbnail {margin-bottom:6px;}
    .modal-body {width:800px; align:center;}
    .model_img {width: 500px;}
</style>
<?php
	
	$result = array(
                        'id'=>"",
                        'report_no'=>"",
                        'customer_id'=>"",
                        'report_date'=>date('Y-m-d'),
                        'gem_type'=>3,
                        'spec_cost'=>3,
                        'object'=>"",
                        'report_issued'=>"",
                        'identification'=>"",
                        'variety'=>"",
                        'weight'=>"",
                        'dimension'=>"",
                        'cut'=>"",
                        'polish'=>"",
                        'shape'=>"",
                        'color'=>"",
                        'color_distribution'=>"",
                        'show_color_distribution'=>"",
                        'transparency'=>"",
                        'comments'=>"",
                        'appendix'=>"",
                        'phenomonon'=>"",
                        'treatment'=>"",
                        'origin'=>"--",
                        'show_origin'=>"0",
                        'refractive_index'=>"",
                        'ri_text_value'=>"",
                        'specific_gravity'=>"",
                        'sg_text_value'=>"",
                        'hardness'=>"",
                        'optical_character'=>"",
                        'plechroism'=>"",
                        'absorption_spectrum'=>"",
                        'fluorebcence'=>"",
                        'magnification'=>"",
                        'special_note'=>"", 
                        'pic1'=>'../../other/no_image.png',   
                        'pic2'=>'../../other/no_image.png',   
                        'pic3'=>'../../other/no_image.png',   
                        'status'=>1,
                        'sync_required'=>"1",
                        );   	
	
	 $view_add = '';
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
                $view_add       = 'hidden';
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
		$dis            = 'readonly';
		$o_dis		= 'disabled'; 
	break;
endswitch;	 

//Image Set up, if there is no image
if($result['pic1']==''){
    $result['pic1'] = '../../other/no_image.png';
}
if($result['pic2']==''){
    $result['pic2'] = '../../other/no_image.png';
}
if($result['pic3']==''){
    $result['pic3'] = '../../other/no_image.png';
}
$result['sync_required'] =1;
// echo '<pre>'; print_r($result['sync_required']); die;
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
                            <?php echo form_open_multipart("reports/validate", 'id="form_report"'); ?> 
                            <div class="panel panel-default">
                                <div class="panel-heading">
								&nbsp; <?php echo anchor(site_url('reports/add'),'Add New Report','class="btn btn-primary pull-right"');?>&nbsp;
                                                                 &nbsp;  <a id="single_sync" class="btn hide btn-warning pull-right"><span class="fa fa-retweet"></span> Sync</a>&nbsp;
                                    <h3 class="panel-title"><strong><?=$action?></strong> BGL Report</h3>
                                </div>
                                 
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                        
                                         <h5>General</h5>
                                         <hr> 
                                         <div <?php echo $view_add;?> class="form-group">
                                            
                                                <label class="col-md-3 control-label">Report No<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('report_no', set_value('report_no',$result['report_no']), 'id="report_no" class="form-control" placeholder="Auto Generated.." '.$dis.' '.$o_dis.' readonly'); ?>
                                                    <span class="help-block"><?php echo form_error('report_no');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            
                                         <div class="form-group">
                                                <label class="col-md-3 control-label">Issued (Report Type)</label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('report_issued',array(1=>'ID Report',2=>'Large Report',3=>'Both ID & Large Reports'),set_value('report_issued',$result['report_issued']),' class="form-control select" data-live-search="true" id="report_issued"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('report_issued');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                         <div class="form-group">
                                                <label class="col-md-3 control-label">Customer</label>
                                                <div class="col-md-8">    
                                                     <?php  echo form_dropdown('customer',$customer_list,set_value('customer',$result['customer_id']),' class="form-control select" data-live-search="true" id="origin"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('customer');?>&nbsp;</span>
                                                </div> 
                                                <div class="col-md-1" >
                                                    <a href="<?php echo base_url('agents/add'); ?>"><span style="font-size: 25px;" class="fa fa-plus-circle"></span></a>
                                                </div> 
                                            </div>
                                            
                                         <div class="form-group">
                                                <label class="col-md-3 control-label">Object Type (Report Type)</label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('gem_type',$gem_type_list,set_value('gem_type',$result['gem_type']),' class="form-control select" data-live-search="true" id="origin"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('gem_type');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            
                                         <div class="form-group">
                                                <label class="col-md-3 control-label">Special (Optional)</label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('spec_cost',$spec_cost_list,set_value('spec_cost',$result['spec_cost']),' class="form-control select" data-live-search="true" id="origin"'.$o_dis.'');?> 
                                                     <span class="help-block"><?php echo form_error('spec_cost');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Date<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('report_date', set_value('report_date',$result['report_date']), 'id="report_date" class="form-control datepicker" placeholder="Select Report Date..."'.$dis.' '.$o_dis.' readonly'); ?>
                                                    <span class="help-block"><?php echo form_error('report_date');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                         
                                            <div class="form-group"> <!--Object-->
                                                <label class="col-md-3 control-label">Item<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_dropdown('object',$item_list_dpd,set_value('object',$result['object']),' class="form-control select" data-live-search="true" id="object" '.$o_dis.'');?> 
                                                    <?php // echo form_input('object', set_value('object',$result['object']), 'id="object" class="form-control" placeholder="Enter Object..."'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('object');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                         
                                            
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Identification<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_dropdown('identification',$identification_list_dpd, set_value('identification',$result['identification']),' class="form-control select" data-live-search="true" id="identification" '.$o_dis.'');?> 
                                                     <?php // echo form_input('identification', set_value('identification',$result['identification']), 'id="identification" class="form-control" placeholder="Enter identification"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('identification');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Variety<span style="color: red">*</span> &nbsp;<i id="load_ri_sg" class="fa fa-refresh"></i></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_dropdown('variety',$variety_list_dpd, set_value('variety',$result['variety']),' class="form-control " data-live-search="true" id="variety" '.$o_dis.'');?>
                                                    <?php // echo form_input('variety', set_value('variety',$result['variety']), 'id="variety" class="form-control" placeholder="Enter Stone Variety"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('variety');?>&nbsp;</span>
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
                                         
                                                <div  hidden class="form-group">
                                                    <label class="col-md-3 control-label">Synchronization Required</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('sync_required', set_value('sync_required','1'),$result['sync_required'], 'id="sync_required" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <?php // echo form_checkbox('sync_required', set_value('sync_required','1'),$result['sync_required'], 'id="sync_required" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('sync_required');?>&nbsp;</span>
                                                    </div>
                                                </div> 
                                         
                                          <h5>Physical Data</h5>
                                         <hr> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Weight<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('weight', set_value('weight',$result['weight'],false), 'id="weight" class="form-control" placeholder="Enter Carat Weight"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('weight');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Dimensions<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('dimension', set_value('dimension',$result['dimension'],false), 'id="dimension" class="form-control" placeholder="Enter Dimension of Stone"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('dimension');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Shape<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_dropdown('shape',$shape_list_dpd, set_value('shape',$result['shape']),' class="form-control select" data-live-search="true" id="shape" '.$o_dis.'');?> 
                                                     <?php // echo form_input('shape', set_value('shape',$result['shape']), 'id="shape" class="form-control" placeholder="Enter Shape"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('shape');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cut<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_dropdown('cut',$cut_list_dpd, set_value('cut',$result['cut']),' class="form-control select" data-live-search="true" id="cut" '.$o_dis.'');?> 
                                                     <?php // echo form_input('cut', set_value('cut',$result['cut']), 'id="cut" class="form-control" placeholder="Enter cut.."'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('cut');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Transparency</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('transparency', set_value('transparency',$result['transparency']), 'id="color" class="form-control" placeholder="Enter Stone Transparency"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('transparency');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Color</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('color', set_value('color',$result['color']), 'id="color" class="form-control" placeholder="Enter Stone color"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('color');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group"> <!--COLOR DISTRIBTION-->
                                                <label class="col-md-3 control-label">Color Type</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_dropdown('color_distribution',$color_type_list_dpd, set_value('color_distribution',$result['color_distribution']),' class="form-control select" data-live-search="true" id="color_distribution" '.$o_dis.'');?> 
                                                     <?php // echo form_input('color_distribution', set_value('color_distribution',$result['color_distribution']), 'id="color_distribution" class="form-control" placeholder="Enter Stone Color Distribution"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_checkbox('show_color_distribution', set_value('show_color_distribution','1'),$result['show_color_distribution'], 'id="show_color_distribution" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                    Show<span class="help-block"><?php echo form_error('color_distribution');?>&nbsp;</span>

                                                </div> 
                                            </div>
                                       <div class="form-group">
                                                    <label class="col-md-3 control-label">Phenomenon</label>
                                                    <div class="col-md-9">  <?php echo form_dropdown('phenomonon1',$phenomonon_list, set_value('phenomonon1'),' class="form-control select" data-live-search="true" id="phenomonon1" '.$o_dis.'');?> 
                                                     
                                                       <div class="input-group"> 
                                                            <?php echo form_textarea(array('name'=>'phenomonon','rows'=>'4','cols'=>'60','id'=>'phenomonon',  'class'=>'form-control', 'placeholder'=>'Enter any Phenomenon' ),set_value('phenomonon',$result['phenomonon'], false),$dis.' '.$o_dis.' '); ?>
                                                       </div>  
                                                        <span class="help-block"><?php echo form_error('phenomonon');?>&nbsp;</span>
                                                    </div>
                                            </div>
											
                                       <div class="form-group">
                                                    <label class="col-md-3 control-label">Treatment(s)</label>
                                                    <div class="col-md-9">    
                                                       <div class="input-group"> 
                                                            <?php echo form_textarea(array('name'=>'treatment','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter any treatment' ),set_value('treatment',$result['treatment'],false),$dis.' '.$o_dis.' '); ?>
                                                       </div>  
                                                        <span class="help-block"><?php echo form_error('treatment');?>&nbsp;</span>
                                                    </div>
                                            </div>
                                            <div hidden class="form-group">
                                                <label class="col-md-3 control-label">Polish</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('polish', set_value('polish',$result['polish']), 'id="polish" class="form-control" placeholder="Enter Polish "'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('polish');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                             
                                     </div>
                                        
                                        
                                    <div class="col-md-6">
                                       <h5>Testing Factors </h5>
                                       <hr>    
                                             
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Refractive index<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('ri_text_value', set_value('ri_text_value',$result['ri_text_value']), 'id="ri_text_value" class="form-control" placeholder="Enter RI Value"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('ri_text_value');?>&nbsp;</span>
                                                   </div> 
                                                <div class="col-md-9" hidden="hidden">    
                                                     <?php echo form_dropdown('refractive_index',$refractive_index_list_dpd, set_value('refractive_index',$result['refractive_index']),' class="form-control select" data-live-search="true" id="refractive_index" '.$o_dis.'');?> 
                                                    <?php // echo form_input('refractive_index', set_value('refractive_index',$result['refractive_index']), 'id="refractive_index" class="form-control" placeholder="Enter Refractive Index"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('refractive_index');?>&nbsp;</span>
                                                </div> 
                                            </div> 
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Specific Gravity<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('sg_text_value', set_value('sg_text_value',$result['sg_text_value']), 'id="sg_text_value" class="form-control" placeholder="Enter SG Value"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('sg_text_value');?>&nbsp;</span>
                                                </div> 
                                                <div class="col-md-9" hidden="hidden">    
                                                     <?php echo form_dropdown('specific_gravity',$specific_gravity_list_dpd, set_value('specific_gravity',$result['specific_gravity']),' class="form-control select" data-live-search="true" id="specific_gravity" '.$o_dis.'');?> 
                                                     <?php // echo form_input('specific_gravity', set_value('specific_gravity',$result['specific_gravity']), 'id="specific_gravity" class="form-control" placeholder="Enter Specific Gravity"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('specific_gravity');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                       <div hidden>
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Hardness<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('hardness', set_value('hardness',$result['hardness']), 'id="hardness" class="form-control" placeholder="Enter Hardness"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('hardness');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Optical Characters<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('optical_character', set_value('optical_character',$result['optical_character']), 'id="optical_character" class="form-control" placeholder="Enter Optical Character"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('optical_character');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Plechroism<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('plechroism', set_value('plechroism',$result['plechroism']), 'id="plechroism" class="form-control" placeholder="Enter Plechroism "'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('plechroism');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Absorption Spectrum<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('absorption_spectrum', set_value('absorption_spectrum',$result['absorption_spectrum']), 'id="absorption_spectrum" class="form-control" placeholder="Enter Absorption Spectrum"'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('absorption_spectrum');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Fluorebcence<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('fluorebcence', set_value('fluorebcence',$result['fluorebcence']), 'id="fluorebcence" class="form-control" placeholder="Enter Fluorebcence "'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('fluorebcence');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Magnification<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('magnification', set_value('magnification',$result['magnification']), 'id="magnification" class="form-control" placeholder="Enter Magnification "'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('magnification');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                              
                                       </div>
                                    </div>
                                            
                                       
                                    <div class="col-md-6 ">
                                       <h5>Other </h5>
                                       <hr>         
                                              
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Origin</label>
                                                <div class="col-md-9">    
                                                    <?php  echo form_dropdown('origin',$country_list,set_value('origin',$result['origin']),' class="form-control select" data-live-search="true" id="origin"'.$o_dis.'');?> 
                                                    <?php echo form_checkbox('show_origin', set_value('show_origin','1'),$result['show_origin'], 'id="show_origin" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                    <span class="help-block"><?php echo form_error('origin');?>&nbsp;</span>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Comments</label>
                                                    <div class="col-md-9">  <?php echo form_dropdown('comments1',$comments_list, set_value('comments1'),' class="form-control select" data-live-search="true" id="comments1" '.$o_dis.'');?> 
                                                             
                                                       <div class="input-group"> 
                                                            <?php echo form_textarea(array('name'=>'comments','rows'=>'4','cols'=>'60','id'=>'comments', 'class'=>'form-control', 'placeholder'=>'Enter comments' ),set_value('comments',$result['comments'],false),$dis.' '.$o_dis.' '); ?>
                                                       </div>  
                                                        <span class="help-block"><?php echo form_error('comments');?>&nbsp;</span>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Special Notes</label>
                                                    <div class="col-md-9">    
                                                       <div class="input-group"> 
                                                            <?php echo form_textarea(array('name'=>'special_note','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter any Special Notes' ),set_value('special_note',$result['special_note']),$dis.' '.$o_dis.' '); ?>
                                                       </div>  
                                                        <span class="help-block"><?php echo form_error('special_note');?>&nbsp;</span>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Appendix</label>
                                                    <div class="col-md-9">    
                                                       <div class="input-group"> 
                                                            <?php echo form_textarea(array('name'=>'appendix','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter any Appendix' ),set_value('appendix',$result['appendix']),$dis.' '.$o_dis.' '); ?>
                                                       </div>  
                                                        <span class="help-block"><?php echo form_error('appendix');?>&nbsp;</span>
                                                    </div>
                                            </div>
                                       
                                            
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Default Picture</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input(array('name'=>'pic1', 'id'=>'pic1', 'class'=>'form-control fl_file', 'type'=>'file'));?>
								
                                                        </div>    
                                                      
                                                        <span class="help-block"><?php echo form_error('pic1');?></span>
                                                    </div>
                                                </div>
                                       
                                            
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Picture 2</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input(array('name'=>'pic2', 'id'=>'pic2', 'class'=>'form-control fl_file', 'type'=>'file'));?>
								
                                                        </div>    
                                                      
                                                        <span class="help-block"><?php echo form_error('pic2');?></span>
                                                    </div>
                                                </div>
                                       
                                            
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Picture 3</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input(array('name'=>'pic3', 'id'=>'pic3', 'class'=>'form-control fl_file', 'type'=>'file'));?>
								
                                                        </div>    
                                                      
                                                        <span class="help-block"><?php echo form_error('pic3');?></span>
                                                    </div>
                                                </div>
                                       
                                            <div class="col-md-12">
                                                <h5> </h5>
                                       <hr>
                                                <div class="col-md-4"><center><img id="img_1" class="img-responsive thumbnail" style="size: 100%; width:150px;"  src="<?php echo base_url().LAB_REPORT_IMAGES.$result['report_no']."/".$result['pic1'];?>"><p>Default</p></center></div>
                                                <div class="col-md-4"><center><img id="img_2" class="img-responsive thumbnail" style="size: 100%; width:150px;"  src="<?php echo base_url().LAB_REPORT_IMAGES.$result['report_no']."/".$result['pic2'];?>"><p>Picture 2</p></center></div>
                                                <div class="col-md-4"><center><img id="img_3" class="img-responsive thumbnail" style="size: 100%; width:150px;"  src="<?php echo base_url().LAB_REPORT_IMAGES.$result['report_no']."/".$result['pic3'];?>"><p>Picture 3</p></center></div>
                                            </div> 
                                           <div class="col-md-12"> 
                                            <h5>Electronic Identification </h5>
                                       <hr>
                                       <div <?php echo $view_add;?> class="col-md-6">
                                                <center><img style="   width: 600px;" src="<?php echo base_url().LAB_REPORT_IMAGES.$result['report_no']."/barcode.png";?>" alt="barcode" class="img-thumbnail"></center>        
                                            </div>  
                                            <div <?php echo $view_add;?> class="col-md-6">
                                                <center><img style="size: 100%; width:150px;" src="<?php echo base_url().LAB_REPORT_IMAGES.$result['report_no']."/qr.png";?>" alt="qr" class="img-thumbnail"></center>        
                                            </div>  
                                              
                                        </div>
                                </div>
                                          
                                      
                                        
                                <div class="panel-footer">
                                    <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $result['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',($action=='Edit')?'Save':$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url('reports'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>
                                    <?php echo anchor(site_url('reports/report_generate/'.$result['id']),'Generate Report','class="btn btn-warning '.$view_add.'"');?>&nbsp;
                                    <div class="pull-right">    <?php echo anchor(site_url('reports/report_print/'.$result['id']),'View Report','class="btn btn-info   '.$view_add.' " target="_blank"');?>&nbsp;
                                    <div class="pull-right">    <?php echo anchor(site_url('reports/report_print/'.$result['id'].'/1'),'View e-Report','class="btn btn-default   '.$view_add.' " target="_blank"');?>&nbsp;
                                    <?php echo anchor(site_url('reports/report_print_pvc/'.$result['id']),'View Report PVC','class="btn btn-info    '.$view_add.' " target="_blank"');?>&nbsp;
                                    <?php echo anchor(site_url('reports/add'),'New Report','class="btn btn-warning pull-right"');?>&nbsp;
                                    </div>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url('reports'),'OK','class="btn btn-primary"');
                                    } ?>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>
     
<!--     //image Lightbox-->
     <div tabindex="-1" class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content"> 
                  <div align="" class="modal-body">
                      <div><center><img class="model_img"   src=""></center> </div>
                  </div>
                  <div class="modal-footer">
                          <button class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
             </div>
            </div>
          </div>