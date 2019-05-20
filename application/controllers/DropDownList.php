<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DropDownList extends CI_Controller {

	  function __construct() {
            parent::__construct();
            $this->load->model('Dropdown_model');
        }

        public function index(){
            $this->view_search_dropdown();
	}
        
        function view_search_dropdown($datas=''){
            
            $data['dropdown_list'] = get_dropdown_data(DROPDOWN_LIST_NAMES,'dropdown_list_name','id','Dropdown Type ');
            
            $data['dropdown_value_list'] = $this->Dropdown_model->search_result();
            $data['main_content']='dropdown_list/search_dropdown_list'; 
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data['action']		= 'Add';
            $data['main_content'] = 'dropdown_list/manage_dropdown_list'; 
            $data['dropdown_value_list'] = get_dropdown_data(DROPDOWN_LIST_NAMES,'dropdown_list_name','id','Dropdown Type ');
            $data['agent_type_list'] = get_dropdown_data(AGENT_TYPE,'agent_type_name','id','Agent Type');
            $data['dropdown_identification_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Select Parent',array('col'=>'dropdown_id','val'=>5));
           
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content'] = 'dropdown_list/manage_dropdown_list'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content'] = 'dropdown_list/manage_dropdown_list'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='dropdown_list/manage_dropdown_list';  
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

            $this->form_validation->set_rules('dropdown_value','Value for Dropdown','required|min_length[2]');
            $this->form_validation->set_rules('dropdown_type','Dropdown Type'); 
        }
        
	function create(){ 
            $inputs = $this->input->post();
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            
            $data = array(
                            'dropdown_value' => $inputs['dropdown_value'],
                            'dd_note' => $inputs['dd_note'],
                            'dropdown_id' => $inputs['dropdown_id'], 
                            'status' => $inputs['status'], 
                            'parent_id' => ($inputs['parent_id']>0)?$inputs['parent_id']:0,  
                            'ri_value' => $inputs['ri_value'], 
                            'sg_value' => $inputs['sg_value'], 
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata('ID'),
                        ); 
		$add_stat = $this->Dropdown_model->add_dropdown($data);
                
		if($add_stat){
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect('DropDownList'); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect('DropDownList');
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
                            'dropdown_value' => $inputs['dropdown_value'],
                            'dd_note' => $inputs['dd_note'],
                            'dropdown_id' => $inputs['dropdown_id'], 
                            'status' => $inputs['status'], 
                            'parent_id' => ($inputs['parent_id']>0)?$inputs['parent_id']:0,  
                            'ri_value' => $inputs['ri_value'], 
                            'sg_value' => $inputs['sg_value'], 
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata('ID'),
                        ); 
            
            $edit_stat = $this->Dropdown_model->edit_dropdown($inputs['id'],$data);

            if($edit_stat){
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                redirect('DropDownList/edit/'.$inputs['id']);
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('DropDownList');
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post();
                                        
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata('ID')
                         ); 
                                        
            $delete_stat = $this->Dropdown_model->delete_dropdown($inputs['id'],$data);
                    
            if($delete_stat){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('DropDownList');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('DropDownList');
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            if($this->Agent_model->delete2_hotel($id)){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('DropDownList');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('DropDownList');
            }  
	}
        
        function load_data($id){ 
            $data['property_data'] = $this->Dropdown_model->get_single_row($id); 
            $data['dropdown_value_list'] = get_dropdown_data(DROPDOWN_LIST_NAMES,'dropdown_list_name','id','Dropdown Type ');
            $data['agent_type_list'] = get_dropdown_data(AGENT_TYPE,'agent_type_name','id','Agent Type');
            $data['dropdown_identification_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Select Parent',array('col'=>'dropdown_id','val'=>5));
           
            return $data;	
	}	
        
        function search_dropdown(){ 
                $status = $this->input->post('status');
		$search_data=array( 'dropdown_val' => $this->input->post('dropdown_val'), 
                                    'dropdown_type' => $this->input->post('dropdown_type'),  
                                    'status' => ($status!='')?1:0); 
		$data_view['search_list'] = $this->Dropdown_model->search_result($search_data);
//                                                        echo '<pre>';                print_r($data_view); die;

                if($this->input->post('dropdown_type') == 6){
                    $this->load->view('dropdown_list/search_dropdown_list_result_variety',$data_view);
                }else{
                    $this->load->view('dropdown_list/search_dropdown_list_result',$data_view);
                }
	}
                                        
        function test(){
            echo 'okoo';
        }
}
