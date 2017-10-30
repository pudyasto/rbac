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
 * Description of Groups
 *
 * @author adi
 */
class Groups extends MY_Controller {
    protected $data = '';
    protected $val = '';
    public function __construct()
    {
        parent::__construct();
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
            
            'submit' => site_url('groups/submit'),
            'add' => site_url('groups/add'),
            'edit' => site_url('groups/edit'),
            'reload' => site_url('groups'),
        );
        $this->load->model('groups_qry');
        $this->data['csrf'] = $this->csrf;
    }

    //redirect if needed, otherwise display the user list
    
    public function index(){
        
        $this->template
            ->title($this->data['msg_main'],$this->apps->name)
            ->set_layout('main')
            ->build('index',$this->data);
    }

    public function add(){   
        if(!empty($this->access->module_access('add'))){
            redirect('debug/err_505');
        }
        $this->_init_add();
        $this->data['msg_detail'] = "Add group";
        $this->template
            ->title($this->data['msg_main'],$this->apps->name)
            ->set_layout('main')
            ->build('add',$this->data);
    }
    
    public function edit() {
        if(!empty($this->access->module_access('edit'))){
            redirect('debug/err_505');
        }
        $this->_init_edit();
        $this->data['msg_detail'] = "Edit group";
        $this->template
            ->title($this->data['msg_main'],$this->apps->name)
            ->set_layout('main')
            ->build('edit',$this->data);
    }
    
    public function json_dgview() {
        echo $this->groups_qry->json_dgview();
    }
    
    public function submit() {  
        $id = $this->input->post('id');
        $stat = $this->input->post('stat');
        
        if($this->validate($id,$stat) == TRUE){
            $res = $this->groups_qry->submit();
            if(empty($stat)){
                $data = json_decode($res);
                if($data->state==="0"){
                    if(empty($id)){
                        $this->_init_add();
                        $this->template->build('add', $this->data);
                    }else{
                        $this->check_id($id);
                        $this->template->build('edit', $this->data);
                    }
                }else{
                    redirect($this->data['reload']);
                }
            }else{
                echo $res;
            }
        }else{
            $this->data['maingroup'] = $this->groups_qry->select_main_group();
            if(empty($id)){
                $this->data['msg_detail'] = "Add group";
                $this->_init_add();
                $this->template->build('add', $this->data);
            }else{
                $this->check_id($id);
                $this->data['msg_detail'] = "Edit group";
                $this->template->build('edit', $this->data);
            }
        }
    }
    
    private function _init_add(){
        $this->data['form'] = array(
           'name'=> array(
                    'placeholder' => 'Group Name',
                    'id'          => 'name',
                    'name'        => 'name',
                    'value'       => set_value('name'),
                    'class'       => 'form-control',
                    'required'    => '',
                    'autofocus'   => ''
            ),
            'description'=> array(
                    'placeholder' => 'Description',
                    'id'          => 'description',
                    'name'        => 'description',
                    'value'       => set_value('description'),
                    'class'       => 'form-control',
                    'style'       => 'resize: vertical;height: 80px;',
            ),
        );
    }
    
    private function _init_edit(){
        
        $groupid = $this->uri->segment(3);
        $this->_check_id($groupid);

        $this->data['form'] = array(
           'id'=> array(
                    'type'        => 'hidden',
                    'placeholder' => 'Group ID',
                    'id'          => 'id',
                    'name'        => 'id',
                    'value'       => $this->val[0]['id'],
                    'class'       => 'form-control',
            ),
           'name'=> array(
                    'placeholder' => 'Group Name',
                    'id'          => 'name',
                    'name'        => 'name',
                    'value'       => $this->val[0]['name'],
                    'class'       => 'form-control',
                    'required'    => '',
                    'autofocus'   => ''
            ),
            'description'=> array(
                    'placeholder' => 'Description',
                    'id'          => 'description',
                    'name'        => 'description',
                    'value'       => $this->val[0]['description'],
                    'class'       => 'form-control',
                    'style'       => 'resize: vertical;height: 80px;',
            ),
        );
    }
    
    private function _check_id($id){
        if(empty($id)){
            redirect($this->data['add']);
        }
        
        $this->val= $this->groups_qry->select_data($id);
        
        if(empty($this->val)){
            redirect($this->data['add']);
        }
    }
    
    private function validate($id,$stat) {
        if(!empty($id) && !empty($stat)){
            return true;
        }
        $config = array(
            array(
                    'field' => 'name',
                    'label' => 'Nama Group',
                    'rules' => 'required|alpha_numeric_spaces|max_length[50]',
                ),
            array(
                    'field' => 'description',
                    'label' => 'Description',
                    'rules' => 'alpha_numeric_spaces|max_length[250]',
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
