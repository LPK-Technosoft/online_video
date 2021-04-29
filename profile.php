<?php 

  $page_title="Admin Profile";

  include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

  if(isset($_SESSION['id']))
  { 
    $qry="SELECT * FROM tbl_admin WHERE id='".$_SESSION['id']."'";

    $result=mysqli_query($mysqli,$qry);
    $row=mysqli_fetch_assoc($result);
  }
  if(isset($_POST['submit']))
  {
    if($_FILES['image']['name']!="")
    {   
      if($row['image']!="")
      {
        unlink('images/'.$row['image']);
      }

      $image="profile.png";
      $pic1=$_FILES['image']['tmp_name'];
      $tpath1='images/'.$image;

      copy($pic1,$tpath1);

      $data = array( 
        'username'  =>  cleanInput($_POST['username']),
        'password'  =>  cleanInput($_POST['password']),
        'email'  =>  cleanInput($_POST['email']),
        'image'  =>  $image
      );

      $updated=Update('tbl_admin', $data, "WHERE id = '".$_SESSION['id']."'"); 

    }
    else
    {
      $data = array( 
        'username'  =>  cleanInput($_POST['username']),
        'password'  =>  cleanInput($_POST['password']),
        'email'  =>  cleanInput($_POST['email']) 
      );

      $updated=Update('tbl_admin', $data, "WHERE id = '".$_SESSION['id']."'"); 
    }

    $_SESSION['class']="success";
    $_SESSION['msg']="11"; 
    header( "Location:profile.php");
    exit;

  }


?>
 
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="card-body mrg_bottom">
          
        <form action="" name="editprofile" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label">Profile Image :-</label>
                <div class="col-md-6">
                  <div class="fileupload_block">
                    <input type="file" name="image" id="fileupload">
                      <?php if($row['image']!="") {?>
                        <div class="fileupload_img"><img type="image" src="images/<?php echo $row['image'];?>" alt="profile image"  style="width: 100px;height: 100px;" /></div>
                      <?php } else {?>
                        <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="profile image" /></div>
                      <?php }?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Username :-</label>
                <div class="col-md-6">
                  <input type="text" name="username" id="username" value="<?php echo $row['username'];?>" class="form-control" required autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Password :-</label>
                <div class="col-md-6">
                  <input type="password" name="password" id="password" value="<?php echo $row['password'];?>" class="form-control" required autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Email :-</label>
                <div class="col-md-6">
                  <input type="text" name="email" id="email" value="<?php echo $row['email'];?>" class="form-control" required autocomplete="off">
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
  $("input[name='image']").change(function() { 
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
