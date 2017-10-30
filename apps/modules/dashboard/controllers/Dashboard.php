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
 * Description of Dashboard
 *
 * @author adi
 */
class Dashboard extends MY_Controller {
    protected $data = '';
    public function __construct()
    {
        parent::__construct();
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
        );
        $this->load->model('dashboard_qry');
    }

    //redirect if needed, otherwise display the user list
    
    public function index()
    {
        $this->template
            ->title('Dashboard',$this->apps->name)
            ->set_layout('main')
            ->build('index',$this->data);
    }  
}
