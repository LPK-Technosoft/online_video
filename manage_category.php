<?php

$page_title="Manage Categories"; 

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

$tableName="tbl_category";   
$targetpage = "manage_category.php"; 
$limit = 12; 

$keyword='';

if(!isset($_GET['keyword'])){
  $query = "SELECT COUNT(*) as num FROM $tableName";
}
else{

  $keyword=addslashes(trim($_GET['keyword']));

  $query = "SELECT COUNT(*) as num FROM $tableName WHERE `category_name` LIKE '%$keyword%'";

  $targetpage = "manage_category.php?keyword=".$_GET['keyword'];

}

$total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
$total_pages = $total_pages['num'];

$stages = 3;
$page=0;
if(isset($_GET['page'])){
  $page = mysqli_real_escape_string($mysqli,$_GET['page']);
}
if($page){
  $start = ($page - 1) * $limit; 
}else{
  $start = 0; 
} 

if(!isset($_GET['keyword'])){
  $sql_query="SELECT * FROM tbl_category ORDER BY tbl_category.`cid` DESC LIMIT $start, $limit"; 
}
else{

  $sql_query="SELECT * FROM tbl_category WHERE `category_name` LIKE '%$keyword%' ORDER BY tbl_category.`cid` DESC LIMIT $start, $limit"; 
}

$result=mysqli_query($mysqli,$sql_query) or die(mysqli_error($mysqli));

function get_total_songs($cat_id)
{ 

  global $mysqli;   
  $qry_songs="SELECT COUNT(*) as num FROM tbl_mp3 WHERE cat_id='".$cat_id."'";
  $total_songs = mysqli_fetch_array(mysqli_query($mysqli,$qry_songs));
  $total_songs = $total_songs['num'];
  return $total_songs;

}

?>

<div class="row">
  <div class="col-xs-12">
    <div class="card mrg_bottom">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
        <div class="col-md-7 col-xs-12">
          <div class="search_list">
            <div class="search_block">
              <form method="get" action="">
                <input class="form-control input-sm" placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="keyword" value="<?php if(isset($_GET['keyword'])){ echo $_GET['keyword'];} ?>" required="required">
                <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
              </form>  
            </div>
            <div class="add_btn_primary"> <a href="add_category.php?add=yes&redirect=<?=$redirectUrl?>">Add Category</a> </div>
          </div>
        </div>
        <div class="col-md-3 col-xs-12 text-right" style="float: right;">
          <div class="checkbox" style="width: 95px;margin-top: 5px;margin-left: 10px;right: 100px;position: absolute;">
            <input type="checkbox" id="checkall_input">
            <label for="checkall_input">
              Select All
            </label>
          </div>
          <div class="dropdown" style="float:right">
            <button class="btn btn-primary dropdown-toggle btn_cust" type="button" data-toggle="dropdown">Action
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" style="right:0;left:auto;">
              <li><a href="javascript:void(0)" class="actions" data-action="enable">Enable</a></li>
              <li><a href="javascript:void(0)" class="actions" data-action="disable">Disable</a></li>
              <li><a href="javascript:void(0)" class="actions" data-action="delete">Delete !</a></li>
            </ul>
          </div>
        </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 mrg-top">
          <div class="row">
            <?php 
            $i=0;
            while($row=mysqli_fetch_array($result))
            {         
              ?>
              <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="block_wallpaper">
                  <div class="wall_category_block">
                    <h2>
                      <?php 
                      if(strlen($row['category_name']) > 17){
                        echo substr(stripslashes($row['category_name']), 0, 17).'...';  
                      }else{
                        echo $row['category_name'];
                      }
                      ?><span>(<?php echo get_total_songs($row['cid']);?>)</span>
                    </h2>
                    <div class="checkbox" style="float: right;z-index: 1">
                      <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $row['cid']; ?>" class="post_ids">
                      <label for="checkbox<?php echo $i;?>">
                      </label>
                    </div>
                  </div>           
                  <div class="wall_image_title">
                    <ul>                
                      <li><a href="add_category.php?cat_id=<?php echo $row['cid'];?>&redirect=<?=$redirectUrl?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>               
                      <li>
                        <a href="javascript:void(0)" class="btn_delete_a" data-id="<?php echo $row['cid'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                      </li>
                      
                      <?php if($row['status']!="0"){?>
                        <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['cid'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="" /></a></div></li>

                      <?php }else{?>
                        <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['cid'];?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="" /></a></div></li>
                      <?php }?>

                    </ul>
                  </div>
                  <span><img src="images/<?php echo $row['category_image'];?>" style="height: 100%"/></span>
                </div>
              </div>
              <?php

              $i++;
            }
            ?>     

          </div>
        </div>
        <div class="col-md-12 col-xs-12">
          <div class="pagination_item_block">
            <nav>
              <?php include("pagination.php"); ?>
            </nav>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>

  <?php include("includes/footer.php");?>

  <script type="text/javascript">
    $(".toggle_btn a").on("click",function(e){
      e.preventDefault();

      var _for=$(this).data("action");
      var _id=$(this).data("id");
      var _column=$(this).data("column");
      var _table='tbl_category';

      $.ajax({
        type:'post',
        url:'processData.php',
        dataType:'json',
        data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'cid'},
        success:function(res){
          console.log(res);
          if(res.status=='1'){
            location.reload();
          }
        }
      });

    });

    // for delete action
    $(".btn_delete_a").click(function(e){

      e.preventDefault();

      var _ids=$(this).data("id");
      var _table='tbl_category';

      swal({
        title: "Are you sure to delete this?",
        text: "All data will be deleted which belong to this!",
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
                  text: "Category is deleted.", 
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


  $(".actions").click(function(e) {
    e.preventDefault();

    var _ids = $.map($('.post_ids:checked'), function(c) {
      return c.value;
    });
    var _action = $(this).data("action");

    if (_ids != '') {
      swal({
        title: "Action: "+$(this).text(),
        text: "Do you really want to perform?",
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

          var _table = 'tbl_category';

          $.ajax({
            type: 'post',
            url: 'processData.php',
            dataType: 'json',
            data: {
              id: _ids,
              for_action: _action,
              table: _table,
              'action': 'multi_action',
              'tbl_id': 'cid',
              'column':'status',
            },
            success: function(res) {
              console.log(res);
              $('.notifyjs-corner').empty();
              if (res.status == '1') {
                swal({
                  title: "Successfully",
                  text: "You have successfully done",
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
      swal("Sorry no data selected !!")
    }
  });

  var totalItems = 0;

  $("#checkall_input").click(function() {

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
