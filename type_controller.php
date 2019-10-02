
<?php
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $type = $_REQUEST['type'];
  $accessories_model_id=$_REQUEST['model_list'];
  //print_r($userid);
  //echo $accessories_model_id;

}
$data = array(
  "accessories_model_id" => "$accessories_model_id",
  "type" => "'$type'",
  "status" => "1",
  "created_at" => "'".date("Y-m-d H:i:s",time())."'"
);
$chkid = $db->verifyType($type,$accessories_model_id);
 //$chkid = 0;
if ($chkid == 0 ) {
  $id = $db->insert($data, 'accessories_type');
  echo 1;
} else if($chkid == 1){
  echo 2;
  exit();
}



?>
