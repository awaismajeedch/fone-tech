<?php

class DB {
<<<<<<< HEAD
	
	//open a connection to the database. Make sure this is called 
	//on every page that needs to use the database.
	//public $mysqli;
	/* For Local DB 
=======

	//open a connection to the database. Make sure this is called
	//on every page that needs to use the database.
	//public $mysqli;
	/* For Local DB
>>>>>>> 46e44756b774369af10599fe888c779016a174b8
	public $db_name = 'admin_foneworld';
	public $db_user = 'admin_foneworld';
	public $db_pass = 'PS0PD6WHEZ';
	public $db_host = '88.99.130.170';
        */
        public $db_name = 'foneworld';
<<<<<<< HEAD
	public $db_user = 'fwdbuser';
	public $db_pass = '@dmin123';
	public $db_host = 'localhost';  


	
	public $mysqli;
	public function connect() {
	 			
		$this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass, $this->db_name);

		if($this->mysqli->connect_error) 
			die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());

		return $this->mysqli;	
	}
	
=======
	public $db_user = 'admin';
	public $db_pass = 'admin';
	public $db_host = '127.0.0.1';



	public $mysqli;
	public function connect() {

		$this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass, $this->db_name);

		if($this->mysqli->connect_error)
			die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());

		return $this->mysqli;
	}

>>>>>>> 46e44756b774369af10599fe888c779016a174b8
	//takes a mysql row set and returns an associative array, where the keys
	//in the array are the column names in the row set. If singleRow is set to
	//true, then it will return a single row instead of an array of rows.
	public function processRowSet($rowSet, $singleRow=false)
	{
		$resultArray = array();
		while($row = $rowSet->fetch_assoc($this->mysqli))
		{
			array_push($resultArray, $row);
		}
<<<<<<< HEAD
		
		if($singleRow === true)
			return $resultArray[0];
			
		return $resultArray;
	}
	
=======

		if($singleRow === true)
			return $resultArray[0];

		return $resultArray;
	}

>>>>>>> 46e44756b774369af10599fe888c779016a174b8
	//Select rows from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function select($table,$orderby, $where) {
		$resultArray = array();
<<<<<<< HEAD
		$sql = "SELECT * FROM $table WHERE $where $orderby";								
=======
		$sql = "SELECT * FROM $table WHERE $where $orderby";
>>>>>>> 46e44756b774369af10599fe888c779016a174b8
		//echo $sql;
		$result = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
		$totalrecs = $result->num_rows;
		if ($totalrecs > 0) {
			while($row = $result->fetch_assoc())
			{
				array_push($resultArray, $row);
			}
		//echo ($resultArray);
			return $resultArray;
		} else {
<<<<<<< HEAD
			return 0;	
		}	
	}
	public function selectQuery($sql) {
		$resultArray = array();
		//$sql = "SELECT * FROM $table WHERE $where $orderby";								
=======
			return 0;
		}
	}
	public function selectQuery($sql) {
		$resultArray = array();
		//$sql = "SELECT * FROM $table WHERE $where $orderby";
>>>>>>> 46e44756b774369af10599fe888c779016a174b8
		//echo $sql;
		$result = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
		$totalrecs = $result->num_rows;
		if ($totalrecs > 0) {
			while($row = $result->fetch_assoc())
			{
				array_push($resultArray, $row);
			}
		//echo ($resultArray);
			return $resultArray;
		} else {
<<<<<<< HEAD
			return 0;	
		}	
	}
	
=======
			return 0;
		}
	}

>>>>>>> 46e44756b774369af10599fe888c779016a174b8
	//Select data and returns records thi is for pagination.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function selectData($table, $where, $orderby, $startPage, $recordsPerPage) {
		$resultArray = array();
<<<<<<< HEAD
		$sql = "SELECT * FROM $table WHERE $where $orderby";			
		$sqlstr = $sql." LIMIT ".$startPage.", ".$recordsPerPage;
		//echo $sqlstr;
		$result = $this->mysqli->query($sqlstr) or die($this->mysqli->error.__LINE__);
				
=======
		$sql = "SELECT * FROM $table WHERE $where $orderby";
		$sqlstr = $sql." LIMIT ".$startPage.", ".$recordsPerPage;
		//echo $sqlstr;
		$result = $this->mysqli->query($sqlstr) or die($this->mysqli->error.__LINE__);

>>>>>>> 46e44756b774369af10599fe888c779016a174b8
		while($row = $result->fetch_assoc())
		{
			array_push($resultArray, $row);
		}
<<<<<<< HEAD
		
		return $resultArray;
	}
	
=======

		return $resultArray;
	}

>>>>>>> 46e44756b774369af10599fe888c779016a174b8
	//Updates a current row in the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table and $where is the sql where clause.
<<<<<<< HEAD
	public function update($data, $table, $where) {						
		$setvalues = "";
		foreach ($data as $column => $value) {			
			$setvalues .= $column ." = " .$value .", ";			
		}
			$setvalues = rtrim($setvalues, ", ") ;
			$sql = "UPDATE $table SET $setvalues WHERE $where;";			
			mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}
	
	public function updateCharges($id) {						
		$sql = "UPDATE repairs SET charges = (SELECT SUM(charges) FROM repair_faults where repair_id = $id) where id = $id;";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}	
=======
	public function update($data, $table, $where) {
		$setvalues = "";
		foreach ($data as $column => $value) {
			$setvalues .= $column ." = " .$value .", ";
		}
			$setvalues = rtrim($setvalues, ", ") ;
			$sql = "UPDATE $table SET $setvalues WHERE $where;";
			mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}

	public function updateCharges($id) {
		$sql = "UPDATE repairs SET charges = (SELECT SUM(charges) FROM repair_faults where repair_id = $id) where id = $id;";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}
>>>>>>> 46e44756b774369af10599fe888c779016a174b8
	//Inserts a new row into the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table.
	public function insert($data, $table) {
		//$mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass, $this->db_name);
		$columns = "";
		$values = "";
<<<<<<< HEAD
		
=======

>>>>>>> 46e44756b774369af10599fe888c779016a174b8
		foreach ($data as $column => $value) {
			$columns .= ($columns == "") ? "" : ", ";
			$columns .= $column;
			$values .= ($values == "") ? "" : ", ";
			$values .= $value;
		}
<<<<<<< HEAD
		
		$sql = "insert into $table ($columns) values ($values)";
		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		
		//return the ID of the item in the database.
		return mysqli_insert_id($this->mysqli);
		
	}
	public function delete($id, $table) {
		
		$sql = "DELETE from $table Where id = $id";
		//echo $sql;		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		
		//return the ID of the user in the database.
		return 1;
		
	}
	
	
	public function deleteUser($id) {
				
		// Delete User
		$sql = "DELETE from users Where id = $id";		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));		
		return 1;		
	}
	
	public function deleteLab($id) {
				
		// Delete User
		$sql = "DELETE from labs Where id = $id";		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));		
		return 1;		
	}
	public function deleteUnlockdata($id) {
				
		// Delete User
		$sql = "DELETE from unlock_data Where id = $id";		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));		
		return 1;		
	}
	
	public function deleteUnlock($id) {
				
		// Delete User
		$sql = "DELETE from unlocks Where id = $id";		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));		
		return 1;		
	}
	public function deletefaults($id) {
				
		// Delete User
		$sql = "DELETE from repair_faults Where repair_id = $id";		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));		
		return 1;		
	}
	public function deleteRepair($id) {
				
		// Delete User
		$sql = "DELETE from repair_faults Where repair_id = $id";		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));		
		$sql = "DELETE from repairs Where id = $id";		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));		
		return 1;		
	}
	
	public function deletePurchase($id) {
				
		// Delete User
		$sql = "DELETE from purchase Where id = $id";		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));		
		return 1;		
	}
	
	public function deleteSale($id) {
				
		// Delete User
		$sql = "DELETE from sale Where id = $id";		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));		
		return 1;		
	}
	
=======

		$sql = "insert into $table ($columns) values ($values)";

		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));

		//return the ID of the item in the database.
		return mysqli_insert_id($this->mysqli);

	}
	public function delete($id, $table) {

		$sql = "DELETE from $table Where id = $id";
		//echo $sql;
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));

		//return the ID of the user in the database.
		return 1;

	}


	public function deleteUser($id) {

		// Delete User
		$sql = "DELETE from users Where id = $id";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}

	public function deleteLab($id) {

		// Delete User
		$sql = "DELETE from labs Where id = $id";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}
	public function deleteUnlockdata($id) {

		// Delete User
		$sql = "DELETE from unlock_data Where id = $id";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}

	public function deleteUnlock($id) {

		// Delete User
		$sql = "DELETE from unlocks Where id = $id";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}
	public function deletefaults($id) {

		// Delete User
		$sql = "DELETE from repair_faults Where repair_id = $id";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}
	public function deleteRepair($id) {

		// Delete User
		$sql = "DELETE from repair_faults Where repair_id = $id";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		$sql = "DELETE from repairs Where id = $id";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}

	public function deletePurchase($id) {

		// Delete User
		$sql = "DELETE from purchase Where id = $id";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}

	public function deleteSale($id) {

		// Delete User
		$sql = "DELETE from sale Where id = $id";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return 1;
	}

>>>>>>> 46e44756b774369af10599fe888c779016a174b8
	//Select data and returns number of records from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function totalRecords($table, $where) {
		$sql = "SELECT * FROM $table WHERE $where";
		//echo $sql;
		//exit();
		$result = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
		$totalrecs = $result->num_rows;
<<<<<<< HEAD
		return $totalrecs;		
	}
	
	
	function verifyName ( $userName=null,$id=null ) {
		$resultArray = array();
		if (!empty($id)) {
			$sql = "SELECT * FROM users WHERE id != $id AND user_name = '$userName'";						
		} else {
			$sql = "SELECT * FROM users WHERE user_name = '$userName'";
		}		
		
		$result = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
		$totalrecs = $result->num_rows;
		
=======
		return $totalrecs;
	}


	function verifyName ( $userName=null,$id=null ) {
		$resultArray = array();
		if (!empty($id)) {
			$sql = "SELECT * FROM users WHERE id != $id AND user_name = '$userName'";
		} else {
			$sql = "SELECT * FROM users WHERE user_name = '$userName'";
		}

		$result = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
		$totalrecs = $result->num_rows;

>>>>>>> 46e44756b774369af10599fe888c779016a174b8
		if ($totalrecs > 0) {
			return 1;
		} else {
			return 0;
<<<<<<< HEAD
		}	
	}
	
	public function getInvoiceNo() {
		$invid = $this->mysqli->query("SELECT current_id from invoices")->fetch_object()->current_id;
		$invid = $invid + 1;		
=======
		}
	}

	public function getInvoiceNo() {
		$invid = $this->mysqli->query("SELECT current_id from invoices")->fetch_object()->current_id;
		$invid = $invid + 1;
>>>>>>> 46e44756b774369af10599fe888c779016a174b8
		return $invid;
	}
	public function updateInvoiceNo($usedfor) {
		$invid = $this->mysqli->query("SELECT current_id from invoices")->fetch_object()->current_id;
		$invid = $invid + 1;
		//echo $invid;
		$sql = "UPDATE invoices set current_id = $invid, used_by =  '$usedfor' where id=1";
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		return $invid;
	}
}

<<<<<<< HEAD
?>
=======
?>
>>>>>>> 46e44756b774369af10599fe888c779016a174b8
