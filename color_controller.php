
<?php
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $color = $_REQUEST['color'];
  $accessories_type_id=$_REQUEST['Type_list'];
  //print_r($userid);
  //echo $accessories_model_id;

}
$data = array(
  "accessories_type_id" => "$accessories_type_id",
  "color_name" => "'$color'",
  "status" => "1",
  "created_at" => "'".date("Y-m-d H:i:s",time())."'"
);
$chkid = $db->verifyType($color,$accessories_type_id);
 //$chkid = 0;
if ($chkid == 0 ) {
  $id = $db->insert($data, 'accessories_color');
  echo 1;
} else if($chkid == 1){
  echo 2;
  exit();
}



?>
