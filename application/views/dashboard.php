<?php
//echo '<pre>';print_r($map_data);die;
?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>                    
                    <li class="active">Dashboard</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                        
                          <div class="col-md-3">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon" onclick="location.href='<?php echo base_url('summaryReports');?>';">
                                <div class="widget-item-left">
                                    <span class="fa fa-diamond"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><?php echo $report_all;?></div>
                                    <div class="widget-title">Tested Stones</div>
                                    <div class="widget-subtitle">All BGL reports</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                        
                        <div class="col-md-3">
                            
                            <!-- START WIDGET SLIDER -->
                            <div class="widget widget-default widget-carousel">
                                <div class="owl-carousel" id="owl-example">
                                    <div>                                    
                                        <div class="widget-title">Total Syncronized</div>                                                                        
                                        <div class="widget-subtitle">Total Sync completed to online</div>
                                        <div class="widget-int"><?php echo $sync_data['total'];?></div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">Sync Pending</div>                                                                        
                                        <div class="widget-subtitle">Synchronization required</div>
                                        <div class="widget-int"><?php echo ($sync_data['local_req']+$sync_data['remote_req']);?></div>
                                    </div>
                                   
                                </div>                            
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                             
                            </div>         
                            <!-- END WIDGET SLIDER -->
                            
                        </div>
                      
                        <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                            <div class="widget widget-default widget-item-icon" onclick="location.href='<?php echo base_url('agents');?>';">
                                <div class="widget-item-left">
                                    <span class="fa fa-user"></span>
                                </div>
                                <div class="widget-data">
                                    <div class="widget-int num-count"><?php echo $customer['all']?></div>
                                    <div class="widget-title">Registred Customers</div>
                                    <div class="widget-subtitle">On your System.</div>
                                </div>
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                            
                            </div>                            
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET CLOCK -->
                            <div class="widget widget-info widget-padding-sm">
                                <div class="widget-big-int plugin-clock">00:00</div>                            
                                <div class="widget-subtitle plugin-date">Loading...</div>
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                            
                                <div class="widget-buttons widget-c3">
                                    <div class="col">
                                        <a href="#"><span class="fa fa-clock-o"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-bell"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-calendar"></span></a>
                                    </div>
                                </div>                            
                            </div>                        
                            <!-- END WIDGET CLOCK -->
                            
                        </div>
                    </div>
                    <!-- END WIDGETS -->                    
                    
                    <div class="row">
                         
                              <div class="col-md-8">
                            
                            <!-- STARTORIGIN MAP-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title-box">
                                        <h3>Tested Stones</h3>
                                        <span>The country origins of tested stones</span>
                                    </div>                                     
                                    <ul class="panel-controls panel-controls-title">                                        
                                                                        
                                        <li><a href="#" class="panel-fullscreen rounded"><span class="fa fa-expand"></span></a></li>
                                    </ul>                                    
                                    
                                </div>
                                <div class="panel-body">                                    
                                    <div class="row stacked">
                                        <div class="col-md-4"> 
                                            <?php
                                            $i =0;
                                            foreach ($map_data as $mpdt){
                                                $i++;
                                                echo '
                                                     <div class="progress-list">                                               
                                                            <div class="pull-left"><strong>'.$mpdt['country_name'].'</strong></div>
                                                            <div class="pull-right">'.$mpdt['count_origin'].'</div>                                                
                                                            <div class="progress progress-small progress-striped active">
                                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="'.$report_all.'" style="width: '.(($mpdt['count_origin']/$report_all)*100).'%;">75%</div>
                                                            </div>
                                                        </div>      
                                                    ';
                                                if($i==4)
                                                    break;
                                            }
                                            ?>
                                           
                                             
                                        </div>
                                        <div class="col-md-8">
                                            <div id="dashboard-map-seles" style="width: 100%; height: 200px"></div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <!-- END ORIGIN MAP-->
                            
                        </div>
                        <div class="col-md-4">
                            
                            <!-- START VISITORS BLOCK -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title-box">
                                        <h3>Customers</h3>
                                        <span>BGL Customer Categories</span>
                                    </div>
                                    <ul class="panel-controls" style="margin-top: 2px;">
                                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li> 
                                                                             
                                    </ul>
                                </div>
                                <div class="panel-body padding-0">
                                    <div class="chart-holder" id="dashboard-donut-1" style="height: 230px;"></div>
                                </div>
                            </div>
                            <!-- END VISITORS BLOCK -->
                            
                        </div>

				 
                    </div>
                    
                    <div class="row">
                  
						<div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-content">
								<ul class="list-inline item-details">
									<li><a href="http://themifycloud.com/downloads/janux-premium-responsive-bootstrap-admin-dashboard-template/">Admin templates</a></li>
									<li><a href="http://themescloud.org">Bootstrap themes</a></li>
								</ul>
							</div>
						</div>
                        
                      
                    </div>
                     
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
      
            
            
<script>
    $(function (){
           
         var jvm_wm = new jvm.WorldMap({container: $('#dashboard-map-seles'),
                                            map: 'world_mill_en', 
                                            backgroundColor: '#FFFFFF',                                      
                                            regionsSelectable: true,
                                            regionStyle: {selected: {fill: '#B64645'},
                                                            initial: {fill: '#33414E'}},
                                            markerStyle: {initial: {fill: '#1caf9a',
                                                           stroke: '#1caf9a'}},
                                            markers: [
                                                      <?php
                                                        foreach ($map_data as $country_data){
                                                            echo "{latLng: [".$country_data['lat'].", ".$country_data['lng']."], name: '".$country_data['country_name']." - ".$country_data['count_origin']."'},";
                                                        }
                                                      ?> 
                                                      ]
                                        });    
                                        

            /* Donut dashboard chart */
            Morris.Donut({
                element: 'dashboard-donut-1',
                data: [
                    {label: "Platinum", value: <?php echo $customer['platinum'];?>},
                    {label: "Gold", value:  <?php echo $customer['gold'];?>},
                    {label: "Silver", value:  <?php echo $customer['silver'];?>}
                ],
                colors: ['#33414E', '#FEA223', '#1caf9a'],
                resize: true
            });
            /* END Donut dashboard chart */

        
    });
</script>