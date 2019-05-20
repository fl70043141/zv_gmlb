<?php
ob_start();
function is_loged_in(){
    
	$CI =& get_instance();
	$CI->load->library('session');
    $allowed_classes = array('login','is_logged_in','crons','forgot_password');	
    if(!in_array($CI->router->class,$allowed_classes) && $CI->session->userdata('is_logged_in') == FALSE ){
        redirect('login');	
    }
    if($CI->session->userdata('is_logged_in') == TRUE && $CI->router->class == 'login'){
    	redirect('dashboard');
	}
}

function check_authority(){
 
	$CI =& get_instance();
	$CI->load->library('session');
	$page = $CI->router->class;
	
	$authorized_page = array('login', 'unauthorized', 'search', 'ajax', 'logout', 'crons','forgot_password');
	
	if(in_array($page, $authorized_page))return;
	$CI->session->set_flashdata('prev_controller', $page); 
	$method = $CI->router->method;
	$method = ($method=='index')?'':$method;
	$user_group = $CI->session->userdata('user_role_ID');
	$CI->load->model('user_default_model');
	
	if(!$CI->user_default_model->check_authority($user_group, $page, $method)){
		redirect('unauthorized');
	}
}

function error_styling()
{
	$CI =& get_instance();	
	$CI->form_validation->set_error_delimiters('<div class="error">', '</div>');
	
}

?>