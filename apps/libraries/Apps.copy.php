<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
class Apps{
    var $name="RBAC - Web Application";
    var $title="RBAC";
    var $logintitle="RBAC Web App";
    var $logindesc="Please login access your application";
    var $logintag="Rule Base Access Application";
    var $release="Version 1.0.0";
    var $ver="Version 1.0.0";
    var $modname="";
    var $moddesc="";
    var $copyright = "RBAC - Web Application";
    var $dept = "ICT";
    var $statnav="active";
    var $companyname = "Your Company";
    var $companyaddr = "Semarang, Jawa Tengah";
    var $companyinfo = "+62890 1234 1234";
    
    var $ssoapp = "";
    var $appid = "";
    var $tmpdir = "";
    private $ci=""; 


    public function __construct(){        
        $this->tmpdir = FCPATH . 'apps/cache/';
        $this->ci =& get_instance();
    }
    
    public function load_pict($location = null) {
        if($location){
            header("Content-type: image/jpg");	
            $data = fopen ($location, 'rb');
            $size=filesize ($location);
            $contents= fread ($data, $size);
            fclose ($data);
            return $contents;
        }else{
            return "No data";
        }
        
    }
    
    public function err_code($msg) {
        return $msg;
        // Customize error code here;
//        $param = html_escape(str_replace("\n","",str_replace('"', "|", $msg)));
//        if(strpos($param, 'foreign key constraint fails')){
//            return "Data tidak dapat dihapus karena terelasi dengan data lain <br> Msg : ".substr($param,0,strpos($param,'(')-1);
//        }elseif(strpos(strtolower($param), 'value violates unique constraint')){
//            return "Data tidak boleh sama <br> Msg : " . $param;
//        }elseif(strpos(strtolower($param), 'plicate entry')){
//            return "Data tidak boleh sama <br> Msg : " . $param;
//        }else{
//            return $param;
//        }
    }
    
    function curPageURL() {
        $pageURL = 'http';
        if(isset($_SERVER["HTTPS"])){
            if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
         $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
         $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    
    function curPageAddr(){
        $pageURL = 'http';
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        if(isset($_SERVER["HTTPS"])){
            if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
         $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $uri_parts[0];
        } else {
         $pageURL .= $_SERVER["SERVER_NAME"] . $uri_parts[0];
        }
        return $pageURL;
    }
    
    function dateConvert($param){
        if(!empty($param)){
            $date_id = explode('-', $param);
            return $date_id[2].'-'.$date_id[1].'-'.$date_id[0];
        }else{
            return false;
        }
    }
}
