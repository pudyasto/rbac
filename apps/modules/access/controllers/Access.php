<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $logged_in = $this->session->userdata('logged_in');
        if($logged_in){
            redirect("dashboard");
        }else{            
            $this->template
                ->title('Login User',$this->apps->name)
                ->set_layout('access')
                ->build('index');
        }              
    }
    
    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">'
                . ' <button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->template
                ->title('Login User',$this->apps->name)
                ->set_layout('access')
                ->build('index');
        }else{
            $identity = $this->input->post('username');
            $password = $this->input->post('password');
            $remember = $this->input->post('remember');
            $stat = $this->ion_auth->login($identity, $password, $remember);
            if($stat && isset($_GET['url'])){
                $this->_set_session();
                redirect($_GET['url']);
            }elseif($stat && !isset($_GET['url'])){
                $this->_set_session();
                redirect('dashboard');
            }else{
                redirect('access/index?url='.$_GET['url'],'refresh');
            }
        }
    }
    
    public function recover() {
        if($this->input->post()){
            $this->form_validation->set_rules('username', 'Email', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">'
                . ' <button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
            if ($this->form_validation->run() == false) {
                $this->template
                    ->title('Login User',$this->apps->name)
                    ->set_layout('access')
                    ->build('recover');
            }
            else {
                $forgotten = $this->ion_auth->forgotten_password($this->input->post('username'));
                if ($forgotten) {
                    $msg = '<div class="alert alert-success">'
                                    . ' <strong>Email Sent!</strong> <br>Open your email for confirm reset your password'
                                    . ' </div>';
                    // $this->ion_auth->messages()
                    $this->session->set_flashdata('msg', $msg);
                    redirect("access/result", 'refresh');
                }
                else {
                    $msg = '<div class="alert alert-danger">'
                                    . ' <strong>Errorr !</strong> <br>'. $this->ion_auth->errors()
                                    . ' </div>';
                    $this->session->set_flashdata('msg', $msg);
                    redirect("access/recover", 'refresh');
                }
            }          
        }else{
            $this->template
                ->title('Recovery Your Accounts',$this->apps->name)
                ->set_layout('access')
                ->build('recover');    
        }      
    }    
    
    public function result() {
        $res['data'] = $this->session->userdata('msg');
        $this->template
            ->title('Recovery Your Accounts',$this->apps->name)
            ->set_layout('access')
            ->build('result',$res);        
    }     
    
    public function reset(){
        $code = $_GET['token'];//$this->uri->segment(3);
        $reset = $this->ion_auth->forgotten_password_complete($code);
        if ($reset) {  //if the reset worked then send them to the login page
                $msg = '<div class="alert alert-success">'
                                    . ' <strong>Email Sent!</strong> <br>Open your email for new password'
                                    . ' </div>';
                // $this->ion_auth->messages()
                $this->session->set_flashdata('msg', $msg);
                redirect("access/result", 'refresh');
        }
        else { //if the reset didnt work then send them back to the forgot password page
                $msg = '<div class="alert alert-danger">'
                                    . ' <strong>Errorr !</strong> <br>'. $this->ion_auth->errors()
                                    . ' </div>';
                $this->session->set_flashdata('msg', $msg);
                redirect("access/recover", 'refresh');
        }
    }
    
    public function logout() {
       $res = $this->ion_auth->logout();
       if($res){
           redirect('access','refresh');
       }else{
           redirect('dashboard');
       }
    }    
    
    private function _set_session(){
        $user = $this->ion_auth->user()->row();      
        if ($this->agent->is_browser())
        {
            $agent = $this->agent->browser().' '.$this->agent->version();
        }
        elseif ($this->agent->is_robot())
        {
            $agent = $this->agent->robot();
        }
        elseif ($this->agent->is_mobile())
        {
            $agent = $this->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }              
        $data = array(
            'username' => $user->username,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'surename' => $user->first_name.' '.$user->last_name,
            'email' => $user->email,
            'userid' => $user->id,
            'platform' => $this->agent->platform(),
            'browser' => $agent,
            'logged_in' => true,
            'log_tanggal' => $user->last_login,
        );
       
        $this->session->set_userdata($data);
    }

}
