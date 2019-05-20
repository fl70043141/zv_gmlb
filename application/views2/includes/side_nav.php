  <?php 
     	$CI =& get_instance(); 				
	$user_group =  $this->session->userdata('user_role_ID'); //'ADMIN';
        $navigation = $this->user_default_model->get_user_menu_navigation($user_group); 
//        var_dump($navigation); die;
      
        ?>
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar fixed">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    
                               <li class="xn-logo">
                                   <a href="index.html">BGL SYSTEM</a>
                                   <a href="#" class="x-navigation-control"></a>
                               </li>

                               <li class="xn-title">Navigation</li>
                               
                                <?php
                                    foreach ($navigation as $nav1){
                                        if(empty($nav1->subnav)){
                                            echo '<li>
                                                        <a href="'.base_url($nav1->page_id).'"><span class="'.$nav1->img_class.'"></span> <span class="xn-text">'.$nav1->module_name.'</span></a>                        
                                                    </li>';
                                        }else{
                                            echo '  <li class="xn-openable">
                                                        <a href="'.base_url($nav1->page_id).'"><span class="'.$nav1->img_class.'"></span> <span class="xn-text">'.$nav1->module_name.'</span></a>
                                                        <ul>';
                                            foreach ($nav1->subnav as $nav2){
                                                    echo '<li><a href="'.base_url($nav2->page_id).'"><span class="'.$nav2->img_class.'"></span> '.$nav2->module_name.'</a></li>';
                                            }
                                            echo '       </ul>    
                                                    </li>';
                                        }
                                    }
                                ?>
                                                   
                </ul>
               </div>
            
            
            
                <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel " >
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                  
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                      <!-- TASKS -->
                       <!-- END TASKS -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
    <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="<?=base_url('logout')?>" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->