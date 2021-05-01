<?php
$page_title = "Add Radio";
include("includes/header.php");

require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

//Get City
$cat_qry = "SELECT * FROM tbl_city ORDER BY city_name";
$cat_result = mysqli_query($mysqli, $cat_qry);

$language_qry = "SELECT * FROM tbl_language ORDER BY language_name";
$language_result = mysqli_query($mysqli, $language_qry);

if (isset($_POST['submit'])) {

    $ext = pathinfo($_FILES['radio_image']['name'], PATHINFO_EXTENSION);

    $radio_image = rand(0, 99999) . '_' . date('dmYhis') . "_radio." . $ext;

    //Main Image
    $tpath1 = 'images/' . $radio_image;

    if ($ext != 'png') {
        $pic1 = compress_image($_FILES["radio_image"]["tmp_name"], $tpath1, 80);
    } else {
        $tmp = $_FILES['radio_image']['tmp_name'];
        move_uploaded_file($tmp, $tpath1);
    }


    $data = array(
        'lang_id' => cleanInput($_POST['lang_id']),
        'city_id' => cleanInput($_POST['city_id']),
        'radio_name' => cleanInput($_POST['radio_name']),
        'radio_frequency' => cleanInput($_POST['radio_frequency']),
        'radio_url' => trim($_POST['radio_url']),
        'radio_description' => addslashes($_POST['radio_description']),
        'radio_image' => $radio_image
    );

    $qry = Insert('tbl_radio', $data);

    $_SESSION['class'] = "success";
    $_SESSION['msg'] = "10";

    header("Location:manage_radio.php");
    exit;
}
?>

<div class="row">
    <div class="col-md-12">
<?php
if (isset($_GET['redirect'])) {
    echo '<a href="' . $_GET['redirect'] . '" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
} else {
    echo '<a href="manage_radio.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
}
?>
        <div class="card">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title"><?= $page_title ?></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="card-body mrg_bottom"> 
                <form action="" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <div class="section">
                        <div class="section-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Language :-</label>
                                <div class="col-md-6">
                                    <select name="lang_id" id="lang_id" class="select2" required>
                                        <option value="">--Select Language--</option>
<?php
while ($language_row = mysqli_fetch_array($language_result)) {
    ?>                       
                                            <option value="<?php echo $language_row['lid']; ?>"><?php echo $language_row['language_name']; ?></option>                           
    <?php
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">City :-</label>
                                <div class="col-md-6">
                                    <select name="city_id" id="city_id" class="select2" required>
                                        <option value="">--Select City--</option>
<?php
while ($cat_row = mysqli_fetch_array($cat_result)) {
    ?>          						 
                                            <option value="<?php echo $cat_row['cid']; ?>"><?php echo $cat_row['city_name']; ?></option>	
    <?php
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Radio Name :-</label>
                                <div class="col-md-6">
                                    <input type="text" name="radio_name" id="radio_name" value="" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Radio Frequency :-</label>
                                <div class="col-md-6">
                                    <input type="text" name="radio_frequency" id="radio_frequency" value="" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Radio URL :-</label>
                                <div class="col-md-6">
                                    <input type="text" name="radio_url" id="radio_url" value="" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Radio Description :-</label>
                                <div class="col-md-6">                    
                                    <textarea name="radio_description" id="radio_description" class="form-control"></textarea>
                                    <script>CKEDITOR.replace('radio_description');</script>
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Radio Image :-
                                    <p class="control-label-help">(Recommended resolution: 300x300,400x400 or Square Image)</p>
                                </label>
                                </label>
                                <div class="col-md-6">
                                    <div class="fileupload_block">
                                        <input type="file" name="radio_image" value="" id="fileupload">                            
                                        <div class="fileupload_img">
                                            <img type="image" src="assets/images/square.jpg" style="width: 120px;height: 120px" alt="radio image" />
                                        </div>
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

<?php include("includes/footer.php"); ?>

<script type="text/javascript">
    $("input[name='radio_image']").change(function () {
        var file = $(this);

        if (file[0].files.length != 0) {
            if (isImage($(this).val())) {
                render_upload_image(this, $(this).next('.fileupload_img').find("img"));
            } else
            {
                $(this).val('');
                $('.notifyjs-corner').empty();
                $.notify(
                        'Only jpg/jpeg, png, gif files are allowed!',
                        {position: "top center", className: 'error'}
                );
            }
        }
    });
</script>
