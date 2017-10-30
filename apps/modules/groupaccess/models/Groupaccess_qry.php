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
 * Description of Groupaccess_qry
 *
 * @author adi
 */
class Groupaccess_qry extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function submit() {
        try {
            $group_id = $this->input->post('group_id');
            $menu_id = $this->input->post('menu_id');
            $privilege = $this->input->post('privilege');
            $stat = $this->input->post('stat');
            if($stat=='submenu'){
                $cekakses = "SELECT id
                                FROM groups_access
                             WHERE group_id = '".$group_id."' AND menu_id = '".$menu_id."'";
                $qrycek = $this->db->query($cekakses);
                if($qrycek->num_rows() > 0){
                    $str = "DELETE FROM groups_access WHERE group_id = '".$group_id."' AND menu_id = '".$menu_id."';";
                }else{
                    $str = "INSERT INTO groups_access
                                       (group_id
                                       ,menu_id
                                       ,privilege)
                             VALUES
                                       ('".$group_id."'
                                       ,'".$menu_id."'
                                       ,'".$privilege."');";
                }
            }else{
                $str = "DELETE FROM groups_access WHERE group_id = '".$group_id."' AND menu_id = '".$menu_id."';
                        INSERT INTO groups_access
                                       (group_id
                                       ,menu_id
                                       ,privilege)
                             VALUES
                                       ('".$group_id."'
                                       ,'".$menu_id."'
                                       ,'".$privilege."');";
            }    
            $resl = $this->db->simple_query($str);
            if( ! $resl){
                $err = $this->db->error();
                $this->res = "<i class=\"fa fa-fw fa-warning\"></i> Error : ". $this->apps->err_code($err['message']);
                $this->state = "0";
            }else{
                $this->res = "<label class=\"label label-success\">Data Updated</label>";
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
        $this->session->set_flashdata('statsubmit', json_encode($arr));
        return json_encode($arr);
    }
    
    public function data_json_akses() {
        error_reporting(-1);
        if( isset($_GET['uid']) ){
            $uid = $_GET['uid'];
        }else{
            $uid = '';
        }
        $aColumns = array('set_access','name','submenu','description','id');
	$sIndexColumn = "id";
        
        if(!empty($_GET['iDisplayLength'])){
            $sLimit = " LIMIT " . $_GET['iDisplayLength'];
        }
        $sTable = " (SELECT a.name, b.name as submenu, b.description, b.id
                    , (SELECT id FROM groups_access AS tg 
				WHERE group_id = '".$uid."'
						AND (menu_id = b.id) 
						) AS set_access
                            FROM menus AS a INNER JOIN
                         menus AS b ON a.id = b.mainmenuid
                         ) tran_group";
        
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {   
            if($_GET['iDisplayStart']>0){
                $sLimit = "OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
                        intval( $_GET['iDisplayStart'] + $_GET['iDisplayLength'] );
            }
        }

        $sOrder = "";
        if ( isset( $_GET['iSortCol_0'] ) )
        {
                $sOrder = " ORDER BY  ";
                for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
                {
                        if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                        {
                                $sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
                                        ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
                        }
                }

                $sOrder = substr_replace( $sOrder, "", -2 );
                if ( $sOrder == " ORDER BY" )
                {
                        $sOrder = "";
                }
        }
        $sWhere = " ";
        if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
        {
                if($_GET['iDisplayStart']>0){
                    $sWhere = "AND (";
                }else{
                    $sWhere = "WHERE (";
                }

                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                        $sWhere .= "".$aColumns[$i]."::text LIKE '%". $_GET['sSearch'] ."%' OR ";
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ')';
        }
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
                if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
                {
                        if($_GET['iDisplayStart']>0){
                                $sWhere = "AND ";
                            }else{
                                $sWhere = "WHERE ";
                            }
                        $sWhere .= "lower(".$aColumns[$i].")::text LIKE '%". strtolower($this->db->escape_str($_GET['sSearch_'.$i]))."%' ";
                }
        }


        /*
         * SQL queries
         */
        $sQuery = "
                SELECT ".str_replace(" , ", " ", implode(", ", $aColumns))."
                FROM   $sTable
                $sWhere
                $sOrder
                $sLimit
                ";
        
        $rResult = $this->db->query( $sQuery);
        
        $sQuery = "
                SELECT COUNT(".$sIndexColumn.") AS jml
                FROM $sTable
                $sWhere";    //SELECT FOUND_ROWS()
        
        $rResultFilterTotal = $this->db->query( $sQuery);
        $aResultFilterTotal = $rResultFilterTotal->result_array();
        $iFilteredTotal = $aResultFilterTotal[0]['jml'];

        $sQuery = "
                SELECT COUNT(".$sIndexColumn.") AS jml
                FROM $sTable
                $sWhere";
        $rResultTotal = $this->db->query( $sQuery);
        $aResultTotal = $rResultTotal->result_array();
        $iTotal = $aResultTotal[0]['jml'];

        $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $iTotal,
                "iTotalDisplayRecords" => $iFilteredTotal,
                "aaData" => array()
        );

        foreach ( $rResult->result_array() as $aRow )
        {
                $row = array();
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
                $row[0] = $this->set_access($aRow['set_access'],$aRow['id']);
		$output['aaData'][] = $row;
	}
	echo  json_encode( $output );       
    }
    
    private function set_access($param,$mnsub_id){
        if( ! empty($param)){
            $check = "<button class=\"btn btn-success btn-sm\" type=\"button\" onclick=\"set_submenu('".$mnsub_id."')\" id=\"".$mnsub_id."\">On</button>";
        }else{
            $check = "<button class=\"btn btn-default btn-sm\" type=\"button\" onclick=\"set_submenu('".$mnsub_id."')\" id=\"".$mnsub_id."\">Off</button>";
        }
        return $check;
    }
    
    private function add_access($param,$mnsub_id){
        if( ! empty($param)){
            $check = "checked=\"checked\"";
        }else{
            $check = "";
        }
        return "<center><input type=\"checkbox\" onclick=\"set_access('".$mnsub_id."')\" ".$check." id=\"T".$mnsub_id."\" value=\"".$mnsub_id."\" /></center>";
    }
    
    private function edit_access($param,$mnsub_id){
        if( ! empty($param)){
            $check = "checked=\"checked\"";
        }else{
            $check = "";
        }
        return "<center><input type=\"checkbox\" onclick=\"set_access('".$mnsub_id."')\" ".$check." id=\"E".$mnsub_id."\" value=\"".$mnsub_id."\" /></center>";
    }
    
    private function delete_access($param,$mnsub_id){
        if( ! empty($param)){
            $check = "checked=\"checked\"";
        }else{
            $check = "";
        }
        return "<center><input type=\"checkbox\" onclick=\"set_access('".$mnsub_id."')\" ".$check." id=\"H".$mnsub_id."\" value=\"".$mnsub_id."\" /></center>";
    }    
}
