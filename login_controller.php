<<<<<<< HEAD
<?php 
=======
<?php
>>>>>>> 46e44756b774369af10599fe888c779016a174b8

//error_reporting(0);
//ini_set('display_errors', 1);
require_once 'include/conn.php';

<<<<<<< HEAD
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables
	$username = $_REQUEST['txtusername'];
	$pass_word = $_REQUEST['txtpassword'];	
	$user_ip = $_REQUEST['txtuserip'];	
	$user_ip = ip2long($user_ip);
	$password = md5($pass_word);
	$query = "";
	
	if ($username == "superadmin")  {
		$query = "SELECT * FROM users WHERE user_name='$username' AND user_type = 'superadmin' AND password = '$password' ";
	} else { 	
		$query = "SELECT * FROM users WHERE user_name='$username' AND password = '$password'";		
	}
	//echo $query;
	
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	
=======
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	//retrieve the $_POST variables
	$username = $_REQUEST['txtusername'];
	$pass_word = $_REQUEST['txtpassword'];
	$user_ip = $_REQUEST['txtuserip'];
	$user_ip = ip2long($user_ip);
	$password = md5($pass_word);
	$query = "";

	if ($username == "superadmin")  {
		$query = "SELECT * FROM users WHERE user_name='$username' AND user_type = 'superadmin' AND password = '$password' ";
	} else {
		$query = "SELECT * FROM users WHERE user_name='$username' AND password = '$password'";
	}
	//echo $query;

	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

>>>>>>> 46e44756b774369af10599fe888c779016a174b8
	// GOING THROUGH THE DATA
	if($result->num_rows > 0) {
		session_start();
		while($row = $result->fetch_assoc()) {
			$userip = $row['user_ip'];
			if ((!empty($userip)) && (trim($user_ip) != trim($userip))) {
				//echo $row['user_ip'];
				//echo $user_ip;
<<<<<<< HEAD
				echo 1; 
				exit();
			}
			else {
				$_SESSION["user_id"] = $row['id'];			
				$_SESSION["user_name"] = $row['user_name'];
				$_SESSION["user_type"] = $row['user_type'];			
				$_SESSION["shop_id"] = $row['shop_id'];											
			
				if ((strtolower($row['user_type']) == 'admin'))		
					echo 'repairs.php';					
				else if ((strtolower($row['user_type']) == 'lab'))
					echo 'labrepairs.php';
				else if ((strtolower($row['user_type']) == 'unlock'))
					echo 'labunlocking.php';	
				else if (strtolower($row['user_type']) == 'superadmin')			
					echo 'prices.php';
				else if (strtolower($row['user_type']) == 'attendent')			
					echo 'attendent_shops_attendance.php';	
				else if (strtolower($row['user_type']) == 'employee')			
					echo 'attendance.php';					
				else 
					echo 0;		
			}		
=======
				echo 1;
				exit();
			}
			else {
				$_SESSION["user_id"] = $row['id'];
				$_SESSION["user_name"] = $row['user_name'];
				$_SESSION["user_type"] = $row['user_type'];
				$_SESSION["shop_id"] = $row['shop_id'];

				if ((strtolower($row['user_type']) == 'admin'))
					echo 'repairs.php';
				else if ((strtolower($row['user_type']) == 'lab'))
					echo 'labrepairs.php';
				else if ((strtolower($row['user_type']) == 'unlock'))
					echo 'labunlocking.php';
				else if (strtolower($row['user_type']) == 'superadmin')
					echo 'prices.php';
				else if (strtolower($row['user_type']) == 'attendent')
					echo 'attendent_shops_attendance.php';
				else if (strtolower($row['user_type']) == 'employee')
					echo 'attendance.php';
				else
					echo 0;
			}
>>>>>>> 46e44756b774369af10599fe888c779016a174b8
		}
		exit();
	}
	else {
<<<<<<< HEAD
		echo 0;	
	}
}	
=======
		echo 0;
	}
}
>>>>>>> 46e44756b774369af10599fe888c779016a174b8

?>
