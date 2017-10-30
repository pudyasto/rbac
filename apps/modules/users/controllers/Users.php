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
 * Description of Users
 *
 * @author adi
 */
class Users extends MY_Controller {
    protected $data = '';
    protected $val = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_qry');
        $this->load->model('access/ion_auth_model');
        $this->lang->load('auth');
        $this->load->helper(array('url','language'));
        
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
            'csrf'  => $this->csrf,
            
            'add' => site_url('users/add'),
            'edit' => site_url('users/edit'),
            'submit' => site_url('users/submit'),
            'reload' => site_url('users'),
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
    
    public function add(){   
        if(!empty($this->access->module_access('add'))){
            redirect('debug/err_505');
        }
        
        $this->_init_add();
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
        $this->template
            ->title($this->data['msg_main'],$this->apps->name)
            ->set_layout('main')
            ->build('edit',$this->data);
    }
    
    public function json_dgview() {
        echo $this->users_qry->json_dgview();
    }
    
    public function submit() {
        try {
            $id = $this->input->post('id');
            $stat = $this->input->post('stat');
            $array = $this->input->post();

            if($this->validate($id,$stat) == TRUE){
                if(empty($array['id'])){    
                    $username = $this->input->post('identity');
                    $password = $this->input->post('password_confirm');
                    $email = $this->input->post('email');
                    $additional_data = array(
                                            'first_name' => $this->input->post('first_name'),
                                            'last_name' => $this->input->post('last_name'),
                                            'phone'  => $this->input->post('phone'),
                                            'company'  => $this->input->post('company'),
                                            'active' => $this->input->post('active'),
                                            );
                    $group_id =  $this->input->post('group_id');
                    $group = array($group_id); 
                    $this->ion_auth->register($username, $password, $email, $additional_data, $group);    
                    redirect('users');
                }
                elseif(!empty($array['id']) && empty($array['stat'])){
                    $password = $this->input->post('password_confirm');
                    $user_id = $this->input->post('id');
                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'phone'  => $this->input->post('phone'),
                        'username' => $this->input->post('identity'),
                        'company'  => $this->input->post('company'),
                        'email' => $this->input->post('email'),
                        'active' => $this->input->post('active'),
                        'password' => $this->input->post('password_confirm'),
                    );  
                    $group_id =  $this->input->post('group_id');
                    $this->ion_auth->remove_from_group(NULL, $user_id);
                    $this->ion_auth->add_to_group($group_id, $user_id);
                    $this->ion_auth->update($user_id, $data);
                    redirect('users');
                }
                elseif(!empty($array['id']) && !empty($array['stat'])){                
                    $resl = $this->ion_auth->delete_user($array['id']);
                    if( ! $resl){
                        $err = $this->db->error();
                        $this->res = " Error : ". $this->apps->err_code($err['message']);
                        $this->state = "0";
                    }else{
                        $this->res = "Data Deleted";
                        $this->state = "1";
                    }   
                }
                else{
                    $this->res = "Variable is missing";
                    $this->state = "0";
                }
            }
            elseif(empty($id)){
                $this->template->build('add', $this->data);
            }else{
                $this->check_id($id);
                $this->template->build('edit', $this->data);
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
    
    private function _init_add(){
        $group_id = $this->users_qry->ref_mstgroup();
        $opt_group[''] = '-- Set Group --';
        foreach ($group_id as $value) {
            $opt_group[$value['id']] = $value['name'];
        }
        
        $this->data['form'] = array(
           'first_name'=> array(
                    'placeholder' => 'First Name',
                    'id'          => 'first_name',
                    'name'        => 'first_name',
                    'value'       => set_value('first_name'),
                    'class'       => 'form-control',
                    'required'    => '',
                    'autofocus'   => ''
            ),
            'last_name'=> array(
                    'placeholder' => 'Last Name',
                    'id'          => 'last_name',
                    'name'        => 'last_name',
                    'value'       => set_value('last_name'),
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'identity'=> array(
                    'placeholder' => 'Username',
                    'id'          => 'identity',
                    'name'        => 'identity',
                    'value'       => set_value('identity'),
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'email'=> array(
                    'placeholder' => 'Email',
                    'type'        => 'email',
                    'id'          => 'email',
                    'name'        => 'email',
                    'value'       => set_value('email'),
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'phone'=> array(
                    'placeholder' => 'Phone Number',
                    'id'          => 'phone',
                    'name'        => 'phone',
                    'value'       => set_value('phone'),
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'company'=> array(
                    'placeholder' => 'Company',
                    'id'          => 'company',
                    'name'        => 'company',
                    'value'       => set_value('company'),
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'password'=> array(
                    'placeholder' => 'Password',
                    'type'        => 'password',
                    'id'          => 'password',
                    'name'        => 'password',
                    'value'       => set_value('password'),
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'password_confirm'=> array(
                    'placeholder' => 'Confirm Password',
                    'type'        => 'password',
                    'id'          => 'password_confirm',
                    'name'        => 'password_confirm',
                    'value'       => set_value('password_confirm'),
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'group_id'=> array(
                    'attr'        => array(
                        'id'    => 'group_id',
                        'class' => 'form-control',
                    ),
                    'data'     => $opt_group,
                    'value'   => set_value('group_id'),
                    'name'     => 'group_id',
            ),
            'active'=> array(
                    'attr'        => array(
                        'id'    => 'active',
                        'class' => 'form-control',
                    ),
                    'data'     => array(
                            '1' => 'Enabled',
                            '0' => 'Disabled',
                        ),
                    'value'   => set_value('active'),
                    'name'     => 'active',
            ),
        );
    }
    
    private function _init_edit(){  
        $groupid = $this->uri->segment(3);
        $this->_check_id($groupid);
        
        $group_id = $this->users_qry->ref_mstgroup();
        $opt_group[''] = '-- Set Group --';
        foreach ($group_id as $value) {
            $opt_group[$value['id']] = $value['name'];
        }
        
        $this->data['form'] = array(
            'id'=> array(
                    'type'        => 'hidden',
                    'placeholder' => 'Users ID',
                    'id'          => 'id',
                    'name'        => 'id',
                    'value'       => $this->val[0]['id'],
                    'class'       => 'form-control',
            ),
           'first_name'=> array(
                    'placeholder' => 'First Name',
                    'id'          => 'first_name',
                    'name'        => 'first_name',
                    'value'       => $this->val[0]['first_name'],
                    'class'       => 'form-control',
                    'required'    => '',
                    'autofocus'   => ''
            ),
            'last_name'=> array(
                    'placeholder' => 'Last Name',
                    'id'          => 'last_name',
                    'name'        => 'last_name',
                    'value'       => $this->val[0]['last_name'],
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'identity'=> array(
                    'placeholder' => 'Username',
                    'id'          => 'identity',
                    'name'        => 'identity',
                    'value'       => $this->val[0]['username'],
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'email'=> array(
                    'placeholder' => 'Email',
                    'type'        => 'email',
                    'id'          => 'email',
                    'name'        => 'email',
                    'value'       => $this->val[0]['email'],
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'phone'=> array(
                    'placeholder' => 'Phone Number',
                    'id'          => 'phone',
                    'name'        => 'phone',
                    'value'       => $this->val[0]['phone'],
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'company'=> array(
                    'placeholder' => 'Company',
                    'id'          => 'company',
                    'name'        => 'company',
                    'value'       => $this->val[0]['company'],
                    'class'       => 'form-control',
                    'required'    => '',
            ),
            'password'=> array(
                    'placeholder' => 'Password - Fill for change your password',
                    'type'        => 'password',
                    'id'          => 'password',
                    'name'        => 'password',
                    'value'       => '',
                    'class'       => 'form-control',
            ),
            'password_confirm'=> array(
                    'placeholder' => 'Confirm Password - Fill for change your password',
                    'type'        => 'password',
                    'id'          => 'password_confirm',
                    'name'        => 'password_confirm',
                    'value'       => '',
                    'class'       => 'form-control',
            ),
            'group_id'=> array(
                    'attr'        => array(
                        'id'    => 'group_id',
                        'class' => 'form-control',
                    ),
                    'data'     => $opt_group,
                    'value'   => $this->val[0]['group_id'],
                    'name'     => 'group_id',
            ),
            'active'=> array(
                    'attr'        => array(
                        'id'    => 'active',
                        'class' => 'form-control',
                    ),
                    'data'     => array(
                            '1' => 'Enabled',
                            '0' => 'Disabled',
                        ),
                    'value'   => $this->val[0]['active'],
                    'name'     => 'active',
            ),
        );
    }
    
    private function _check_id($id){
        if(empty($id)){
            redirect($this->data['add']);
        }
        
        $this->val = $this->users_qry->select_data($id);
        
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
                    'field' => 'first_name',
                    'label' => 'First Name',
                    'rules' => 'required|max_length[50]',
                ),
            array(
                    'field' => 'last_name',
                    'label' => 'Last Name',
                    'rules' => 'required|max_length[50]',
                    ),
            array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required|max_length[100]',
                    ),
        );
        if(!empty($id)){
            $identity = array(
                        'field' => 'identity',
                        'label' => 'Username',
                        'rules' => 'trim|required|max_length[100]',
                    );
            array_merge($config,$identity);
            
            $pass = array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|max_length[8]',
                    );
            array_merge($config,$pass);
            
            $pass_confirm = array(
                    'field' => 'password_confirm',
                    'label' => 'Password Confirm',
                    'rules' => 'trim|matches[password]|max_length[8]',
                    );
            array_merge($config,$pass_confirm);
        }else{
            $identity = array(
                        'field' => 'identity',
                        'label' => 'Username',
                        'rules' => 'trim|required|max_length[100]|is_unique[users.username]',
                    );            
            array_merge($config,$identity);
            
            $pass = array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|required|max_length[8]',
                    );
            array_merge($config,$pass);
            
            $pass_confirm = array(
                    'field' => 'password_confirm',
                    'label' => 'Password Confirm',
                    'rules' => 'trim|required|matches[password]|max_length[8]',
                    );
            array_merge($config,$pass_confirm);
        }
        $this->form_validation->set_rules($config);   
        if ($this->form_validation->run() == FALSE)
        {
            return false;
        }else{
            return true;
        }
    }
}
