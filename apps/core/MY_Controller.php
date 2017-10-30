<?php

/*
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */

/**
 * Description of MY_Controller
 *
 * @author pudyasto
 */
class MY_Controller extends CI_Controller{  
    var $menu_app="";
    var $msg_active="";
    var $msg_main="";
    var $msg_detail="";
    var $csrf="";
    public function __construct()
    {
        parent::__construct();  
        $this->load->library(array('enc'));        
        if(isset($_GET['token'])){
            $tmptoken = $this->enc->decode($_GET['token']);
            $userdata = json_decode($tmptoken);           
            if($userdata->expd < time()){
                redirect('access/logout','refresh');
            }else{
                foreach ($userdata as $key => $object) {
                    $this->session->set_userdata($key, $object);
                }
            }
        }
        $logged_in = $this->session->userdata('logged_in');

        if(!$logged_in){
            redirect($this->apps->ssoapp . '/access?url=' . $this->apps->curPageURL(),'refresh');
            exit;
        }
        
        $kelas = $this->uri->segment(1);
        if($kelas=="dashboard" || empty($kelas)){
            $this->msg_main = "Welcome ";
            $this->msg_detail = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');
        }else{
            foreach($this->access->ceksubmenu_app($kelas) as $val){
                $this->msg_main = $val->name;
                $this->msg_detail = $val->description;
            }    
        }
        
        $show = $this->access->module_access('show');
        if(empty($show)){
            redirect('debug/err_505','refresh');
            exit;
        }
        
        $this->csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ); 
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        
    }
}
