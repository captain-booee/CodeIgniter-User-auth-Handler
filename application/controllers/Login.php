<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->library('recaptcha');
	}



	public function index()
	{
		$recaptcha = $this->recaptcha->create_box();
        $is_valid = $this->recaptcha->is_valid();

        if($is_valid['success'])
        {
            $this->form_validation->set_rules('email','Email','trim|required|valid_email',
            array(
            'required'=>'you must provide a %s.',
            'valid_email'=>'enter a valid email: example@site.com',
        ));
            $this->form_validation->set_rules('password','Password','trim|required|min_length[8]|max_length[20]',
            array(
            'required'=>'you must provide a %s.',
            'min_length'=>'min length gor password is 8.',
            'max_length'=>'max length gor password is 20.'
			));
            
            if($this->form_validation->run() == FALSE){
                $this->load->view("login_page", ['recaptcha' => $recaptcha]);
            }else{
                $ip = $this->input->ip_address();
                // check ip in ip list according to user id
                
                // if ip existed and user id is not match -> block the user by setting blocked in user table == 1
                // else add this ip for this user id

                //


                
                /* CLEAN AND SECURE DATA */
                /* XSS TRUE */
                $email = $this->input->post('email', TRUE);
                $pass = $this->input->post('password', TRUE);
                $time = time();
                $this->load->model('users_model');
                
                
                

				$login_check = $this->users_model->login_check_user($email, $pass);
				if ($login_check==FALSE){
					//set flash data for login failed username or pass
					redirect(base_url().'login');
                }
                $check_user_ip = $this->users_model->check_user_ip($login_check[0]['id'],$ip);
                if ($check_user_ip==FALSE){
                    //set flash data for that ure blocked
                    redirect(base_url().'login');
                }
				//redirect to profile
                $this->load->view("profile_page",array('user'=>$login_check));
            }
        }
        else
        {
			//set flash data for captcha
            $this->load->view("login_page", ['recaptcha' => $recaptcha]);

        }
	}

	public function login_submit(){
        
    }

	

}
