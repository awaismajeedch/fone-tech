
<?php
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_GET['check']=="manufacturer"){
        $manufacturer = $_REQUEST['Manufacturer_list'];
        $tableName="accessories_model";
        $where="accessories_id=$manufacturer";
        $modelList=$db->select($tableName,"",$where);
        echo "<option value=''>---SELECT---</option>";
        foreach($modelList as $model){
        echo "<option value='$model[id]'>$model[model]</option>";
       }

    }
    else if($_GET['check']=="model"){
        $model = $_REQUEST['Model_list'];
        $tableName="accessories_type";
        $where="accessories_model_id=$model";
        $typeList=$db->select($tableName,"",$where);
        echo "<option value=''>---SELECT---</option>";
        foreach($typeList as $type){
        echo "<option value='$type[id]'>$type[name]</option>";
       }
       


    }
    else{
        $type = $_REQUEST['Type_list'];
        echo $type;
        $tableName="accessories_color";
        $where="accessories_type_id=$type";
        $colorList=$db->select($tableName,"",$where);
        echo "<option value=''>---SELECT---</option>";
        foreach($colorList as $color){
        echo "<option value='$color[id]'>$color[color_name]</option>";
       } 
    }
  //$userid=$_REQUEST['user_id'];
  //print_r($userid);
}
 //echo $manufacturer;

 

// $data = array(
//   "user_id" => "$userid",
//   "make" => "'$make'",
//   "status" => "1",
//   "created_at" => "'".date("Y-m-d H:i:s",time())."'"
// );
// $chkid = $db->verifyMake($make);
// $chkid = 0;
// if ($chkid == 0 ) {
//   $id = $db->insert($data, 'accessories');
//   echo 1;
// } else if($chkid == 1){
//   echo 2;
//   exit();
// }



?>
