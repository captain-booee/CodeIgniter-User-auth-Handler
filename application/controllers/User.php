<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');
	}



	public function index()
	{

		$this->load->view('login_page');
	}

	public function login()
	{
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('password','Password','required',
		array('required'=>'you must provide a %s.'));
		$this->form_validation->set_rules('email','email','required');
		if($this->form_validation->run() == FALSE){
			$this->load->view("login_page");
		}else{
			$username = $this->input->post('username');

			$this->load->view("profile_page",array("username"=>$username));
		}
	}


}
