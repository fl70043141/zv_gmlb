<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Markerts extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Floor_model');
        }

        public function index(){
            $this->view_search_floor();
	}
        
        function view_search_floor($datas=''){
            $data['floor_list'] = $this->Floor_model->search_result();
            $data['main_content']='floors/search_floor'; 
            $data['hotel_list'] = get_dropdown_data(HOTELS,'hotel_name','id','Hotel');
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data['action']		= 'Add';
            $data['main_content']='floors/manage_floor'; 
            $data['hotel_list'] = get_dropdown_data(HOTELS,'hotel_name','id','Hotel'); 
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='floors/manage_floor'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='floors/manage_floor'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='floors/manage_floor';  
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

            $this->form_validation->set_rules('floor_name','Floor Name','required');
            $this->form_validation->set_rules('short_name','Short Name','required');
            $this->form_validation->set_rules('hotel_id','Hotel','required');
                    
      }	
        
	function create(){ 
            $inputs = $this->input->post();
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data = array(
                            'floor_name' => $inputs['floor_name'],
                            'short_name' => $inputs['short_name'],
                            'hotel_id' => $inputs['hotel_id'],
                            'descreption' => $inputs['descreption'],
                            'status' => $inputs['status'],
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata('ID'),
                        );
            
		$add_stat = $this->Floor_model->add_floor($data);
                
		if($add_stat){
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect('floors'); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect('floors');
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
                            'floor_name' => $inputs['floor_name'],
                            'short_name' => $inputs['short_name'],
                            'hotel_id' => $inputs['hotel_id'],
                            'descreption' => $inputs['descreption'], 
                            'status' => $inputs['status'],
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata('ID'),
                        ); 
            
            $edit_stat = $this->Floor_model->edit_Floor($inputs['id'],$data);

            if($edit_stat){
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                redirect('floors/edit/'.$inputs['id']);
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('floors');
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post();
                                        
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata('ID')
                         ); 
                                        
            $delete_stat = $this->Floor_model->delete_floor($inputs['id'],$data);
                    
            if($delete_stat){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('floors');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('floors');
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
            
            $data['user_data'] = $this->Floor_model->get_single_row($id); 
            $data['hotel_list'] = get_dropdown_data(HOTELS,'hotel_name','id','Hotel');
            return $data;	
	}	
        
        function search_floor(){
		$search_data=array( 'floor_name' => $this->input->post('floor_name'),'hotel' => $this->input->post('hotel')); 
		$data_view['search_list'] = $this->Floor_model->search_result($search_data);
                                        
		$this->load->view('Floors/search_floor_result',$data_view);
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
