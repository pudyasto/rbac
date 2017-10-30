<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * ***************************************************************
 *  Script : 
 *  Version : 
 *  Date :
 *  Author : Pudyasto Adi W.
 *  Email : mr.pudyasto@gmail.com
 *  Description : 
 * ***************************************************************
 */

/**
 * Description of Profile
 *
 * @author adi
 */
class Profile extends MY_Controller {
    protected $data = '';
    public function __construct()
    {
        parent::__construct();
        $this->data = array(
            'msg_main' => 'User Account',
            'msg_detail' => 'Customize your user account',
        
            'submit' => site_url('profile/submit'),
            'add' => site_url('profile/add'),
            'edit' => site_url('profile/edit'),
            'reload' => site_url('profile'),
        );
        $this->load->model('profile_qry');
        $this->data['csrf'] = $this->csrf;
    }

    //redirect if needed, otherwise display the user list
    
    public function index()
    {
        $this->data['user'] = $this->profile_qry->select_data();
        $this->template
            ->title($this->data['msg_main'],$this->apps->name)
            ->set_layout('main')
            ->build('index',$this->data);
    }
    
    public function upload_photo() {
        $res = $this->profile_qry->upload_photo();
        echo $res;
    }
    
    public function show_image(){
        $id = $this->session->userdata('userid');
        $filename="";
        if(file_exists('./files/'.$id.".jpg")){
            $filename = './files/'.$id.".jpg";
        } elseif (file_exists('./files/'.$id.".jpeg")){
            $filename = './files/'.$id.".jpeg";
        } elseif (file_exists('./files/'.$id.".png")) {
            $filename = './files/'.$id.".png";
        }
        if (file_exists($filename)) {
            echo $this->apps->load_pict($filename);             
        }else{
            echo $this->apps->load_pict('./assets/dist/img/avatar.png');
        }
    }    
    
    public function submit_profile() {      
        $array = $this->input->post();
        if($this->validate($array) == TRUE){
            $res = $this->profile_qry->submit_profile();
            echo json_encode($res);
        }else{
            $res = array(
                'state' => 0,
                'msg' => strip_tags( validation_errors('','')),
            );
            echo json_encode($res);
        }
    }
    
    public function submit_password() {
        $array = $this->input->post();
        if($this->validate_password($array) == TRUE){
            $res = $this->profile_qry->submit_password();
            echo json_encode($res);
        }else{
            $res = array(
                'state' => 0,
                'msg' => strip_tags( validation_errors('','')),
            );
            echo json_encode($res);
        }
    }
    
    private function validate($array) {
        $config = array(
            array(
                    'field' => 'first_name',
                    'label' => 'Nama Depan',
                    'rules' => 'alpha_numeric_spaces|max_length[50]|min_length[2]|required',
                    ),
            array(
                    'field' => 'last_name',
                    'label' => 'Nama Belakang',
                    'rules' => 'alpha_numeric_spaces|max_length[50]|min_length[2]|required',
                    ),
            array(
                    'field' => 'phone',
                    'label' => 'Phone',
                    'rules' => 'alpha_dash|max_length[20]|required',
                    ),
            array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'valid_email|max_length[100]|required',
                    ),
        );
        
        $this->form_validation->set_rules($config);   
        if ($this->form_validation->run() == FALSE)
        {
            return false;
        }else{
            return true;
        }
    }
    
    private function validate_password($array) {
        $config = array(
            array(
                    'field' => 'password1',
                    'label' => 'New Password',
                    'rules' => 'max_length[50]|min_length[2]|required',
                    ),
            array(
                    'field' => 'password2',
                    'label' => 'Repeat New Password',
                    'rules' => 'max_length[50]|min_length[2]|required',
                    ),
        );
        
        $this->form_validation->set_rules($config);   
        if ($this->form_validation->run() == FALSE)
        {
            return false;
        }else{
            return true;
        }
    }
}
