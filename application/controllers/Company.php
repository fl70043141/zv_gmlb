<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Company_model'); 
        }

        public function index(){
            $this->view_search_company();
	}
        
        function view_search_company($datas=''){
            $data['company_list'] = $this->Company_model->search_result();
            $data['main_content']='company/search_company'; 
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data['action']		= 'Add';
            $data['main_content']='company/manage_company'; 
            $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','Country');
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='company/manage_company'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='company/manage_company'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='company/manage_company'; 
            $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
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

            $this->form_validation->set_rules('company_name','Company Name','required|min_length[2]');
            $this->form_validation->set_rules('street_address','Street Addess','required|min_length[5]');
            $this->form_validation->set_rules('city','City','required');
            $this->form_validation->set_rules('country','Country','required');
            $this->form_validation->set_rules('phone','Phone Number','required|min_length[10]');
            $this->form_validation->set_rules('fax','Company Type','min_length[10]');
            $this->form_validation->set_rules('other_phone','Phone Number','min_length[10]');
            $this->form_validation->set_rules('email','Email','valid_email');
            $this->form_validation->set_rules('company_type','Company Type','required');
      }	
        
	function create(){ 
            $inputs = $this->input->post();
            $inputs['status'] = 0;
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } 
            $data = array(
                            'company_name' => $inputs['company_name'],
                            'street_address' => $inputs['street_address'],
                            'city' => $inputs['city'],
                            'state' => $inputs['state'],
                            'country' => $inputs['country'],
                            'zipcode' => $inputs['zipcode'],
                            'phone' => $inputs['phone'],
                            'fax' => $inputs['fax'],
                            'other_phone' => $inputs['other_phone'],
                            'email' => $inputs['email'],
                            'website' => $inputs['website'],
                            'company_type' => $inputs['company_type'],
                            'company_grade    ' => $inputs['company_grade'],
                            'reg_no' => $inputs['reg_no'],
                            'logo' => 'logo.jpg',
                            'status' => $inputs['status'],
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata('ID'),
                        );
                    
		$add_stat = $this->Company_model->add_db($data);
                
		if($add_stat){
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect('company'); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect('company');
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
                            'company_name' => $inputs['company_name'],
                            'street_address' => $inputs['street_address'],
                            'city' => $inputs['city'],
                            'state' => $inputs['state'],
                            'country' => $inputs['country'],
                            'zipcode' => $inputs['zipcode'],
                            'phone' => $inputs['phone'],
                            'fax' => $inputs['fax'],
                            'other_phone' => $inputs['other_phone'],
                            'email' => $inputs['email'],
                            'website' => $inputs['website'],
                            'company_type' => $inputs['company_type'],
                            'company_grade    ' => $inputs['company_grade'],
                            'reg_no' => $inputs['reg_no'],
//                            'logo' => 'logo.jpg',
                            'status' => $inputs['status'],
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata('ID'),
                        ); 
            
                    $fupload = $this->do_upload('logo','logo_'.$inputs['id']); 
                    if($fupload!=''){
                        $data['logo'] = $fupload;
                    } 
//                    echo $fupload;die;
            $edit_stat = $this->Company_model->edit_db($inputs['id'],$data);

            if($edit_stat){
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect('company/edit/'.$inputs['id']);
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('company');
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post();
                                        
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata('ID')
                         ); 
                                        
            $id  = $inputs['id']; 
                if($id == 1){
                    $this->session->set_flashdata('error','You Dont have permission delete this company..!');
                    redirect('company');
                }
            $delete_stat = $this->Company_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('company');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('company');
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            if($this->Company_model->delete2_db($id)){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('company');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('company');
            }  
	}
        
        function load_data($id){
            
            $data['user_data'] = $this->Company_model->get_single_row($id); 
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','Country'); 
            return $data;	
	}	
        
        function search_company(){
		$search_data=array( 'company_name' => $this->input->post('company_name')); 
		$data_view['search_list'] = $this->Company_model->search_result($search_data);
                                        
		$this->load->view('Company/search_company_result',$data_view);
	}
                                        
        function test(){
            echo 'okoo';
//            log_message('error', 'Some variable did not contain a value.');
        }
        
        function do_upload($file_nm, $pic_name='logo_default')
	{
		$config['upload_path'] = HOTEL_LOGO;
		$config['file_name'] = $pic_name;
		$config['overwrite'] = true;
		
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file_nm))
		{
			return "";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			return $data['upload_data']['file_name'];
		}
	}
                    
}
