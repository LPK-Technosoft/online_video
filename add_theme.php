<?php 

    $page_title=(isset($_GET['theme_id'])) ? 'Edit Theme' : 'Add Theme';

    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");

    if(isset($_POST['submit']) and isset($_GET['add']))
    {

        $data = array(
          'theme_name'  =>  cleanInput($_POST['theme_name']), 
          'gradient_color1'  =>  cleanInput($_POST['gradient_color1']),
          'gradient_color2'  =>  cleanInput($_POST['gradient_color2']) 
        );		

        $qry = Insert('tbl_theme',$data);	

        $_SESSION['class']="success";
        $_SESSION['msg']="10"; 
        header( "Location:manage_theme.php");
        exit;
    }

    if(isset($_GET['theme_id']))
    {

    $qry="SELECT * FROM tbl_theme where id='".$_GET['theme_id']."'";
    $result=mysqli_query($mysqli,$qry);
    $row=mysqli_fetch_assoc($result);

    }
    if(isset($_POST['submit']) and isset($_POST['theme_id']))
    {

        $data = array( 
          'theme_name'  =>  cleanInput($_POST['theme_name']), 
          'gradient_color1'  =>  cleanInput($_POST['gradient_color1']),
          'gradient_color2'  =>  cleanInput($_POST['gradient_color2'])  
        );  	

        $updated=Update('tbl_theme', $data, "WHERE id = '".$_POST['theme_id']."'");

        $_SESSION['class']="success";
        $_SESSION['msg']="11"; 
        if(isset($_GET['redirect'])){
          header("Location:".$_GET['redirect']);
        }
        else{
          header( "Location:add_theme.php?theme_id=".$_POST['theme_id']);
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
          echo '<a href="manage_theme.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
          <form action="" name="addedit_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
           <input  type="hidden" name="theme_id" value="<?php echo $_GET['theme_id'];?>" />

           <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label">Theme Name :-</label>
                <div class="col-md-6">
                  <input type="text" name="theme_name" id="theme_name" value="<?php if(isset($_GET['theme_id'])){echo $row['theme_name'];}?>" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Gradient Color 1 :-</label>
                <div class="col-md-6">
                  <input type="text" name="gradient_color1" id="gradient_color1" value="<?php if(isset($_GET['theme_id'])){echo $row['gradient_color1'];}?>" class="form-control jscolor {hash:true,position:'top'}" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Gradient Color 2 :-</label>
                <div class="col-md-6">
                  <input type="text" name="gradient_color2" id="gradient_color2" value="<?php if(isset($_GET['theme_id'])){echo $row['gradient_color2'];}?>" class="form-control jscolor {hash:true,position:'top'}" required>
                </div>
              </div>
              <div class="col-md-12 gradientHolderDiv" style="margin-bottom: 10px;display: none;">
                <div class="col-md-3 col-md-offset-3 gradientHolder" style="height: 80px;width: 140px;border-radius: 6px;box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);margin-bottom: 10px;"></div>  
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

<style type="text/css">
  body{
    background: gradient(_color1,_color2)
  }
</style>      

<script type="text/javascript">
  $("input[name='gradient_color1']").on("change",function(e){

    $(".gradientHolderDiv").show();

    var _color2=$("input[name='gradient_color2']").val();

    var _color1=$(this).val();

    $(".gradientHolder").css({background:'linear-gradient(45deg,'+_color1+','+_color2+')'});

  });

  $("input[name='gradient_color2']").on("change",function(e){
    var _color1=$("input[name='gradient_color1']").val();

    var _color2=$(this).val();

    $(".gradientHolderDiv").show();

    $(".gradientHolder").css({background:'linear-gradient(45deg,'+_color1+','+_color2+')'});

  });

  var _color1=$("input[name='gradient_color1']").val();

  var _color2=$("input[name='gradient_color2']").val();

  if(_color1!='' && _color2!='')
  {
    $(".gradientHolderDiv").show();
    $(".gradientHolder").css({background:'linear-gradient(45deg,'+_color1+','+_color2+')'});  
  }
  

</script>