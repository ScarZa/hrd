<?php
function string_to_ascii($string)
{
    $ascii = NULL;
	
    for ($i = 0; $i < strlen($string); $i++) 
    { 
    	$ascii += ord($string[$i]); 
    }
    
    return($ascii);
}
?>