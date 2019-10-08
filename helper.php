
<?php
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $manufacturer = $_REQUEST['manufacturer_list'];
  //$userid=$_REQUEST['user_id'];
  //print_r($userid);

}
 //echo $manufacturer;

 $tableName="accessories_model";
 $where="accessories_id=$manufacturer";
 $modelList=$db->select($tableName,"",$where);
 echo "<option value=''>-----SELECT-----</option>";
 foreach($modelList as $model){
   echo "<option value='$model[id]'>$model[model]</option>";
 }

$data = array(
  "user_id" => "$userid",
  "make" => "'$make'",
  "status" => "1",
  "created_at" => "'".date("Y-m-d H:i:s",time())."'"
);
$chkid = $db->verifyMake($make);
$chkid = 0;
if ($chkid == 0 ) {
  $id = $db->insert($data, 'accessories');
  echo 1;
} else if($chkid == 1){
  echo 2;
  exit();
}



?>
