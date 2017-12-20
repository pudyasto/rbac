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
 * Description of Menus
 *
 * @author adi
 */
class Menus extends MY_Controller {
    protected $data = '';
    protected $val = '';
    public function __construct()
    {
        parent::__construct();
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
            
            'submit' => site_url('menus/submit'),
            'add' => site_url('menus/add'),
            'edit' => site_url('menus/edit'),
            'reload' => site_url('menus'),
        );
        $this->load->model('menus_qry');
        $this->data['csrf'] = $this->csrf;
    }

    //redirect if needed, otherwise display the user list
    
    public function get_menu() {
        $q = $this->input->post('q');
        $this->db->where("statmenu = '1' AND link <> '#' AND (LOWER(name) LIKE '%".strtolower($q)."%' OR LOWER(description) LIKE '%".strtolower($q)."%')");
        $this->db->order_by("CASE "
                . " WHEN LOWER(name) LIKE '".strtolower($q)."' THEN 1"
                . " WHEN LOWER(name) LIKE '".strtolower($q)."%' THEN 2"
                . " WHEN LOWER(name) LIKE '%".strtolower($q)."' THEN 3"
                . " WHEN LOWER(name) LIKE '%".strtolower($q)."%' THEN 4"
                . " WHEN LOWER(description) LIKE '".strtolower($q)."' THEN 5"
                . " WHEN LOWER(description) LIKE '".strtolower($q)."%' THEN 6"
                . " WHEN LOWER(description) LIKE '%".strtolower($q)."' THEN 7"
                . " WHEN LOWER(description) LIKE '%".strtolower($q)."%' THEN 8"
                . " END");
        $this->db->order_by('name','ASC');
        $query = $this->db->get('menus');
        //echo $this->db->last_query();
        if($query->num_rows()>0){
            $res = $query->result_array();
            foreach ($res as $value) {
                $d_arr[] = array(
                    'id' => $value['link'],
                    'text' => $value['name'],
                    'description' => $value['description'],
                );

            }
            $data = array(
                'total_count' => $query->num_rows(),
                'incomplete_results' => true,
                'items' => $d_arr
            );
            echo json_encode($data);
        }else{
            $d_arr[] = array(
                'id' => '',
                'text' => '',
                'description' => '',
            );

            $data = array(
                'total_count' => 0,
                'incomplete_results' => true,
                'items' => $d_arr
            );
            echo json_encode($data);
        }
    }
    
    public function index(){
        
        $this->template
            ->title($this->data['msg_main'],$this->apps->name)
            ->set_layout('main')
            ->build('index',$this->data);
    }

    public function add(){   
        if(!empty($this->rbac->module_access('add'))){
            redirect('debug/err_505');
        }
        $this->_init_add();
        $this->data['msg_detail'] = "Add menu";
        $this->data['fa_icons'] = $this->load->view('fa_icons', '', TRUE);
        $this->template
            ->title($this->data['msg_main'],$this->apps->name)
            ->set_layout('main')
            ->build('add',$this->data);
    }
    
    public function edit() {
        if(!empty($this->rbac->module_access('edit'))){
            redirect('debug/err_505');
        }
        $this->_init_edit();
        $this->data['msg_detail'] = "Edit menu";
        $this->data['fa_icons'] = $this->load->view('fa_icons', '', TRUE);
        $this->template
            ->title($this->data['msg_main'],$this->apps->name)
            ->set_layout('main')
            ->build('edit',$this->data);
    }
    
    public function json_dgview() {
        echo $this->menus_qry->json_dgview();
    }
    
    public function submit() {  
        $id = $this->input->post('id');
        $stat = $this->input->post('stat');
        
        if($this->validate($id,$stat) == TRUE){
            $res = $this->menus_qry->submit();
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
            $this->data['mainmenu'] = $this->menus_qry->select_main_menu();
            if(empty($id)){
                $this->data['msg_detail'] = "Add menu";
                $this->_init_add();
                $this->template->build('add', $this->data);
            }else{
                $this->check_id($id);
                $this->data['msg_detail'] = "Edit menu";
                $this->template->build('edit', $this->data);
            }
        }
    }
    
    private function _init_add(){
        if(set_value('mainmenuid')){
            $checked = FALSE;
        }else{
            $checked = TRUE;
        }
        
        $mainmenuid = $this->menus_qry->select_main_menu();
        $opt_mainmenu[''] = '-- Set Main Menu --';
        foreach ($mainmenuid as $value) {
            $opt_mainmenu[$value['id']] = $value['name'];
        }
        
        $opt_statmenu = array(
            '1' => 'Enabled',
            '0' => 'Disabled',
        );
        $this->data['form'] = array(
           'name'=> array(
                    'placeholder' => 'Menu Name',
                    'id'          => 'name',
                    'name'        => 'name',
                    'value'       => set_value('name'),
                    'class'       => 'form-control',
                    'required'    => '',
                    'autofocus'   => ''
            ),
           'chkmainmenu'=> array(
                    'id'        => 'chkmainmenu',
                    'value'     => 'ok',
                    'checked'   => $checked,
                    'class'     => 'filled-in',
            ),
            'mainmenuid'=> array(
                    'attr'        => array(
                        'id'    => 'mainmenuid',
                        'class' => 'form-control',
                    ),
                    'data'     => $opt_mainmenu,
                    'value'   => set_value('mainmenuid'),
                    'name'     => 'mainmenuid',
            ),
           'link'=> array(
                    'placeholder' => 'Link Menu',
                    'id'          => 'link',
                    'name'        => 'link',
                    'value'       => set_value('link'),
                    'class'       => 'form-control',
                    'required'    => '',
            ),
           'icon'=> array(
                    'placeholder' => 'Icon Menu',
                    'id'          => 'icon',
                    'name'        => 'icon',
                    'value'       => set_value('icon'),
                    'class'       => 'form-control',
            ),
            'description'=> array(
                    'placeholder' => 'Description',
                    'id'          => 'description',
                    'name'        => 'description',
                    'value'       => set_value('description'),
                    'class'       => 'form-control',
                    'style'       => 'resize: vertical;height: 80px;',
            ),
            'statmenu'=> array(
                    'attr'        => array(
                        'id'    => 'statmenu',
                        'class' => 'form-control',
                    ),
                    'data'     => $opt_statmenu,
                    'value'   => set_value('statmenu'),
                    'name'     => 'statmenu',
            ),
        );
    }
    
    private function _init_edit(){
        
        $menuid = $this->uri->segment(3);
        $this->_check_id($menuid);
        
        if($this->val[0]['mainmenuid']){
            $checked = FALSE;
        }else{
            $checked = TRUE;
        }
        
        $mainmenuid = $this->menus_qry->select_main_menu($menuid);
        $opt_mainmenu[''] = '-- Set Main Menu --';
        foreach ($mainmenuid as $value) {
            $opt_mainmenu[$value['id']] = $value['name'];
        }
        
        $opt_statmenu = array(
            '1' => 'Enabled',
            '0' => 'Disabled',
        );
        $this->data['form'] = array(
           'id'=> array(
                    'type'        => 'hidden',
                    'placeholder' => 'Menu ID',
                    'id'          => 'id',
                    'name'        => 'id',
                    'value'       => $this->val[0]['id'],
                    'class'       => 'form-control',
            ),
           'name'=> array(
                    'placeholder' => 'Menu Name',
                    'id'          => 'name',
                    'name'        => 'name',
                    'value'       => $this->val[0]['name'],
                    'class'       => 'form-control',
                    'required'    => '',
                    'autofocus'   => ''
            ),
           'chkmainmenu'=> array(
                    'id'        => 'chkmainmenu',
                    'value'     => 'ok',
                    'checked'   => $checked,
                    'class'     => 'filled-in',
            ),
            'mainmenuid'=> array(
                    'attr'        => array(
                        'id'    => 'mainmenuid',
                        'class' => 'form-control',
                    ),
                    'data'     => $opt_mainmenu,
                    'value'   => $this->val[0]['mainmenuid'],
                    'name'     => 'mainmenuid',
            ),
           'link'=> array(
                    'placeholder' => 'Link Menu',
                    'id'          => 'link',
                    'name'        => 'link',
                    'value'       => $this->val[0]['link'],
                    'class'       => 'form-control',
                    'required'    => '',
            ),
           'icon'=> array(
                    'placeholder' => 'Icon Menu',
                    'id'          => 'icon',
                    'name'        => 'icon',
                    'value'       => $this->val[0]['icon'],
                    'class'       => 'form-control',
            ),
            'description'=> array(
                    'placeholder' => 'Description',
                    'id'          => 'description',
                    'name'        => 'description',
                    'value'       => $this->val[0]['description'],
                    'class'       => 'form-control',
                    'style'       => 'resize: vertical;height: 80px;',
            ),
            'statmenu'=> array(
                    'attr'        => array(
                        'id'    => 'statmenu',
                        'class' => 'form-control',
                    ),
                    'data'     => $opt_statmenu,
                    'value'   => $this->val[0]['statmenu'],
                    'name'     => 'statmenu',
            ),
        );
    }
    
    private function _check_id($id){
        if(empty($id)){
            redirect($this->data['add']);
        }
        
        $this->val= $this->menus_qry->select_data($id);
        
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
                    'label' => 'Menu Name',
                    'rules' => 'required|alpha_numeric_spaces|max_length[50]',
                ),
            array(
                    'field' => 'description',
                    'label' => 'Description',
                    'rules' => 'alpha_numeric_spaces|max_length[250]',
                    ),
            array(
                    'field' => 'link',
                    'label' => 'Link',
                    'rules' => 'required|max_length[150]',
                    ),
            array(
                    'field' => 'statmenu',
                    'label' => 'Status',
                    'rules' => 'required|alpha_numeric_spaces|max_length[15]',
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
