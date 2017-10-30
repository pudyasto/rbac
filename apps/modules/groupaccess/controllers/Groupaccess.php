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
 * Description of Groupaccess
 *
 * @author adi
 */
class Groupaccess extends MY_Controller {
    protected $data = '';
    public function __construct()
    {
        parent::__construct();
        $this->data = array(
            'msg_main' => 'Set Privilege',
            'msg_detail' => '',
            'menu_app' => $this->menu_app,
        );
        $this->load->model('groupaccess_qry');
        $this->data['csrf'] = $this->csrf;
    }

    //redirect if needed, otherwise display the user list
    
    public function index()
    {
        $this->data['group_id'] = $this->uri->segment(3);
        $this->template
            ->title('Set Privilege',$this->apps->name)
            ->set_layout('main')
            ->build('index',$this->data);
    }
    
    public function data_json_akses() {
        
        return $this->groupaccess_qry->data_json_akses();
    }
    
    public function submit() {
        
        return $this->groupaccess_qry->submit();
    }
}
