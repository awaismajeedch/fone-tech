<?php

/*** mysql hostname ***/

 $db_name = 'foneworld';
 $db_user = 'admin';
 $db_pass = 'admin';
 $db_host = '127.0.0.1';  


/*** connect to the database ***/
$mysqli = new mysqli($db_host,$db_user,$db_pass, $db_name);

?>
