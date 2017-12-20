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
 * Description of Access
 *
 * @author pudyasto
 */
class Rbac {
    //put your code here
    public function __construct(){
        $this->ci =& get_instance();
    }    
    
    public function menu_app($class) {
        $this->ci->db->where('mainmenuid',NULL, FALSE);
        $query = $this->ci->db->get('menus');
        $output['menus']= [];
        $result = $query->result(); 
        
        foreach ($result as $res)
        {        
            $row = array();
            $row['id'] = $res->id;
            $row['name'] = $res->name;
            $row['icon'] = $res->icon;
            $row['description'] = $res->description;
            $row['active'] = $this->active_menu($class,$res->id);
            $row['sub'] = $this->submenu_app($class,$res->id);
            $output['menus'][] = $row;
        }
        return $output;
    }
    
    private function active_menu($class,$id) {
        $this->ci->db->where('link',skipclass($class));
        $this->ci->db->order_by('menuorder,name');
        $query = $this->ci->db->get('menus');
        $result = $query->result_array();
        foreach ($result as $val){
            if($val['mainmenuid']==$id){
                return 'active';
            }else{
                return false;
            }
        }
    }
    
    private function submenu_app($class,$id){
        $userid = $this->ci->session->userdata('userid');
        $username = $this->ci->session->userdata('username');
        if($username=="administrator"){
            $this->ci->db->where('mainmenuid',$id);
            $this->ci->db->where('statmenu','1');
            $this->ci->db->order_by('menuorder,name');
            $query = $this->ci->db->get('menus');
        }else{
            $str = "SELECT 
                        menus.id, 
                        menus.menuorder, 
                        menus.name, 
                        menus.link, 
                        menus.icon,
                        menus.description,                        
                        menus.statmenu
                    FROM 
                        menus
                    INNER JOIN groups_access 
                        ON menus.id = groups_access.menu_id 
                    INNER JOIN users_groups 
                        ON users_groups.group_id = groups_access.group_id
                    WHERE (menus.mainmenuid='{$id}')
                        AND (users_groups.user_id = '{$userid}')
                        AND menus.statmenu = '1'
                    ORDER BY menus.name ASC"; 
            $query = $this->ci->db->query($str);            
        }
        $output['submenu']= [];
        $result = $query->result();
        foreach ($result as $row)
        {
            if(skipclass($class) == $row->link){
                $mnsub_active = 'active';
            }else{
                $mnsub_active = '';
            }   
            
            if($this->group_app($row->id)){
                $mnsub = array();
                $mnsub['id'] = $row->id;
                $mnsub['name'] = $row->name;
                $mnsub['link'] = $row->link;
                $mnsub['icon'] = $row->icon;
                $mnsub['description'] = $row->description;
                $mnsub['sub_active'] = $mnsub_active;
                $output['submenu'][] = $mnsub;
            }
        }
        return $output;
    }
    
    private function group_app($id){
        $userid = $this->ci->session->userdata('userid');
        $username = $this->ci->session->userdata('username');
        if($username=="administrator"){
            return true;
        }else{
            $str = " SELECT ga.id 
                        FROM groups_access AS ga 
                            INNER JOIN users_groups AS ug 
                                ON ga.group_id = ug.group_id
                        WHERE (ug.user_id = '".$userid."') 
                        AND (ga.menu_id = '".$id."') ";
            $query = $this->ci->db->query($str);
            $num_row = $query->num_rows();
            if ($num_row > 0){
                return true;

            }else{
                return false;
            }
        }
    }
    
    public function ceksubmenu_app($class) {     
        $this->ci->db->where('link',skipclass($class));
        $query = $this->ci->db->get('menus');
        
        if ($query)
        {
            $result = $query->result(); 
            
            return $result;
        }else{
            return false;
        } 
    }    
    
    public function module_access($action){
        $class = $this->ci->uri->segment(1);
        $userid = $this->ci->session->userdata('userid');
        $res = null;
        if((skipclass($class)=="menus") && $action=="get_menu"){
            $res = "show";
        }elseif((skipclass($class)=="dashboard" || skipclass($class)=="") 
                && $action=="show"){
            $res = "show";
        }else{
            $res = $this->_privilege(skipclass($class),$userid);
            if($action=="show" && !empty($res[0]["moduleid"])){
                $res = "show";
            }elseif($action=="add" && empty($res[0]["act_add"])){
                $res = "disabled";
            }elseif($action=="edit" && empty($res[0]["act_edit"])){
                $res = "disabled";
            }elseif($action=="del" && empty($res[0]["act_delete"])){
                $res = "disabled";
            }elseif($action=="print" && empty($res[0]["act_print"])){
                $res = "disabled";
            }else{
                $res = "";
            }
        }
//        $this->ci->db->close(); // Kalo pake postgre fitur ini dimatikan saja
        return $res;
    }
    
    private function _privilege($class,$userid) {
        $username = $this->ci->session->userdata('username');
        $binding_val = [];
        if($username == "administrator" || $class == "profile"){
            $str = "SELECT 1 moduleid ,1 act_add ,1 act_edit ,1 act_delete ,1 act_print";
        }else{
            $binding_val = [$userid, $class];
            $str = "SELECT
                        m.id,
                        ga.id moduleid,
                        substring(ga.privilege, 1, 1) act_add,
                        substring(ga.privilege, 3, 1) act_edit,
                        substring(ga.privilege, 5, 1) act_delete,
                        substring(ga.privilege, 7, 1) act_print
                    FROM
                        menus m
                    JOIN groups_access ga ON ga.menu_id = m.id
                    JOIN users_groups ug ON ug.group_id = ga.group_id
                    AND ug.user_id = ?
                    WHERE
                        m.link = ?";
                    
        }
        
        $query = $this->ci->db->query($str, $binding_val);
        return $query->result_array();
    }
}
