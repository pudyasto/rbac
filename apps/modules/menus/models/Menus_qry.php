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
 * Description of Menus_qry
 *
 * @author adi
 */
class Menus_qry extends CI_Model{
    //put your code here
    protected $res="";
    protected $delete="";
    protected $state="";
    public function __construct() {
        parent::__construct();        
    }
    
    public function select_main_menu($param = null) {
        $this->db->where('mainmenuid',NULL, FALSE);
        if($param){
            $this->db->where('id !=',$param);
        }
        $query = $this->db->get('menus');
        return $query->result_array();
    }
    
    public function select_data($param) { 
        $this->db->where('id',$param);
        $query = $this->db->get('menus');
        return $query->result_array();
    }
    
    public function json_dgview() {
        error_reporting(-1);
        if( isset($_GET['id']) ){
            $id = $_GET['id'];
        }else{
            $id = '';
        }        
        
        $aColumns = array('name','submenu', 'description', 'id' );
	$sIndexColumn = "id";
        if(!empty($_GET['iDisplayLength'])){
            $sLimit = " LIMIT " . $_GET['iDisplayLength'];
        }
        $sTable = " (SELECT id
                            , name
                            , submenu
                            , description
                            FROM
                       (
                            SELECT  menus.id
                                    , menus.name
                                    , '' as submenu
                                    , menus.description 
                               FROM menus
                                    WHERE mainmenuid IS NULL
                            UNION ALL
                            SELECT  submenus.id
                                    , menus.name
                                    , submenus.name as submenu
                                    , submenus.description 
                               FROM menus
                                    INNER JOIN menus as submenus 
                                      ON submenus.mainmenuid = menus.id
                        ) menus
                    ) AS a";
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
        $sWhere = "";
        
        if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
        {
		$sWhere = " Where (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "lower(".$aColumns[$i].") LIKE '%".strtolower($this->db->escape_str( $_GET['sSearch'] ))."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
        }
        
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
            {   
                if ( $sWhere == "" )
                {
                    $sWhere = " WHERE ";
                }
                else
                {
                    $sWhere .= " AND ";
                }
                //echo $sWhere."<br>";
                $sWhere .= "lower(".$aColumns[$i].")  LIKE '%".strtolower($this->db->escape_str($_GET['sSearch_'.$i]))."%' ";    
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
        
        //echo $sQuery;
        
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
                $row[3] = "<a style=\"margin-bottom: 0px;\" class=\"btn btn-default btn-xs \" href=\"".site_url('menus/edit/'.$aRow['id'])."\">Edit</a>";
                $row[4] = "<button style=\"margin-bottom: 0px;\" class=\"btn btn-danger btn-xs btn-deleted \" onclick=\"deleted('".$aRow['id']."');\">Delete</button>";
		$output['aaData'][] = $row;
	}
	echo  json_encode( $output );  
    }
    
    public function submit() {
        try {
            $array = $this->input->post();
            if(empty($array['id'])){    
                unset($array['id']);
                $resl = $this->db->insert('menus',$array);
                echo $this->db->last_query();
                if( ! $resl){
                    $err = $this->db->error();
                    $this->res = " Error : ". $this->apps->err_code($err['message']);
                    $this->state = "0";
                }else{
                    $this->res = "Data Saved";
                    $this->state = "1";
                }

            }elseif(!empty($array['id']) && empty($array['stat'])){
                if($array['mainmenuid']=="" || empty($array['mainmenuid'])){
                    unset($array['mainmenuid']);
                    $this->db->set('mainmenuid', 'NULL', FALSE);
                }
                $this->db->where('id', $array['id']);
                $resl = $this->db->update('menus', $array);
                if( ! $resl){
                    $err = $this->db->error();
                    $this->res = " Error : ". $this->apps->err_code($err['message']);
                    $this->state = "0";
                }else{
                    $this->res = "Data Updated";
                    $this->state = "1";
                }

            }elseif(!empty($array['id']) && !empty($array['stat'])){                
                $this->db->where('id', $array['id']);
                $resl = $this->db->delete('menus');
                if( ! $resl){
                    $err = $this->db->error();
                    $this->res = " Error : ". $this->apps->err_code($err['message']);
                    $this->state = "0";
                }else{
                    $this->res = "Data Deleted";
                    $this->state = "1";
                }             
            }else{
                $this->res = "Some Variable Missing";
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
        return json_encode($arr);
    }

}
