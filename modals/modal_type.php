<style media="screen">
  .modal-body .form-horizontal .col-sm-2,
  .modal-body .form-horizontal .col-sm-10 {
    width: 100%
  }

  .modal-body .form-horizontal .control-label {
    text-align: left;
  }
  .modal-body .form-horizontal .col-sm-offset-2 {
    margin-left: 15px;
  }
</style>
  <?php
    $tableName='accessories';
    $where='status=1';
    $manufacturerList=$db->select($tableName,"",$where);
  ?>
<div class="modal fade" id="typeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="type_form" method="post" class="form-horizontal" role="form">
          <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>"/>
         <div class="control-group">
           <!-- <label  class="col-sm-2 control-label" for="inputEmail3">Model</label> -->
           <div class="col-sm-10">
            <select id="manufacturerList" name="manufacturer_list">
              <option value=''>-----SELECT-----</option>
              <?php
              foreach ($manufacturerList as $manufacturer) {
                  echo "<option value='$manufacturer[id]'>$manufacturer[make]</option>";
              }
              ?>
            </select>
            <select id="modelList" name="model_list">
              
            </select>
           </div>
           <div class="col-sm-10" style="margin-top:15px">
               <input type="text" class="form-control" id=a_model" name="model" placeholder="Model"/>
           </div>
					 <p class="error" id = "model_error" style="color:red;display:none;margin:5px">*MAKE ALREADY EXISTS</p>
         </div>
         <div class="control-group">
           <div class="col-sm-offset-2 col-sm-10" style="margin-top:5px">
             <a href="javascript:validatemodelForm();"  class="button_bar">Save</a>
             <!-- //<button type="submit" class="button-bar">Create</button> -->
           </div>
         </div>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {

    $("#manufacturerList").change(function() {

      var serializedData = $('#type_form').serialize();
      $.post("helper.php",serializedData,function(data){
        $modelList=document.getElementById("modelList");
        $modelList.innerHTML="";
        $modelList.innerHTML=data;
       //console.log(data);
      // var el = $(this) ;

      // if(el.val() === "ONLINE" ) {
      // $("#status").append("<option>SHIPPED</option>");
      // }
      // else if(el.val() === "MANUAL" ) {
      //   $("#status option:last-child").remove() ; 
      });
    });

  });


  function validatemodelForm () {
    var success=1;
    if ( $("#a_model").val() == "" ) {
        alert("Please enter model!");
        success = 0;
        return;
    }
    if(success == 1){
      var serializedData = $('#model_form').serialize();
      $.post("model_controller.php",serializedData,function(data){

        if(data == 1){
          $('#modelModal').modal('hide');
          alert("Data Inserted Successfully");
          //console.log(data);
        }
        else if(data == 2){
          //console.log(data);
          $('#model_error').show();
          $('#model').attr('style','border-color:red');
        }
      });
      return;
    }
  }
</script>