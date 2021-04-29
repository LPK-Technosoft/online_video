<?php 
    
    $page_title=(isset($_GET['cat_id'])) ? 'Edit Category' : 'Add Category';

    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");

    require_once("thumbnail_images.class.php");

    if(isset($_POST['submit']) AND isset($_GET['add']))
    {
        $ext = pathinfo($_FILES['category_image']['name'], PATHINFO_EXTENSION);

        $category_image=rand(0,99999)."_category.".$ext;

        //Main Image
        $tpath1='images/'.$category_image;   

        if($ext!='png')  {
          $pic1=compress_image($_FILES["category_image"]["tmp_name"], $tpath1, 80);
        }
        else{
          $tmp = $_FILES['category_image']['tmp_name'];
          move_uploaded_file($tmp, $tpath1);
        }


        $data = array( 
            'category_name'  =>  cleanInput($_POST['category_name']),
            'category_image'  =>  $category_image
        );    

        $qry = Insert('tbl_category',$data);  

        $_SESSION['msg']="10";
        $_SESSION['class']='success';
        header( "Location:manage_category.php");
        exit;
    }

    if(isset($_GET['cat_id']))
    {
        $qry="SELECT * FROM tbl_category where cid='".$_GET['cat_id']."'";
        $result=mysqli_query($mysqli,$qry);
        $row=mysqli_fetch_assoc($result);
    }
    if(isset($_POST['submit']) and isset($_POST['cat_id']))
    {

        $data = array( 
            'category_name'  =>  cleanInput($_POST['category_name'])
        );

        if($_FILES['category_image']['name']!="")
        {
            if($row['category_image']!="")
            {
                unlink('images/'.$row['category_image']);
            }

            $ext = pathinfo($_FILES['category_image']['name'], PATHINFO_EXTENSION);

            $category_image=rand(0,99999)."_category.".$ext;

            //Main Image
            $tpath1='images/'.$category_image;   

            if($ext!='png')  {
              $pic1=compress_image($_FILES["category_image"]["tmp_name"], $tpath1, 80);
            }
            else{
              $tmp = $_FILES['category_image']['tmp_name'];
              move_uploaded_file($tmp, $tpath1);
            }

            $data = array_merge($data, array("category_image" => $category_image));
        }

        $category_edit=Update('tbl_category', $data, "WHERE cid = '".$_POST['cat_id']."'");

        $_SESSION['msg']="11";
        $_SESSION['class']='success'; 
        
        if(isset($_GET['redirect'])){
          header("Location:".$_GET['redirect']);
        }
        else{
          header( "Location:add_category.php?cat_id=".$_POST['cat_id']);
        }
        exit;
    }

?>
<div class="row">
  <div class="col-md-12">
    <?php
      if(isset($_GET['redirect'])){
          echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
        }
        else{
          echo '<a href="manage_category.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
        }
    ?>
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="card-body mrg_bottom"> 
        <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <input  type="hidden" name="cat_id" value="<?php echo $_GET['cat_id'];?>" />

          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label">Category Name :-
                
                </label>
                <div class="col-md-6">
                  <input type="text" name="category_name" id="category_name" value="<?php if(isset($_GET['cat_id'])){echo $row['category_name'];}?>" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Select Image :-
                  <p class="control-label-help">(Recommended resolution: 300x150,400x200,600x300)</p>
                </label>
                <div class="col-md-6">
                  <div class="fileupload_block">
                    <input type="file" name="category_image" value="fileupload" id="fileupload">
                      <div class="fileupload_img"><img type="image" src="<?=(isset($_GET['cat_id']) && $row['category_image']!='') ? 'images/'.$row['category_image'] : 'assets/images/landscape.jpg';?>" alt="image" style="width: 150px;height: 90px" /></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                  <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
        
<?php include("includes/footer.php");?>

<script type="text/javascript">
  $("input[name='category_image']").change(function() { 
      var file=$(this);

      if(file[0].files.length != 0){
          if(isImage($(this).val())){
            render_upload_image(this,$(this).next('.fileupload_img').find("img"));
          }
          else
          {
            $(this).val('');
            $('.notifyjs-corner').empty();
            $.notify(
            'Only jpg/jpeg, png, gif files are allowed!',
            { position:"top center",className: 'error'}
            );
          }
      }
  });
</script>     

