<?php

    $page_title="Add Mp3";

    include("includes/header.php");

    require("includes/function.php");
    require("language/language.php");

    $cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
    $cat_result=mysqli_query($mysqli,$cat_qry); 

    if(isset($_POST['submit']))
    {

      $mp3_type=trim($_POST['mp3_type']);

      if($mp3_type=='server_url'){
          $mp3_url=htmlentities(trim($_POST['mp3_url']));
      }
      else{
          $path = "uploads/"; //set your folder path

          $mp3_local=rand(0,99999)."_".str_replace(" ", "-", $_FILES['mp3_local']['name']);

          $tmp = $_FILES['mp3_local']['tmp_name'];

          if (move_uploaded_file($tmp, $path.$mp3_local)) 
          {
            $mp3_url=$mp3_local;
          } else {
            echo "Error in uploading mp3 file !!";
            exit;
          }
      }

      if($_FILES['mp3_thumbnail']['name']!="")
      {
          $ext = pathinfo($_FILES['mp3_thumbnail']['name'], PATHINFO_EXTENSION);

          $mp3_thumbnail=rand(0,99999)."_mp3_thumb.".$ext;

          //Main Image
          $tpath1='images/'.$mp3_thumbnail;   

          if($ext!='png')  {
            $pic1=compress_image($_FILES["mp3_thumbnail"]["tmp_name"], $tpath1, 80);
          }
          else{
            $tmp = $_FILES['mp3_thumbnail']['tmp_name'];
            move_uploaded_file($tmp, $tpath1);
          }

          //Thumb Image 
          $thumbpath='images/thumbs/'.$mp3_thumbnail;   
          $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200'); 
      }
      else{
          $mp3_thumbnail='';
      }


      $data = array( 
          'cat_id'  =>  trim($_POST['cat_id']),
          'mp3_title'  =>  htmlentities(trim($_POST['mp3_title'])),
          'mp3_type'  =>  $mp3_type,
          'mp3_url'  =>  $mp3_url,
          'mp3_thumbnail'  =>  $mp3_thumbnail,
          'mp3_duration'  =>  '-',
          'mp3_description'  =>  trim($_POST['mp3_description'])
      );    

      $qry = Insert('tbl_mp3',$data); 

      $_SESSION['msg']="10";
      $_SESSION['class']="success";
      header( "Location:manage_mp3.php");
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
          echo '<a href="manage_mp3.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
          <form action="" name="add_form" method="post" class="form form-horizontal" enctype="multipart/form-data">

            <div class="section">
              <div class="section-body">
               <div class="form-group">
                <label class="col-md-3 control-label">Title :-</label>
                <div class="col-md-6">
                  <input type="text" name="mp3_title" id="mp3_title" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Category :-</label>
                <div class="col-md-6">
                  <select name="cat_id" id="cat_id" class="select2" required>
                    <option value="">--Select Category--</option>
                    <?php
                    while($cat_row=mysqli_fetch_array($cat_result))
                    {
                     ?>                      
                     <option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>                          
                     <?php
                   }
                   ?>
                 </select>
               </div>
             </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Upload From :-</label>
              <div class="col-md-6">                       
                <select name="mp3_type" id="mp3_type" style="width:280px; height:25px;" class="select2" required>
                    <option value="server_url">From Server(URL)</option>
                    <option value="local">Browse From Device</option>
                </select>
              </div>
            </div>
            <div id="mp3_url_display" class="form-group">
              <label class="col-md-3 control-label">Song URL :-</label>
              <div class="col-md-6">
                <input type="text" name="mp3_url" id="mp3_url" value="" class="form-control">
              </div>
            </div>
            <div id="mp3_local_display" class="form-group" style="display:none;">
              <label class="col-md-3 control-label">Song Upload :-</label>
              <div class="col-md-6">
                <input type="file" name="mp3_local" id="mp3_local" value=""  accept=".mp3"  class="form-control">

                <div id="uploadPreview" style="display: none;background: rgba(0,0,0,0.5);text-align: center;margin-bottom: 15px;padding: 1em">
                  <audio id="audio" controls src=""></audio>  
                </div>
                
              </div>
              
            </div>
            <div id="thumbnail" class="form-group">
              <label class="col-md-3 control-label">Image:- 
                <p class="control-label-help">(Recommended resolution: 300x150,400x200,600x300)</p>
              </label>
              <div class="col-md-6">
                <div class="fileupload_block">
                  <input type="file" name="mp3_thumbnail" value="" id="fileupload" accept=".png, .jpg, .jpeg">
                  <div class="fileupload_img"><img type="image" src="assets/images/landscape.jpg" style="width: 150px;height: 90px" alt="image" /></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Song Description :-</label>
              <div class="col-md-6">
                <textarea name="mp3_description" id="mp3_description" class="form-control"></textarea>
                <script>
                  CKEDITOR.replace('mp3_description');
                </script>
              </div>
            </div><br>
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

<script src="assets/js/moment.min.js"></script>

<script type="text/javascript">

  $(document).ready(function(e) {
    $("#mp3_type").change(function(){
      var type=$("#mp3_type").val();
      if(type=="server_url")
      {
          $("#mp3_url_display").show();
          $("#thumbnail").show();
          $("#mp3_local_display").hide();
          $("#mp3_local").val('');
          $("#audio").attr('src','');
      }
      else
      {
          $("#mp3_url_display").hide();               
          $("#mp3_local_display").show();
          $("#thumbnail").show();
      }
    });
  });

  var objectUrl;
  
  $("#mp3_local").change(function(e){
      var file = e.currentTarget.files[0];
     
      $("#filesize").text(file.size);
      
      objectUrl = URL.createObjectURL(file);
      $("#audio").prop("src", objectUrl);
      $("#uploadPreview").show();
  });

  $("input[name='mp3_thumbnail']").change(function() { 
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
