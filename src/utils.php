<?php

namespace Utils;

class Utils {
    
    /**
     * Filters user content
     * @param  string $msg   String to filter
     * @param  integer $limit Max size
     * @return string Filtered string
     */
    function inputSafe ( $msg, $limit ) {
           if ( $msg == "") {
               return $msg;
           }
           $a = filter_var( $msg, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW );
           $b = addslashes ( $a );
           $c = substr($b, 0, $limit );
           return $c;
    }    
}



?>
