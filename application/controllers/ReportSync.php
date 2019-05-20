<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportSync extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('ReportSync_model');
        }

        public function index(){
            $data['action']		= 'Add';
            $data['main_content'] = 'report_sync/sync_window';  
           
            $this->load->view('includes/template',$data);
 
	}
        public function sync_local_remote($rep_ids=array()){ //Empty array--> sync all
//            if(isset($_POST['syngle_report_id'])){
//                $rep_ids = array(0 => $_POST['syngle_report_id']);
//            }
            $local = $this->syncAllReportLocalData($rep_ids);
            $remote = $this->SyncAllRemoteData($rep_ids);
            echo '<p class="text-danger">Local Sync. completed: '.$local['local_synced'];
            echo ', Local Sync. Failed: '.$local['local_failed'];
            echo '<br>Remote Sync. completed: '.$remote.'</p>';
	}
        
        //step 1 - preparing for Sync
        function syncAllReportLocalData($ids=array()){
            $idString = implode(',', $ids);
            
            $sync_local_data = $this->ReportSync_model->get_report_data($idString);
            $new_local_sync = $local_sync_failed = 0;
            foreach($sync_local_data as $local_data){
                $sync_pending = $this->ReportSync_model->get_report_sync($local_data['id']);
                if($sync_pending == 0){
                    $insert_local_data = array(
                                                'report_id' => $local_data['id'],
                                                'remote_sync_status' => 0,
                                                'remote_sync_time' => 0,
                                                'local_sync_time' => time(),
                                                );
                    $add_stat = $this->ReportSync_model->add_local_sync($insert_local_data); 
                    ($add_stat ==1)?$new_local_sync++:$local_sync_failed++;
                }else{
                    $add_stat = $this->ReportSync_model->update_lab_report_statOnly($local_data['id']); 

                }
            }
//            echo 'local Sync Succeeded-'.$new_local_sync." , Failed-".$local_sync_failed;
                return array('local_synced'=>$new_local_sync, 'local_failed'=>$local_sync_failed);
            
        }
        
        //step 2 - execute data to remote
        function SyncAllRemoteData($rep_ids=array()){ 
            $sync_required_data = $this->ReportSync_model->get_report_local_syncData($rep_ids);
            //split the array to  each array size 5
            $sync_required_data_splitted = array_chunk($sync_required_data, 5, true);
            $send_data_count = 0;
            foreach ($sync_required_data_splitted as $sync_required_data_chunk){
                            

                $remote_data = array();
                foreach ($sync_required_data_chunk as $report_data){ 
                   // echo '<pre>'; print_r(($sync_required_data_chunk)); die;
                    $img_data = ''; 
                    if($report_data['pic1'] != '' && file_exists(BASEPATH.'.'.LAB_REPORT_IMAGES.$report_data['report_no'].'/'.$report_data['pic1'])){
                        fl_image_resizer($report_data['pic1'], 250, 250,$report_data['pic1'], BASEPATH.'.'.LAB_REPORT_IMAGES.$report_data['report_no'].'/');
                        
                        $img_data = base64_encode(file_get_contents(BASEPATH.'.'.LAB_REPORT_IMAGES.$report_data['report_no'].'/'.$report_data['pic1']));    

                        $remote_data[] = array(
                                                'local_report_id'=> $report_data['id'],
                                                'lrs_id'=> $report_data['lrs_id'],
                                                'report_no'=> $report_data['report_no'],
                                                'report_date'=> $report_data['report_date'],
                                                'weight'=> $report_data['weight'],
                                                'dimension'=> $report_data['dimension'],
                                                'object'=> $report_data['object_val'],
                                                'identification'=> $report_data['identification_val'],
                                                'variety'=> $report_data['variety_val'],
                                                'shape'=> $report_data['shape_val'],
                                                'cut'=> $report_data['cut_val'],
                                                'color_distribution'=> $report_data['color_distribution_val'],
                                                'show_color_distribution'=> $report_data['show_color_distribution'],
                                                'refractive_index'=> $report_data['ri_text_value'],
                                                'specific_gravity'=> $report_data['sg_text_value'],
                                                'transparency'=> $report_data['transparency'],
                                                'color'=> $report_data['color'],
                                                'phenomonon'=> $report_data['phenomonon'],
                                                'comments'=> $report_data['comments'],
                                                'appendix'=> $report_data['appendix'],
                                                'status'=> $report_data['status'],
                                                'deleted'=> $report_data['deleted'],
                                                'image'=> $img_data,
                                            );
                    }

                   // echo '<img src="data:image/gif;base64,'.$img_data.'">';
                }   
                   // echo '<pre>'; print_r(($remote_data)); die;

                $this->load->model('RemoteSync_model');
                $this->load->library('Curl');
                $encrypted_remote_response_data = $this->ReportSync_model->postToRemoteServer($remote_data);
                $remote_data = unserialize(stripslashes(mc_decrypt($encrypted_remote_response_data, ENCRYPTION_KEY)));

                //Update_remoteSyncTable
                 if(!empty($remote_data)){
                     foreach ($remote_data as $rdata){
                         $update_data = array(
                                                'report_id' => $rdata['report_id'],
                                                'remote_sync_status' => $rdata['remote_sync_status'],
                                                'remote_sync_time' => $rdata['remote_sync_time'],
                                                );
                                                $this->ReportSync_model->edit_lab_report_syncTable($rdata['lrs_id'],$update_data);
    //                                   

                     }
    //                echo '<pre>';            print_r($remote_data);die; 
//                    return count($remote_data);
                    $send_data_count = $send_data_count + count($remote_data);
                 } else {
//                    return 0;
                    }
            
            }
            return $send_data_count;
        }
        
        function test(){
            $this->sync_local_remote();
         }
         
}
