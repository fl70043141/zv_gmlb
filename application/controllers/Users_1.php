<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL 
	 */
	public function index()
	{
            
        $this->load->helper('url');
    //    echo base_url(); die;
		$this->load->view('includes/header');
		$this->load->view('includes/side_nav');
//		$this->load->view('dashboard');
		$this->load->view('includes/footer');
//		$this->load->view('welcome_message');
	}
}
