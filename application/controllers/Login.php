<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');ob_start();
class Login extends CI_controller
{
	function index($out =""){
		$this->load->view('login.php');
	}
	
	function authenticate(){
		$this->load->model('user_default_model');
		$data = $this->input->post();
//         print 'Data is <pre>';print_r($data);'</pre>'; die();
		if($this->user_default_model->login($data)){
		  redirect('dashboard');
       	}else{
                  redirect('login');
           }
	} 
	
	function test(){ 
            print_r($pw = $this->encrypt->encode('1_evolve23'));
            echo '<br><br>';
            print_r($this->encrypt->decode('+G9gHOJAaB+2rdK8S9CaBlC2ZeUqRqJACEgQA0N6WhVXr3FSzjY0bbn08sVkoykUpU40xkixFck2fFtBTCkxdA=='));
//          var_dump($this->session->all_userdata());
	}
 
}


?>