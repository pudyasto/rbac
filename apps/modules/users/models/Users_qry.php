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
 * Description of Users_qry
 *
 * @author adi
 */
class Users_qry extends CI_Model{
    //put your code here
    protected $res="";
    protected $delete="";
    protected $state="";
    public function __construct() {
        parent::__construct();        
    }
    
    public function ref_mstgroup() {
        $this->db->order_by('name','ASC');
        $query = $this->db->get('groups');
        return $query->result_array();
    }
    
    public function select_data($param) { 
        $str = "SELECT users.id
                        , users.ip_address
                        , users.username
                        , users.email
                        , users.first_name
                        , users.last_name
                        , users.phone
                        , users.company
                        , users_groups.group_id
                        , users.active
                      FROM users
                        INNER JOIN users_groups
                            ON users_groups.user_id = users.id
                      WHERE users.id='".$param."'";
        $query = $this->db->query($str);
        return $query->result_array();
    }
    
    public function json_dgview() {
        error_reporting(-1);
        if( isset($_GET['id']) ){
            $id = $_GET['id'];
        }else{
            $id = '';
        }        
        
        $aColumns = array('first_name','last_name', 'email','groupname', 'active', 'id' );
	$sIndexColumn = "id";
        if(!empty($_GET['iDisplayLength'])){
            $sLimit = " LIMIT " . $_GET['iDisplayLength'];
        }
        $sTable = " (SELECT
                        users.id,
                        users.email,
                        users.last_login,
                        CASE WHEN users.active = 1 THEN 'Enabled' ELSE 'Disabled' END AS active,
                        users.first_name,
                        users.last_name,
                        users.phone,
                        groups.name AS groupname
                      FROM users
                        INNER JOIN users_groups
                            ON users_groups.user_id = users.id
                        INNER JOIN groups 
                            ON users_groups.group_id = groups.id
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
         * QUERY YANG AKAN DITAMPILKAN
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
                $row[5] = "<a style=\"margin-bottom: 0px;\" class=\"btn btn-default btn-xs \" href=\"".site_url('users/edit/'.$aRow['id'])."\">Edit</a>";
                $row[6] = "<button style=\"margin-bottom: 0px;\" class=\"btn btn-danger btn-xs btn-deleted \" onclick=\"deleted('".$aRow['id']."');\">Delete</button>";
		$output['aaData'][] = $row;
	}
	echo  json_encode( $output );  
    }
}
