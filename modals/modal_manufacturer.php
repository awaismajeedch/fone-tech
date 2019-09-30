<?php

	error_reporting(0);
	// session_start();
	//9bb779c12578b514a415193870a23a47
?>
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



<div class="modal fade" id="manufacturerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Menufacturer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="manufacturer_form" method="post" class="form-horizontal" role="form">
          <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>"/>
         <div class="control-group">
           <label  class="col-sm-2 control-label" for="inputEmail3">Make</label>
           <div class="col-sm-10">
               <input type="text" class="form-control"
               id="manufacturer" name="make" placeholder="Manufacturer"/>
           </div>
					 <p class="error" id = "manufacturer_error" style="color:red;display:none;margin:5px">*MAKE ALREADY EXISTS</p>
         </div>
         <div class="control-group">
           <div class="col-sm-offset-2 col-sm-10" style="margin-top:5px">
             <a href="javascript:validatemakeForm();"  class="button_bar">Save</a>
             <!-- //<button type="submit" class="button-bar">Create</button> -->
           </div>
         </div>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function validatemakeForm () {
  var success=1;
  if ( document.getElementById("manufacturer").value == "" ) {

      alert("Please enter manufacturer!");
      success = 0;
      return;
  }
  if(success == 1){
    var serializedData = $('#manufacturer_form').serialize();
    $.post("manufacturer_controller.php",serializedData,function(data){

      if(data == 1){
				$('#manufacturerModal').modal('hide');
        alert("Data Inserted Successfully");
        //console.log(data);
      }
      else if(data == 2){
        //console.log(data);
				$('#manufacturer_error').show();
				$('#manufacturer').attr('style','border-color:red');
      }
    });
    return;
  }
}
</script>
