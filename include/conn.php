<?php

/*** mysql hostname ***/
<<<<<<< HEAD
 
 $db_name = 'foneworld';
 $db_user = 'fwdbuser';
 $db_pass = '@dmin123';
 $db_host = 'localhost';  
=======

 $db_name = 'foneworld';
 $db_user = 'admin';
 $db_pass = 'admin';
 $db_host = '127.0.0.1';  
>>>>>>> 46e44756b774369af10599fe888c779016a174b8


/*** connect to the database ***/
$mysqli = new mysqli($db_host,$db_user,$db_pass, $db_name);

?>
