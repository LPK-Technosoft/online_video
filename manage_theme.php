<?php 

    $page_title="Manage Theme";

    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");

    $tableName="tbl_theme";   
    $targetpage = "manage_theme.php"; 
    $limit = 12;

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
      $query = "SELECT COUNT(*) as num FROM $tableName";
      $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
      $total_pages = $total_pages['num'];

      $qry="SELECT * FROM tbl_theme ORDER BY tbl_theme.`id` DESC LIMIT $start, $limit";
    }
    else{

      $keyword=addslashes(trim($_GET['keyword']));

      $query = "SELECT COUNT(*) as num FROM $tableName WHERE `theme_name` LIKE '%$keyword%'";

      $targetpage = "manage_theme.php?keyword=".$_GET['keyword'];
      $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
      $total_pages = $total_pages['num'];

      $qry="SELECT * FROM tbl_theme WHERE tbl_theme.`theme_name` LIKE '%$keyword%' ORDER BY tbl_theme.`theme_name`";
    }

    $result=mysqli_query($mysqli,$qry); 

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
            <div class="add_btn_primary"> <a href="add_theme.php?add=yes&redirect=<?=$redirectUrl?>">Add Theme</a> </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
         <div class="col-md-12 mrg-top">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>Theme Gradient</th>                  
                <th>Theme Name</th>
                <th class="cat_action_list">Action</th>
              </tr>
            </thead>
            <tbody>
             <?php  
             $i=0;
             while($row=mysqli_fetch_array($result))
             {          
              ?>
              <tr> 
                <td style="width:300px;background: linear-gradient(45deg,<?=$row['gradient_color1']?>,<?=$row['gradient_color2']?>)"></td>                
                <td><?php echo $row['theme_name'];?></td>
                <td>
                  <a href="add_theme.php?theme_id=<?php echo $row['id'];?>&redirect=<?=$redirectUrl?>" class="btn btn-primary btn_cust" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a>
                  <a href="javascript:void(0)" data-id="<?=$row['id']?>" class="btn btn-danger btn_cust btn_delete_a" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php

              $i++;
            }
            ?> 
          </tbody>
        </table>
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

  $(".btn_delete_a").click(function(e){

    e.preventDefault();

    var _ids=$(this).data("id");
    var _table='tbl_theme';

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
                text: "Theme is deleted.", 
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
</script>      
