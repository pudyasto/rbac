<?php

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
 * Description of Profile_qry
 *
 * @author adi
 */
class Profile_qry extends CI_Model{
    //put your code here
    protected $res="";
    protected $delete="";
    protected $state="";
    public function __construct() {
        parent::__construct();        
    }
    
    public function select_data() { 
        $id = $this->session->userdata('userid');
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->result_array(); 
    }
    
    public function submit_profile(){
        try {
            $array = $this->input->post();
            $this->db->where('id', $array['id']);
            unset($array['id']);
            $resl = $this->db->update('users', $array);

            if( ! $resl){
                $err = $this->db->error();
                $this->res = " Error : ". $this->apps->err_code($err['message']);
                $this->state = "0";
            }else{
                $this->res = "Data Updated";
                $this->state = "1";
            }
            
        }catch (Exception $e) {            
            $this->res = $e->getMessage();
            $this->state = "0";
        } 
        
        $arr = array(
            'state' => $this->state, 
            'msg' => $this->res,
            );
        
        return $arr;
    }
    
    public function submit_password() {
        try {
            $array = $this->input->post();
            $id = $array['id'];
            $data = array(
                            'password' => $array['password2'],
                );
            $resl = $this->ion_auth->update($id, $data);
            
            if( ! $resl){
                $err = $this->db->error();
                $this->res = " Error : ". $this->apps->err_code($err['message']);
                $this->state = "0";
            }else{
                $this->res = "Data Updated";
                $this->state = "1";
            }
            
        }catch (Exception $e) {            
            $this->res = $e->getMessage();
            $this->state = "0";
        } 
        
        $arr = array(
            'state' => $this->state, 
            'msg' => $this->res,
            );
        
        return $arr;
    }
    
    public function upload_photo() {
        try {
            $array = $this->input->post();
            if(isset( $_FILES['pictureFile'] ) == FALSE){
                $result = array(
                    "state" => "0",
                    "msg" => "Picture can't empty!",
                  );
                echo json_encode($result); 
                exit;
            }
            
            if( isset( $_FILES['pictureFile'] ) == TRUE ){
                $filename = $this->session->userdata('userid');
                if($_FILES['pictureFile']['name'] != ""){                    
                        $config = array(
                            'upload_path' => './files/',
                            'allowed_types' => 'jpg|png|jpeg',
                            'file_name' => $filename,
                            'file_ext_tolower' => TRUE,
                            'overwrite' => TRUE,
                            'max_size' => 2048,
                            'max_width' => 0,
                            'max_height' => 0,           
                            'min_width' => 0,
                            'min_height' => 0,     
                            'max_filename' => 0,
                            'remove_spaces' => TRUE
                        );
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload('pictureFile')){
                        //$this->upload->display_errors()
                        $result = array(
                            "state" => "0",
                            "msg" => $this->upload->display_errors(),
                          );
                        echo json_encode($result);
                        exit;
                    }
                    else{
                        $upload_data = $this->upload->data();
                        $upload_stat = TRUE;
                        $array['pictureFile'] = $upload_data['file_name'];
                    }
                }
                else{
                    $upload_data = "";
                    $upload_stat = TRUE;
                    unset($array['pictureFile']);
                }
            }else{
                unset($array['pictureFile']);
            }
            
            if($upload_stat){
                $this->load->library('image_lib');
                
                $full_path = $upload_data['full_path'];
                //$image_width = $upload_data['image_width'];
                $image_height = $upload_data['image_height'];
                
                $config['image_library'] = 'gd2';
                $config['source_image'] = $full_path;

                
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = true;
                if($image_height > 256){
                    $config['width']        = 0;
                    $config['height']       = 256;                    
                }
                
                $this->image_lib->initialize($config);
                $resl = $this->image_lib->resize();
                
                if( ! $resl){
                    $this->res = " Error : Unable to resize";
                    $this->state = "0";
                }else{
                    $this->res = "Data Saved";
                    $this->state = "1";
                }
            }
            else{
                $this->res = "Upload Error!, Some Variable Missing";
                $this->state = "0";
            }
            
        }catch (Exception $e) {            
            $this->res = " Error 001 : " . $e->getMessage();
            $this->state = "0";
        } 
        
        $arr = array(
            'state' => $this->state, 
            'msg' => $this->res,
            );
        
        echo json_encode($arr);
        exit;
    }
}
