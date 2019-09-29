<?php

/*** mysql hostname ***/
 
 $db_name = 'foneworld';
 $db_user = 'fwdbuser';
 $db_pass = '@dmin123';
 $db_host = 'localhost';  


/*** connect to the database ***/
$mysqli = new mysqli($db_host,$db_user,$db_pass, $db_name);

?>
