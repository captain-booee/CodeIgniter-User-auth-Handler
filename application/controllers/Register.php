<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
    
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
                $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]',
                array(
                'required'=>'you must provide a %s.',
                'valid_email'=>'enter a valid email: a@b.com',
                'is_unique'=>'this email already existed'
                ));
                $this->form_validation->set_rules('password','Password','trim|required|min_length[8]|max_length[20]',
                    array(
                    'required'=>'you must provide a %s.',
                    'min_length'=>'min length gor password is 8.',
                    'max_length'=>'max length gor password is 20.'
                ));
                $this->form_validation->set_rules('passconf','Password_config','trim|required|matches[password]',
                    array(
                    'required'=>'you must provide a %s.',
                    'matches'=>'this should match with your password.'
                ));
                
                if($this->form_validation->run() == FALSE){
                    $this->load->view("register_page", ['recaptcha' => $recaptcha]);
                }else{
                    /* CLEAN AND SECURE DATA */
                    /* XSS TRUE */
                    $email = $this->input->post('email', TRUE);
                    $pass = $this->input->post('password', TRUE);
                    $hashed = md5(rand());
                    if($this->send_validation_email($email, $hashed)){
                        $this->load->model('users_model');
                        $user_registered = $this->users_model->create_user($email, $pass, $hashed);
                    }
                    //email didnt send
                    redirect(base_url().'register/ednr');
                }
            }else{
                
                $this->load->view("register_page", ['recaptcha' => $recaptcha]);
                
            }
            
            
    }

    /*
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++NONE controller FUNC++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    */
    
    public function email_verification($email,$hash){

        $this->load->model('users_model');
        $user_status_update = $this->users_model->user_status_update($email, $hash);

        if($user_status_update==FALSE){
            $this->load->view("resend_verification_page",array("opt"=>"ednr",'recaptcha' => $recaptcha));
        }else{
            //flash msg for successfully verified
            redirect(base_url()."login");
        }
    }

    protected function send_validation_email($email,$hashed){
        $this->load->library('email');
 
        $config = array(
                    'protocol' => 'smtp', 
                    'smtp_host' => 'ssl://smtp.gmail.com', 
                    'smtp_port' => 465, 
                    'smtp_user' => 'email@gmail.com', 
                    'smtp_pass' => '****', 
                    'mailtype' => 'html', 
                    'charset' => 'iso-8859-1'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        
        $encURL = 'http://localhost/projects/small-business/register/email_verification/'.$email.'/'.$hashed;

        //Email content
        $htmlContent = '<h1>Validation Email.</h1>';
        $htmlContent .= '<p>click on the link bellow to verify your account.</p>'.$encURL;
        
        $this->email->to($email);
        $this->email->from('email@gmail.com','MyWebsite');
        $this->email->subject('subject');
        $this->email->message($htmlContent);
        
        //Send email
        $result = $this->email->send();
        if ($result){
            return TRUE;
        }else{
            return FALSE;
        }
    }




    protected function send_email_newpass($email,$hashed){
        $this->load->library('email');
 
        $config = array(
                    'protocol' => 'smtp', 
                    'smtp_host' => 'ssl://smtp.gmail.com', 
                    'smtp_port' => 465, 
                    'smtp_user' => 'email@gmail.com', 
                    'smtp_pass' => '******', 
                    'mailtype' => 'html', 
                    'charset' => 'iso-8859-1'   
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        
        

        //Email content
        $htmlContent = '<h1>your password changed.</h1>';
        $htmlContent .= '<p>you have requested for a new password. please contact us if you are not aware of what happened! your New password is :</p><br>'.$hashed;
        $htmlContent .= '<p>please log in with this password change it as soon as possible in your account for your safety.</p>';
        
        $this->email->to($email);
        $this->email->from('email@gmail.com','MyWebsite');
        $this->email->subject('subject');
        $this->email->message($htmlContent);
        
        //Send email
        $result = $this->email->send();
        if ($result){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    

    /*
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++NONE controller FUNC++++++++++++++++++++++
    ++++++++++++++++++++++  END  +++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    */





    public function register_submit(){

            
        }





    





    public function forget_pass(){
        $recaptcha = $this->recaptcha->create_box();
        $is_valid = $this->recaptcha->is_valid();

        if($this->input->post('submit')){
            if($is_valid['success'])
            {
                $this->form_validation->set_rules('email','Email','trim|required|valid_email',
                array(
                'required'=>'you must provide a %s.',
                'valid_email'=>'enter a valid email: a@b.com',
                ));
            
                if($this->form_validation->run() == FALSE){
                $this->load->view("forget_pass_page", ['recaptcha' => $recaptcha]);
                }else{
                /* CLEAN AND SECURE DATA */
                /* XSS TRUE */
                $email = $this->input->post('email', TRUE);
                $this->load->model('users_model');
                //if this user exist and status is not 1
                
                $hash = rand(66666666,99999999);
                
                if($this->users_model->update_password_randomly($email, $hash)===TRUE){ 
                    if($this->send_email_newpass($email, $hash)){





                        //die('done');





                    }
                    redirect(base_url().'login');
                }
                redirect(base_url().'register/forget_pass');
                }
            }else{
                redirect(base_url().'register/forget_pass');
                //robot problem
            }
        }else{
            $this->load->view("forget_pass_page", array('recaptcha' => $recaptcha));
        }

    }



    
    public function ednr(){
        $recaptcha = $this->recaptcha->create_box();
        $is_valid = $this->recaptcha->is_valid();

        if($this->input->post('submit')){
            if($is_valid['success'])
            {
                $this->form_validation->set_rules('email','Email','trim|required|valid_email',
                array(
                'required'=>'you must provide a %s.',
                'valid_email'=>'enter a valid email: a@b.com',
                ));
            
                if($this->form_validation->run() == FALSE){
                $this->load->view("resend_verification_page", ['recaptcha' => $recaptcha]);
                }else{
                /* CLEAN AND SECURE DATA */
                /* XSS TRUE */
                $email = $this->input->post('email', TRUE);
                $this->load->model('users_model');
                //if this user exist and status is not 1
                
                $hash = md5(rand());
                
               
                $update_hash_randomly = $this->users_model->update_hash_randomly($email, $hash);
                if($update_hash_randomly===TRUE){ 
                    
                    $this->send_validation_email($email, $hash);
                    redirect(base_url().'register/ednr');
                    //new email was sent
                }elseif($update_hash_randomly === FALSE){
                    //there is no such a user with deactivated account...if u have any prblem contact us
                    redirect(base_url().'login');
                }
                $this->load->view("resend_verification_page", array('recaptcha' => $recaptcha));
                }
            }else{
                redirect(base_url().'register/ednr');
                //robot problem
            }
        }else{
            $this->load->view("resend_verification_page", array('recaptcha' => $recaptcha));
        }
    }


}