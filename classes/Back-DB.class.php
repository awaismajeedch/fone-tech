<?php

class DB {
	
	//open a connection to the database. Make sure this is called 
	//on every page that needs to use the database.
	//public $mysqli;
	public $db_name = 'foneworldadnana';
	public $db_user = 'foneworldadnana';
	public $db_pass = 'G3bzC4SFtNR%Pd@y';
	public $db_host = '166.62.8.46';

	public $mysqli;
	public function connect() {
	 			
		$this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass, $this->db_name);

		if($this->mysqli->connect_error) 
			die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());

		return $this->mysqli;	
	}
	
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
		
		if($singleRow === true)
			return $resultArray[0];
			
		return $resultArray;
	}
	
	//Select rows from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function select($table,$orderby, $where) {
		$resultArray = array();
		$sql = "SELECT * FROM $table WHERE $where $orderby";								
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
			return 0;	
		}	
	}
	public function selectQuery($sql) {
		$resultArray = array();
		//$sql = "SELECT * FROM $table WHERE $where $orderby";								
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
			return 0;	
		}	
	}
	
	//Select data and returns records thi is for pagination.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function selectData($table, $where, $orderby, $startPage, $recordsPerPage) {
		$resultArray = array();
		$sql = "SELECT * FROM $table WHERE $where $orderby";			
		$sqlstr = $sql." LIMIT ".$startPage.", ".$recordsPerPage;
		//echo $sqlstr;
		$result = $this->mysqli->query($sqlstr) or die($this->mysqli->error.__LINE__);
				
		while($row = $result->fetch_assoc())
		{
			array_push($resultArray, $row);
		}
		
		return $resultArray;
	}
	
	//Updates a current row in the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table and $where is the sql where clause.
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
	
	//Inserts a new row into the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table.
	public function insert($data, $table) {
		//$mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass, $this->db_name);
		$columns = "";
		$values = "";
		
		foreach ($data as $column => $value) {
			$columns .= ($columns == "") ? "" : ", ";
			$columns .= $column;
			$values .= ($values == "") ? "" : ", ";
			$values .= $value;
		}
		
		$sql = "insert into $table ($columns) values ($values)";
		
		mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
		
		//return the ID of the user in the database.
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
	
	//Select data and returns number of records from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function totalRecords($table, $where) {
		$sql = "SELECT * FROM $table WHERE $where";
		//echo $sql;
		//exit();
		$result = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
		$totalrecs = $result->num_rows;
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
		
		if ($totalrecs > 0) {
			return 1;
		} else {
			return 0;
		}	
	}
	
	
}

?>