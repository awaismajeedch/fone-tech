
<?php
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $model = $_REQUEST['model'];
  $accessories_id=$_REQUEST['manufacturer_list'];
  //print_r($userid);

}
$data = array(
  "accessories_id" => "$accessories_id",
  "model" => "'$model'",
  "status" => "1",
  "created_at" => "'".date("Y-m-d H:i:s",time())."'"
);
$chkid = $db->verifyModel($model,$accessories_id);
// $chkid = 0;
if ($chkid == 0 ) {
  $id = $db->insert($data, 'accessories_model');
  echo 1;
} else if($chkid == 1){
  echo 2;
  exit();
}



?>
