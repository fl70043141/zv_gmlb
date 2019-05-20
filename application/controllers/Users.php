<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('User_model');
        }


        public function index()
	{
            $this->view_search_user();
	}
        
        function view_search_user($datas=''){
            
            $data['user_list'] = $this->User_model->search_result();
            $data['main_content']='users/search_user'; 
            $this->load->view('includes/template',$data);
	}
        
	function add(){
//		$data  			= $this->load_data();
		$data['action']		= 'Add';
		$data['main_content']='users/manage_user'; 
                $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
		$this->load->view('includes/template',$data);
	}
	
	function edit($id){
//		$this->redirection_handler($ac_reg_id,'Edit');
		$data  			= $this->load_data($id);
		$data['action']		= 'Edit';
		$data['main_content']='users/manage_user'; 
		$this->load->view('includes/template',$data);
	}
	
	function delete($id){
//		$this->redirection_handler($ac_reg_id,'Delete');
		$data  			= $this->load_data($id);
		$data['action']		= 'Delete';
		$data['main_content']='users/manage_user'; 
		$this->load->view('includes/template',$data);
	}
	
	function view($id){
//		$this->redirection_handler($ac_reg_id,'View');
		$data  			= $this->load_data($id);
		$data['action']		= 'View';
		$data['main_content']='users/manage_user'; 
                $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
		$this->load->view('includes/template',$data);
	}
	
        
	function validate(){  
			$this->form_val_setrules();
//                        var_dump($this->input->post('action')); die;
			if($this->form_validation->run() == False){
				switch($this->input->post('action')){
					case 'Add':
						$this->add();
                                                break;
					case 'Edit':
						$this->edit($this->input->post('auth_id'));
                                                break;
					case 'Delete':
						$this->delete($this->input->post('reg_code'));
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
		
		$this->form_validation->set_rules('first_name','First Name','required|min_length[5]');
		$this->form_validation->set_rules('last_name','Last Name','required|min_length[5]');
//		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique['.USER.'.email]');
		$this->form_validation->set_rules('username','User Name','required');
		$this->form_validation->set_rules('user_role','User Role','required');
                
                
		$this->form_validation->set_rules('password','Password','matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password','Confirm Password','matches[password]');
	}	
        
        
	function create(){
              $inputs = $this->input->post();
//            var_dump($inputs); die; 
            $inputs = $this->input->post();
            $inputs['status'] = 0;
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            }
            $user_aut_tbl = array(
                                    'user_role_id' => $inputs['user_role'],
                                    'user_name' => $inputs['username'],
                                    'user_password' => $this->encrypt->encode(get_autoincrement_no(USER_TBL).'_'.$inputs['password']),
                                    'status' => $inputs['status']
                                );
            $user_det_tbl = array(
                                    'auth_id' => get_autoincrement_no(USER_TBL),
                                    'first_name' => $inputs['first_name'],
                                    'last_name' => $inputs['last_name'],
                                    'email' => $inputs['email'],
                                    'tel' => $inputs['contact'],
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata('ID'),
                                );
            
//            var_dump($user_det_tbl); die;
            $data = array('user_aut_tbl'=>$user_aut_tbl,
                          'user_det_tbl' => $user_det_tbl );
                                        
		$add_stat = $this->User_model->add_user($data);
                
		if($add_stat[0]){
				
				$this->session->set_flashdata('warn',RECORD_ADD);
				redirect('users/edit/'.$add_stat[1]);
			}else{
				$this->session->set_flashdata('warn',ERROR);
				redirect('users');
			} 
	}
	
	function update(){
            
                $inputs = $this->input->post();
                $user_id  = $this->input->post('user_id'); 
                if($this->session->userdata('ID') != 1 && $user_id == 1){
                    $this->session->set_flashdata('error','You Dont have modify delete this user!');
                    redirect('users');
                }
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            }else{
                $inputs['status'] = 0;
            }
            $user_aut_tbl = array(
                                    'user_role_id' => $inputs['user_role'],
                                    'user_name' => $inputs['username'], 
                                    'status' => $inputs['status']
                                );
            if($inputs['password'] != ''){
                $user_aut_tbl['user_password'] = $this->encrypt->encode($inputs['user_id'].'_'.$inputs['password']);
            }
            $user_det_tbl = array(
                                    'auth_id' => $inputs['user_id'],
                                    'first_name' => $inputs['first_name'],
                                    'last_name' => $inputs['last_name'],
                                    'email' => $inputs['email'],
                                    'tel' => $inputs['contact'],
                                    'updated_on' => date('Y-m-d'),
                                    'updated_by' => $this->session->userdata('ID'),
                                );
            
            $data = array('user_aut_tbl'=>$user_aut_tbl,
                          'user_det_tbl' => $user_det_tbl );
                                        
		$edit_stat = $this->User_model->edit_user($inputs['user_id'],$data);
                
		if($edit_stat){
				$this->session->set_flashdata('warn',RECORD_UPDATE);
				redirect('users');
			}else{
				$this->session->set_flashdata('warn',ERROR);
				redirect('users');
			} 
	}
	
	function remove(){
//                        echo '<pre>';            print_r($this->session->userdata());die;

		$user_id  = $this->input->post('user_id'); 
                if($user_id == $this->session->userdata('ID') || $user_id == 1){
                    $this->session->set_flashdata('error','You Dont have permission delete this user!');
                    redirect('users');
                }
		if($this->User_model->delete_user($user_id)){
				$this->session->set_flashdata('warn',RECORD_DELETE);
				redirect('users');
			}else{
				$this->session->set_flashdata('warn',ERROR);
				redirect('users');
			}  
	}
        function load_data($id){
            
            $data['user_data'] = $this->User_model->get_single_user($id); 
            $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
            return $data;	
	}	
        
        function search_user(){
		$search_data=array( 'user_name' => $this->input->post('user_name'), 'email' => $this->input->post('email')); 
		$data_view['search_list'] = $this->User_model->search_result($search_data);
		
//                var_dump($this->input->post()); die;
		$this->load->view('Users/search_user_result',$data_view);
	}
                                        
        function test(){
            echo 'okoo';
        }
}
