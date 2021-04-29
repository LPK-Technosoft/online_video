<?php

$page_title="Manage Suggestion";

include("includes/header.php");
require("includes/function.php");
require("language/language.php");

$sql="SELECT suggets.*, users.`name` FROM tbl_user_suggest suggets
      LEFT JOIN  tbl_users users
      ON suggets.`user_id`=users.`id`
      ORDER BY suggets.`id` DESC";

$result=mysqli_query($mysqli,$sql);

?>

<link rel="stylesheet" type="text/css" href="assets/css/stylish-tooltip.css">

<div class="row">
  <div class="col-xs-12">
    <div class="card mrg_bottom">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top manage_report_btn">
        <button type="button" class="btn btn-danger btn_cust btn_checked_delete" value="delete_post"><i class="fa fa-trash"></i> Delete Checked</button>
        <hr/>
        <table class="datatable table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th width="30">
                <div class="checkbox" style="margin: 0px">
                  <input type="checkbox" name="checkall" id="checkall" value="">
                  <label for="checkall"></label>
                </div>
              </th>                    
              <th>User</th>
              <th>Title</th>
              <th>Desciption</th> 
              <th>Image</th> 
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
           <?php
           $i=0;
           while($row=mysqli_fetch_array($result))
           {
            ?>
            <tr>
              <td width="30">
                <div class="checkbox" style="margin: 0px">
                  <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i; ?>" value="<?php echo $row['id']; ?>" class="post_ids" style="margin: 0px;">
                  <label for="checkbox<?php echo $i;?>"></label>
                </div>
              </td>                 
              <td><?php echo $row['name'];?></td>
              <td><?php echo $row['title'];?></td>
              <td><p><?php echo $row['description'];?></p></td>
              <td>
                <span class="mytooltip tooltip-effect-3">
                  <span class="tooltip-item">
                    <img src="thumb.php?src=images/<?php echo $row['image'];?>&size=50x60" style="width: 50px;height: 60px">
                  </span> 
                  <span class="tooltip-content clearfix">
                    <a href="images/<?php echo $row['image'];?>" target="_blank"><img src="images/<?php echo $row['image'];?>" /></a>
                  </span>
                </span>
              </td>   
              <td>
                <?=date('d-m-Y',$row['created_at'])?>
              </td>             
              <td>
                <a href="javascript:void(0)" class="btn btn-danger btn_delete" data-id="<?php echo $row['id']; ?>" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a></td>
              </tr>
              <?php

              $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>     


<?php include("includes/footer.php");?>   

<script type="text/javascript">
  $('a[data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'bottom',
    html: true
  });

  // for delete action
  $(".btn_delete").click(function(e){

    e.preventDefault();

    var _ids=$(this).data("id");
    var _table='tbl_user_suggest';

    swal({
      title: "Are you sure to delete this?",
      type: "warning",
      showCancelButton: true,
      cancelButtonClass: "btn-warning",
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true
    },
    function(isConfirm) {
      if (isConfirm) {

        $.ajax({
          type:'post',
          url:'processData.php',
          dataType:'json',
          data:{'id':_ids,'table':_table,'for_action':'delete','action':'multi_action'},
          success:function(res){
            console.log(res);
            if(res.status=='1'){
              swal({
                title: "Successfully", 
                text: "Suggestion is deleted.", 
                type: "success"
              },function() {
                location.reload();
              });
            }
            else if(res.status=='-2'){
              swal(res.message);
            }
          }
        });
      }
      else{
        swal.close();
      }
    });
  });
    // end delete action

  $(".btn_checked_delete").click(function(e) {
    e.preventDefault();

    var _ids = $.map($('.post_ids:checked'), function(c) {
      return c.value;
    });
    var _action = 'delete';

    if (_ids != '') {
      swal({
        title: "Do you really want to delete?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger btn_edit",
        cancelButtonClass: "btn-warning btn_edit",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true
      },
      function(isConfirm) {
        if (isConfirm) {

          var _table = 'tbl_user_suggest';

          $.ajax({
            type: 'post',
            url: 'processData.php',
            dataType: 'json',
            data: {
              id: _ids,
              for_action: _action,
              table: _table,
              'action': 'multi_action'
            },
            success: function(res) {
              console.log(res);
              $('.notifyjs-corner').empty();
              if (res.status == '1') {
                swal({
                  title: "Successfully",
                  text: "Suggestion is deleted successfully",
                  type: "success"
                }, function() {
                  location.reload();
                });
              }
            }
          });
        } else {
          swal.close();
        }

      });
    } else {
      swal("Sorry no items selected !!")
    }
  });

  var totalItems = 0;

  $("#checkall").click(function() {

    totalItems = 0;

    $('input:checkbox').not(this).prop('checked', this.checked);
    $.each($("input[name='post_ids[]']:checked"), function() {
      totalItems = totalItems + 1;
    });

    if ($('input:checkbox').prop("checked") == true) {
      $('.notifyjs-corner').empty();
      $.notify(
        'Total ' + totalItems + ' item checked', {
          position: "top center",
          className: 'success',
          clickToHide: false,
          autoHide: false
        }
      );
    } else if ($('input:checkbox').prop("checked") == false) {
      totalItems = 0;
      $('.notifyjs-corner').empty();
    }
  });

  $(".post_ids").click(function(e) {

    if ($(this).prop("checked") == true) {
      totalItems = totalItems + 1;
    } else if ($(this).prop("checked") == false) {
      totalItems = totalItems - 1;
    }

    if (totalItems == 0) {
      $('.notifyjs-corner').empty();
      exit();
    }

    $('.notifyjs-corner').empty();

    $.notify(
      'Total ' + totalItems + ' item checked', {
        position: "top center",
        className: 'success',
        clickToHide: false,
        autoHide: false
      }
    );
  });
</script>    