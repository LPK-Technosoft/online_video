<?php
$page_title = "Edit Video";
include("includes/header.php");
require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

//Get City
$cat_qry = "SELECT * FROM tbl_city ORDER BY city_name";
$cat_result = mysqli_query($mysqli, $cat_qry);

$category_qry = "SELECT * FROM tbl_category ORDER BY category_name";
$category_result = mysqli_query($mysqli, $category_qry);

if (isset($_GET['video_id'])) {

    $qry = "SELECT * FROM tbl_video WHERE id='" . $_GET['video_id'] . "'";
    $result = mysqli_query($mysqli, $qry);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    if ($_POST['video_type'] == 'youtube') {
        $link = $_POST['video_url'];
        $video_id = explode("?v=", $link);
        $video_id = $video_id[1];
        $thumbnail = "http://img.youtube.com/vi/" . $video_id . "/maxresdefault.jpg";
        $ext = pathinfo($thumbnail, PATHINFO_EXTENSION);

        $video_image = rand(0, 99999) . '_' . date('dmYhis') . "_video." . $ext;

        //Main Image
        $tpath1 = 'images/video/' . $video_image;

        if ($ext != 'png') {
            $pic1 = compress_image($thumbnail, $tpath1, 80);
        } else {
            $tmp = $_FILES['video_thumbnail']['tmp_name'];
            move_uploaded_file($tmp, $tpath1);
        }
    } else {
        $ext = pathinfo($_FILES['video_thumbnail']['name'], PATHINFO_EXTENSION);

        $video_image = rand(0, 99999) . '_' . date('dmYhis') . "_video." . $ext;

        //Main Image
        $tpath1 = 'images/video/' . $video_image;

        if ($ext != 'png') {
            $pic1 = compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);
        } else {
            $tmp = $_FILES['video_thumbnail']['tmp_name'];
            move_uploaded_file($tmp, $tpath1);
        }
    }
    if ($_POST['video_type'] == "youtube") {
        
        $data = array(
            'cat_id' => cleanInput($_POST['cat_id']),
            'video_title' => cleanInput($_POST['video_title']),
            'video_type' => cleanInput($_POST['video_type']),
            'video_upload' => '',
            'video_url' => trim($_POST['video_url']),
            'video_description' => addslashes($_POST['video_description']),
            'video_thumbnail' => $video_image
        );
    } else {
        $data = array(
            'cat_id' => cleanInput($_POST['cat_id']),
            'video_title' => cleanInput($_POST['video_title']),
            'video_type' => cleanInput($_POST['video_type']),
            'video_upload' => cleanInput($_POST['video_file_name']),
            'video_url' => '',
            'video_description' => addslashes($_POST['video_description']),
            'video_thumbnail' => $video_image
        );
    }
    

    $qry = Update('tbl_video', $data, "WHERE id = '" . $_GET['video_id'] . "'");

    $_SESSION['class'] = "success";
    $_SESSION['msg'] = "11";

    if (isset($_GET['redirect'])) {
        header("Location:" . $_GET['redirect']);
    } else {
        header("Location:edit_video.php?video_id=" . $_POST['video_id']);
    }
    exit;
}
?>

<div class="row">
    <div class="col-md-12">
        <?php
        if (isset($_GET['redirect'])) {
            echo '<a href="' . $_GET['redirect'] . '" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
        } else {
            echo '<a href="manage_video.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
                <form action="" name="edit_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <input  type="hidden" name="radio_id" value="<?php echo $_GET['radio_id']; ?>" />
                    <div class="section">
                        <div class="section-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Category :-</label>
                                <div class="col-md-6">
                                    <select name="cat_id" id="cat_id" class="select2" required>
                                        <option value="">--Select Category--</option>
                                        <?php
                                        while ($category_row = mysqli_fetch_array($category_result)) {
                                            ?>                       
                                            <option value="<?php echo $category_row['cid']; ?>" <?php if ($category_row['cid'] == $row['cat_id']) { ?>selected<?php } ?>><?php echo $category_row['category_name']; ?></option>                           
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Video Title :-</label>
                                <div class="col-md-6">
                                    <input type="text" name="video_title" id="video_title" value="<?php echo $row['video_title']; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Video Type :-</label>
                                <div class="col-md-6">                       
                                    <select name="video_type" id="video_type" style="width:280px; height:25px;" class="select2" required>
                                        <option value="">--Select Type--</option>
                                        <?php
                                        if ($row['video_type'] == 'youtube') {
                                            ?>
                                            <option value="youtube" selected="">Youtube</option>
                                            <option value="local">From Local</option>
                                            <?php
                                        } elseif ($row['video_type'] == 'local') {
                                            ?>
                                            <option value="youtube">Youtube</option>
                                            <option value="local" selected="">From Local</option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="youtube">Youtube</option>
                                            <option value="local">From Local</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            if ($row['video_type'] == 'youtube') {
                                ?>
                                <div class="form-group" id="video_url_display" style="display:none;">
                                    <label class="col-md-3 control-label">Video URL :-</label>
                                    <div class="col-md-6">
                                        <input type="text" name="video_url" id="video_url" value="<?php echo $row['video_url']; ?>" class="form-control" required>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="form-group" id="video_url_display" style="display:none;">
                                    <label class="col-md-3 control-label">Video URL :-</label>
                                    <div class="col-md-6">
                                        <input type="text" name="video_url" id="video_url" value="<?php echo $row['video_url']; ?>" class="form-control" required>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ($row['video_type'] == 'local') {
                                ?>
                                <div id="video_local_display" class="form-group">
                                    <label class="col-md-3 control-label">Video Upload :-</label>
                                    <div class="col-md-6">

                                        <input type="hidden" name="video_file_name" id="video_file_name" value="" class="form-control">
                                        <input type="file" name="video_local" id="video_local" value="" class="form-control">
                                        <div><label class="control-label">Current URL :-</label><?php echo "uploads/" . $row['video_upload'] ?></div>

                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                        </div>

                                        <div class="msg"></div>
                                        <input type="button" id="btn" class="btn-success" value="Upload" />
                                    </div>
                                </div><br>
                                <div id="thumbnail" class="form-group" >
                                    <label class="col-md-3 control-label">Thumbnail Image:-
                                        <p class="control-label-help">(Recommended resolution: 300*400,400*500 or Rectangle Image)</p>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="fileupload_block">
                                            <input type="file" name="video_thumbnail" value="" id="fileupload">
                                            <div class="fileupload_img"><img type="image" src="<?= ($row['video_thumbnail'] != '') ? 'images/video/' . $row['video_thumbnail'] : 'assets/images/square.jpg' ?>" style="width: 120px;height: 120px" alt="Radio image" /></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div id="video_local_display" class="form-group" style="display:none;">
                                    <label class="col-md-3 control-label">Video Upload :-</label>
                                    <div class="col-md-6">

                                        <input type="hidden" name="video_file_name" id="video_file_name" value="" class="form-control">
                                        <input type="file" name="video_local" id="video_local" value="" class="form-control">

                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                        </div>

                                        <div class="msg"></div>
                                        <input type="button" id="btn" class="btn-success" value="Upload" />
                                    </div>
                                </div><br>
                                <div id="thumbnail" class="form-group" style="display:none;">
                                    <label class="col-md-3 control-label">Thumbnail Image:-
                                        <p class="control-label-help">(Recommended resolution: 300*400,400*500 or Rectangle Image)</p>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="fileupload_block">
                                            <input type="file" name="video_thumbnail" value="" id="fileupload">
                                            <div class="fileupload_img"><img type="image" src="" style="width: 120px;height: 120px" alt="Radio image" /></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Video Description :-</label>
                                <div class="col-md-6">                    
                                    <textarea name="video_description" id="video_description" class="form-control"><?php echo stripslashes($row['video_description']); ?></textarea>
                                    <script>CKEDITOR.replace('video_description');</script>
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

<?php include("includes/footer.php"); ?>       

<script>
    $(function () {
        $('#btn').click(function () {
            $('.myprogress').css('width', '0');
            $('.msg').text('');
            var video_local = $('#video_local').val();
            if (video_local == '') {
                alert('Please enter file name and select file');
                return;
            }
            var formData = new FormData();
            formData.append('video_local', $('#video_local')[0].files[0]);
            $('#btn').attr('disabled', 'disabled');
            $('.msg').text('Uploading in progress...');
            $.ajax({
                url: 'uploadscript.php',
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                // this part is progress bar
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.myprogress').text(percentComplete + '%');
                            $('.myprogress').css('width', percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function (data) {

                    $('#video_file_name').val(data);
                    $('.msg').text("File uploaded successfully!!");
                    $('#btn').removeAttr('disabled');
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#video_type").change(function () {

            var type = $("#video_type").val();

            if (type == "youtube" || type == "vimeo" || type == "dailymotion" || type == "server_url")
            {
                //  alert(type);
                $("#video_url_display").show();
                $("#video_local_display").hide();
                $("#thumbnail").hide();
            } else
            {
                $("#video_url_display").hide();
                $("#video_local_display").show();
                $("#thumbnail").show();

            }

        });
    });
</script>

<script type="text/javascript">
    $("input[name='video_thumbnail']").change(function () {
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