<?php 
    function log_write($str) {
        $time = date('Y-m-d H:i:s');
        $pageName = basename($_SERVER['PHP_SELF']);
        
        $fp = fopen('./logs/log.txt', 'a');
        fwrite($fp, "Time: ".$time." Here: ".$pageName." Message : ".$str."\n");
        fclose($fp);
    }
?>