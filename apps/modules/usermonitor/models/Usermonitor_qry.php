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
 * Description of Usermonitor_qry
 *
 * @author adi
 */
class Usermonitor_qry extends CI_Model{
    //put your code here
    protected $res="";
    protected $delete="";
    protected $state="";
    public function __construct() {
        parent::__construct();        
    }
    
    public function json_dgview() {
        error_reporting(-1);
        if( isset($_GET['id']) ){
            $id = $_GET['id'];
        }else{
            $id = '';
        }        
        
        $aColumns = array(
                        'timestamp',
                        'data',
                        'ip_address',
                        'data',
                        'data',
                        'id',
                    );
	$sIndexColumn = "id";
        if(!empty($_GET['iDisplayLength'])){
            $sLimit = " LIMIT " . $_GET['iDisplayLength'];
        }
        $sTable = " (SELECT
                        id,
                        ip_address,
                        timestamp,
                        data
                      FROM ci_sessions
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
                if(base64_decode($aRow['data'],true)){
                    $session_data = base64_decode($aRow['data']);
                }else{
                    $session_data = $aRow['data'];
                }
                $return_data = array();
                $offset = 0;
                while ($offset < strlen($session_data)) {
                    if (!strstr(substr($session_data, $offset), "|")) {
                        echo ("invalid data, remaining: " . substr($session_data, $offset));
                    }
                    $pos = strpos($session_data, "|", $offset);
                    $num = $pos - $offset;
                    $varname = substr($session_data, $offset, $num);
                    $offset += $num + 1;
                    $data = unserialize(substr($session_data, $offset));
                    $return_data[$varname] = $data;
                    $offset += strlen(serialize($data));
                }         
                if(!empty($return_data['first_name'])){
                    $row[0] = date("d-m-Y H:i:s",$return_data['__ci_last_regenerate']);
                    $row[1] = $return_data['first_name']." ".$return_data['last_name'];
                    $row[2] = $aRow['ip_address'];
                    $row[3] = $return_data['browser'];
                    $row[4] = $return_data['platform'];
                    $row[5] = "<button class=\"btn btn-sm btn-danger\" onclick=\"logout_user('".$aRow['id']."','".$return_data['username']."');\">Logout</button>";
                    $output['aaData'][] = $row;
                }
	}
	echo  json_encode( $output );  
    }
}
