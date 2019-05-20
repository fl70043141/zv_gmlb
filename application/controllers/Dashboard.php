<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
            
            $this->load->helper('url');
            $data  			= $this->getData(); 
            $data['main_content'] = 'dashboard'; 
            $this->load->view('includes/template',$data);
	}
        
        public function getData(){
            $this->load->model('Dashboard_model');
            $data['report_all'] = $this->Dashboard_model->get_table_data_count();
            
            $data['gem_type']['precious'] = $this->Dashboard_model->get_table_data_count(1,'gem_type');
            $data['gem_type']['semi_precious'] = $this->Dashboard_model->get_table_data_count(2,'gem_type');
            $data['gem_type']['normal'] = $this->Dashboard_model->get_table_data_count(3,'gem_type');
            $data['gem_type']['rare'] = $this->Dashboard_model->get_table_data_count(4,'gem_type');
            
            $data['customer']['all'] = $this->Dashboard_model->get_table_data_count('','',AGENTS);
            $data['customer']['platinum'] = $this->Dashboard_model->get_table_data_count(1,'agent_type_id',AGENTS);
            $data['customer']['gold'] = $this->Dashboard_model->get_table_data_count(2,'agent_type_id',AGENTS);
            $data['customer']['silver'] = $this->Dashboard_model->get_table_data_count(3,'agent_type_id',AGENTS);
            
            $data['sync_data']['local_req'] = $this->Dashboard_model->get_table_data_count(1,'sync_required');
            $data['sync_data']['remote_req'] = $this->Dashboard_model->get_table_data_count(1,'remote_sync_status!=',LAB_REPORT_SYNC);
            $data['sync_data']['total'] = $this->Dashboard_model->get_table_data_count(1,'remote_sync_status',LAB_REPORT_SYNC);
            
            $data['map_data'] = $this->Dashboard_model->get_origin_map_data();
            
            return $data;
        }
//        
//        public function get_map_long_lat(){
//            $this->load->model('Dashboard_model');
//              
//            $source = XML_DATA.'countries.xml'; 
//            // load as string
//            $xmlstr = file_get_contents($source);
//            $xmlcont = new SimpleXMLElement($xmlstr);
//            echo '<pre>';            print_r($xmlcont); die;
//
//            // echo $xmlcont->LK; 
//            $map_data = $this->Dashboard_model->get_origin_map_data();
//            $tot_stones=0;
//            foreach ($map_data as $country_data){ 
//
//                $map_placemnt = explode(',', $xmlcont->$country_data['country_code']);
//                $map_pos['lat'] = $map_placemnt[0];
//                $map_pos['lng'] = $map_placemnt[1];  
//                $map_pos['country_code'] = $country_data['country_code'];  
//                $map_pos['country_name'] = $country_data['country_name'];  
//                $map_pos['count'] = $country_data['count_origin'];  
//                $country_pos[] = $map_pos;
//                $tot_stones = $tot_stones + $map_pos['count'];
//            } 
//            return $country_pos;
//            //echo '<pre>';            print_r($country_pos); die;
//        }
        
        public function test(){
            $this->load->model('Dashboard_model');
            echo '<pre>';            print_r($this->getData()); die;

        }
        
}
