<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserPermission extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('User_permission');
        }

        public function index(){
            $this->view_search_user_permission();
	}
        
         function view_search_user_permission($datas=''){
            
            $data['user_permission_list'] = $this->User_permission->getPermissionGroup(); 
//            echo '<pre>'; print_r($data); die; 
            $data['main_content']='user_permissions/view_permissions'; 
            $this->load->view('includes/template',$data);
	}
        
	function edit($id){ 
            $data['permission_data']   = $this->get_permission_data($id); 
//                        echo '<pre>'; print_r($data); die; 

            $data['action']		= 'Edit';
            $data['urole_id']		= $id;
            $data['main_content'] = 'user_permissions/manage_permission'; 
            $this->load->view('includes/template',$data);
	}
        
        
        
        
        function get_permission_data($user_role_id){
            $modules = $this->User_permission->get_module_list();
            $module_data = array();
            foreach ($modules as $module){
                $module_data[$module['id']]['p_data'] = $this->User_permission->getPermissionData($user_role_id, $module['id']);
                $module_data[$module['id']]['name'] = $module['module_name'];
                $module_data[$module['id']]['id'] = $module['id'];
                
            } 
            return $module_data;
        }
        
        function make_fresh_system(){
//             echo 'WARNING: PLS HIDE THIS COMMENT BEFORE EXECUTE'; die;
            $truncate_tables = array(
                                        AGENTS, 
                                        DROPDOWN_LIST,
                                        LAB_REPORT,
                                        LAB_REPORT_SYNC,
                                        
                                    );
            foreach ($truncate_tables as $tbl_name){ 
                $this->User_permission->make_fresh_system($tbl_name);
            }
            $this->session->set_flashdata('warn',"SB SET UP TO FRESH JEWELLERY SOFTWARE");
            redirect('userPermission/');
        }
           
          
	function validate(){  
            
             $inputs = $this->input->post();
             $status = $this->User_permission->updateUserPermission($inputs);
//            if(isset($inputs['status'])){
//                $inputs['status'] = 1;
//            } else{
//                $inputs['status'] = 0;
//            }
              

            if($status){
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                redirect('userPermission');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('userPermission/'.$inputs['user_role_id']);
            } 
	}
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        function view_search_property($datas=''){
            
            $data['agent_type_list'] = get_dropdown_data(AGENT_TYPE,'agent_type_name','id','Agent Type');
            $data['floor_list'] = get_dropdown_data(FLOORS,'floor_name','id','Floor');
            $data['property_type_list'] = get_dropdown_data(PROPERTY_TYPE,'prop_type_name','id','Property');
            $data['agent_list'] = $this->Agent_model->search_result();
            $data['main_content']='agents/search_agent'; 
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data['action']		= 'Add';
            $data['main_content'] = 'agents/manage_agent'; 
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','Country');
            $data['agent_type_list'] = get_dropdown_data(AGENT_TYPE,'agent_type_name','id','Agent Type');
           
            $this->load->view('includes/template',$data);
	}
	
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content'] = 'agents/manage_agent'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='agents/manage_agent';  
            $this->load->view('includes/template',$data);
	}
	
      
        
	function form_val_setrules(){
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('agent_name','Agent Name','required|min_length[2]');
            $this->form_validation->set_rules('short_name','Short Name','required|min_length[2]');
            $this->form_validation->set_rules('agent_type_id','Property Type','required');
            $this->form_validation->set_rules('address','Address','required');
            $this->form_validation->set_rules('city','City','required');
            $this->form_validation->set_rules('commision_plan','Commission Plan','required');
            $this->form_validation->set_rules('phone','phone','required|min_length[10]|integer'); 
            $this->form_validation->set_rules('commission_value','Commission Value','required|numeric'); 
            $this->form_validation->set_rules('credit_limit','Credit Limit','required|numeric'); 
        }
        
	function create(){ 
            $inputs = $this->input->post();
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            
            $data = array(
                            'agent_name' => $inputs['agent_name'],
                            'short_name' => $inputs['short_name'],
                            'agent_type_id' => $inputs['agent_type_id'],
                            'description' => $inputs['description'],
                            'reg_no' => $inputs['reg_no'],
                            'status' => $inputs['status'],
                            'phone' => $inputs['phone'],
                            'fax' => $inputs['fax'],
                            'email' => $inputs['email'],
                            'website' => $inputs['website'],
                            'address' => $inputs['address'],
                            'city' => $inputs['city'],
                            'postal_code' => $inputs['postal_code'],
                            'state' => $inputs['state'],
                            'country' => $inputs['country'],
                            'commision_plan' => $inputs['commision_plan'],
                            'commission_value' => $inputs['commission_value'],
                            'credit_limit' => $inputs['credit_limit'],
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata('ID'),
                        );

		$add_stat = $this->Agent_model->add_agent($data);
                
		if($add_stat){
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect('agents'); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect('agents');
                } 
	}
	
        function remove(){
            $inputs = $this->input->post();
                                        
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata('ID')
                         ); 
                                        
            $delete_stat = $this->Agent_model->delete_agent($inputs['id'],$data);
                    
            if($delete_stat){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('agents');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('agents');
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            if($this->Agent_model->delete2_hotel($id)){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('agents');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('agents');
            }  
	}
        
        function load_data($id){ 
            $data['property_data'] = $this->Agent_model->get_single_row($id); 
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','Country');
            $data['agent_type_list'] = get_dropdown_data(AGENT_TYPE,'agent_type_name','id','Agent Type');
           
            return $data;	
	}	
        
        function search_agent(){ 
		$search_data=array( 'agent_name' => $this->input->post('agent_name'), 
                                    'agent_type_id' => $this->input->post('agent_type'),  
                                    'status' => $this->input->post('status')); 
		$data_view['search_list'] = $this->Agent_model->search_result($search_data);
                                        
		$this->load->view('agents/search_agent_result',$data_view);
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
