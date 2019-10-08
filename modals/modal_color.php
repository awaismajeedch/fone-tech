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
<div class="modal fade" id="colorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Color</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="color_form" method="post" class="form-horizontal" role="form">
          <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>"/>
         <div class="control-group">
           <!-- <label  class="col-sm-2 control-label" for="inputEmail3">Model</label> -->
           <div class="col-sm-10">
            <select id="ManufacturerList" name="Manufacturer_list">
              <option value=''>-----SELECT-----</option>
              <?php
              foreach ($manufacturerList as $manufacturer) {
                  echo "<option value='$manufacturer[id]'>$manufacturer[make]</option>";
              }
              ?>
            </select>
            <select id="ModelList" name="Model_list">
            
            </select>
            
           </div>
           <div class="col-sm-10" style="margin-top:15px">
                <select id="TypeList" name="Type_list" style="margin-top:5px">
            
                </select>
               <input type="text" class="form-control" id="a_color" name="color" placeholder="Color"/>
           </div>
					 <p class="error" id = "color_error" style="color:red;display:none;margin:5px">*TYPE ALREADY EXISTS</p>
         </div>
         <div class="control-group">
           <div class="col-sm-offset-2 col-sm-10" style="margin-top:5px">
             <a href="javascript:validatecolorForm();"  class="button_bar">Save</a>
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
    $("#ManufacturerList").change(function() {
        document.getElementById("TypeList").innerHTML="";
        var serializedData = $('#color_form').serialize();
        $.post("colorHelper.php?check=manufacturer",serializedData,function(data){
        $modelList=document.getElementById("ModelList");
        $modelList.innerHTML="";
        $modelList.innerHTML=data;
      });
    });
  });

  $(document).ready(function() {
    $("#ModelList").change(function() {
        var serializedData = $('#color_form').serialize();
        $.post("colorHelper.php?check=model",serializedData,function(data){
        $modelList=document.getElementById("TypeList");
        $modelList.innerHTML="";
        $modelList.innerHTML=data;
      });
    });
  });



  function validatecolorForm () {
    var success=1;
    if ( $("#a_color").val() == "" ) {
        alert("Please enter color!");
        success = 0;
        return;
    }
    if(success == 1){
      var serializedData = $('#color_form').serialize();
      $.post("color_controller.php",serializedData,function(data){
        //console.log(data);
        if(data == 1){
          $('#colorModal').modal('hide');
          alert("Data Inserted Successfully");
          //console.log(data);
        }
        else if(data == 2){
          //console.log(data);
          $('#color_error').show();
          $('#a_color').attr('style','border-color:red');
        }
      });
      return;
    }
  }
</script>