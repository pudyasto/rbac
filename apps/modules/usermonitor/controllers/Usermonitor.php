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
 * Description of Usermonitor
 *
 * @author adi
 */
class Usermonitor extends MY_Controller {
    protected $data = '';
    protected $val = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usermonitor_qry');
        $this->load->model('access/ion_auth_model');
        $this->lang->load('auth');
        $this->load->helper(array('url','language'));
        
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
            'csrf'  => $this->csrf,
            
            'add' => site_url('usermonitor/add'),
            'edit' => site_url('usermonitor/edit'),
            'submit' => site_url('usermonitor/submit'),
            'reload' => site_url('usermonitor'),
        );    
    }

    //redirect if needed, otherwise display the user list
    
    public function index()
    {
        $this->template
            ->title($this->data['msg_main'],$this->apps->name)
            ->set_layout('main')
            ->build('index',$this->data);
    }
    
    public function json_dgview() {
        echo $this->usermonitor_qry->json_dgview();
    }
    
    public function submit() {
        try {
            if($this->validate() == TRUE){
                $this->db->trans_start();
                $this->db->delete('ci_sessions', array('id' => $this->input->post('id')));
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE)
                {
                    $err = $this->db->error();
                    $this->res = " Error : ". $this->apps->err_code($err['message']);
                    $this->state = "0";
                }else{
                    $this->res = "Data Deleted";
                    $this->state = "1";
                }                  
            }else{
                $this->res = strip_tags(validation_errors());
                $this->state = "0";
            }            
        }catch (Exception $e) {            
            $this->res = $e->getMessage();
            $this->state = "0";
        } 
        
        $arr = array(
            'state' => $this->state, 
            'msg' => $this->res,
            );
        $this->session->set_flashdata('statsubmit', json_encode($arr));
        echo json_encode($arr);
    }
    
    
    private function validate() {
        $config = array(
            array(
                    'field' => 'id',
                    'label' => 'ID Session',
                    'rules' => 'required',
                ),
            array(
                    'field' => 'stat',
                    'label' => 'Stat Action',
                    'rules' => 'required',
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
