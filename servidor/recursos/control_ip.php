<?php

function miip(){ 

    	$ip = 0; 
		
    	if (!empty($_SERVER["HTTP_CLIENT_IP"])) 
        	$ip = $_SERVER["HTTP_CLIENT_IP"]; 
    	
		if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))    { 
        	$iplist = explode(", ", $_SERVER["HTTP_X_FORWARDED_FOR"]); 
        
		if ($ip)    { 
        	    array_unshift($iplist, $ip); 
        
		    $ip = 0; 
        } 
        
		foreach($iplist as $v) 
        
		    if (!eregi("^(192\.168|172\.16|10|224|240|127|0)\.", $v)) 
                return $v; 
    } 
	
    return ($ip) ? $ip : $_SERVER["REMOTE_ADDR"]; 
} 


function ins_ip(){

include("config.php");

$ip=miip();

$existe=sql_qfr("SELECT idlsta FROM login_ips WHERE ip like '$ip' ");

if(!$existe)
	$control_ip=sql_ins("'','$ip','1'","login_ips");
	
	else{
		$error=$existe[0]+1;	
		
		if($error>6)
			header("location:admin/bloquea.php?tipo=ip");
			
		$control_ip=sql_u(" login_error=$error "," ip= $ip","login_ips");
	}

}	
?>