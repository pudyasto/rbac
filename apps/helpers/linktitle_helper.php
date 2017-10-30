<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('linktitle'))
{      
    function linktitle($param) {
        $lower = trim(strtolower($param));
        $space = str_replace(" ", "-", $lower); 
        $dot = str_replace(".", "", $space); 
        $quote = str_replace("'", "", $dot); 
        return $quote;                        
    }     
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

