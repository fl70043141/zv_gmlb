<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Property_model');
        }

        public function index(){
            $this->view_search_property();
	}
        
        function view_search_property($datas=''){
            
            $data['hotel_list'] = get_dropdown_data(HOTELS,'hotel_name','id','Hotel');
            $data['floor_list'] = get_dropdown_data(FLOORS,'floor_name','id','Floor');
            $data['property_type_list'] = get_dropdown_data(PROPERTY_TYPE,'prop_type_name','id','Property');
            $data['property_list'] = $this->Property_model->search_result();
            $data['main_content']='property/search_property'; 
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data['action']		= 'Add';
            $data['main_content'] = 'property/manage_property'; 
            $data['hotel_list'] = get_dropdown_data(HOTELS,'hotel_name','id','Hotel');
            $data['floor_list'] = get_dropdown_data(FLOORS,'floor_name','id','Floor');
            $data['tarrif_type_list'] = get_dropdown_data(TARRIF_TYPE,'tarrif_type_name','id','Tarrif Type');
            $data['time_base_list'] = get_dropdown_data(TIME_BASE,'time_base_name','id','Time Base');
            $data['property_type_list'] = get_dropdown_data(PROPERTY_TYPE,'prop_type_name','id','Property');
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='property/manage_property'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='property/manage_property'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='property/manage_property';  
            $this->load->view('includes/template',$data);
	}
	
        
	function validate(){  
            $this->form_val_setrules(); 
            if($this->form_validation->run() == False){
                switch($this->input->post('action')){
                    case 'Add':
                            $this->add();
                            break;
                    case 'Edit':
                            $this->edit($this->input->post('id'));
                            break;
                    case 'Delete':
                            $this->delete($this->input->post('id'));
                            break;
                } 
            }
            else{
                switch($this->input->post('action')){
                    case 'Add':
                            $this->create();
                    break;
                    case 'Edit':
                        $this->update();
                    break;
                    case 'Delete':
                        $this->remove();
                    break;
                    case 'View':
                        $this->view();
                    break;
                }	
            }
	}
        
	function form_val_setrules(){
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('property_name','Property Name','required|min_length[2]');
            $this->form_validation->set_rules('short_name','Short Name','required|min_length[2]');
            $this->form_validation->set_rules('property_type_id','Property Type','required');
            $this->form_validation->set_rules('tarrif_type_id','Tarrif Type','required');
            $this->form_validation->set_rules('time_base_id','Time Base','required');
            $this->form_validation->set_rules('hotel_id','Hotel ','required'); 
        }
        
	function create(){ 
            $inputs = $this->input->post();
            
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            
            $data = array(
                            'property_name' => $inputs['property_name'],
                            'short_name' => $inputs['short_name'],
                            'property_type_id' => $inputs['property_type_id'],
                            'tarrif_type_id' => $inputs['tarrif_type_id'],
                            'time_base_id' => $inputs['time_base_id'],
                            'hotel_id' => $inputs['hotel_id'],
                            'floor_id' => $inputs['floor_id'],
                            'description' => $inputs['description'],
                            'status' => $inputs['status'],
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata('ID'),
                        );
                    
		$add_stat = $this->Property_model->add_property($data);
                
		if($add_stat){
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect('property'); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect('property');
                } 
	}
	
	function update(){
            $inputs = $this->input->post();
            
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data = array(
                            'property_name' => $inputs['property_name'],
                            'short_name' => $inputs['short_name'],
                            'property_type_id' => $inputs['property_type_id'],
                            'tarrif_type_id' => $inputs['tarrif_type_id'],
                            'time_base_id' => $inputs['time_base_id'],
                            'hotel_id' => $inputs['hotel_id'],
                            'floor_id' => $inputs['floor_id'],
                            'description' => $inputs['description'],
                            'status' => $inputs['status'],
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata('ID'),
                        ); 
            
            $edit_stat = $this->Property_model->edit_property($inputs['id'],$data);

            if($edit_stat){
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                redirect('property/edit/'.$inputs['id']);
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('property');
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post();
                                        
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata('ID')
                         ); 
                                        
            $delete_stat = $this->Property_model->delete_property($inputs['id'],$data);
                    
            if($delete_stat){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('property');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('property');
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            if($this->Hotel_model->delete2_hotel($id)){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('hotels');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('hotels');
            }  
	}
        
        function load_data($id){ 
            $data['property_data'] = $this->Property_model->get_single_row($id); 
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','Country'); 
            $data['hotel_list'] = get_dropdown_data(HOTELS,'hotel_name','id','Hotel');
            $data['floor_list'] = get_dropdown_data(FLOORS,'floor_name','id','Floor');
            $data['tarrif_type_list'] = get_dropdown_data(TARRIF_TYPE,'tarrif_type_name','id','Tarrif Type');
            $data['time_base_list'] = get_dropdown_data(TIME_BASE,'time_base_name','id','Time Base');
            $data['property_type_list'] = get_dropdown_data(PROPERTY_TYPE,'prop_type_name','id','Property');
          
            return $data;	
	}	
        
        function search_property(){ 
		$search_data=array( 'property_name' => $this->input->post('property_name'), 
                                    'property_type_id' => $this->input->post('property_type'), 
                                    'hotel_id' => $this->input->post('hotel'),
                                    'floor_id' => $this->input->post('floor'),
                                    'status' => $this->input->post('status')); 
		$data_view['search_list'] = $this->Property_model->search_result($search_data);
                                        
		$this->load->view('property/search_property_result',$data_view);
	}
                                        
        function test(){
            echo 'okoo';
        }
        
        function do_upload()
	{
		$config['upload_path'] = HOTEL_LOGO;
		$config['allowed_types'] = 'gif|jpg|png'; 

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('upload_success', $data);
		}
	}
}
