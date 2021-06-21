<?php
$page_title = "Edit Audio";
include("includes/header.php");
require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

$category_qry = "SELECT * FROM tbl_category ORDER BY category_name";
$category_result = mysqli_query($mysqli, $category_qry);

if (isset($_GET['audio_id'])) {

    $qry = "SELECT * FROM tbl_audio WHERE id='" . $_GET['audio_id'] . "'";
    $result = mysqli_query($mysqli, $qry);
    $row = mysqli_fetch_assoc($result);
//    print_r($row);
}
if (isset($_POST['submit'])) {

//    if ($_POST['video_type'] == 'youtube') {
//        $link = $_POST['video_url'];
//        $video_id = explode("?v=", $link);
//        $video_id = $video_id[1];
//        $thumbnail = "http://img.youtube.com/vi/" . $video_id . "/maxresdefault.jpg";
//        $ext = pathinfo($thumbnail, PATHINFO_EXTENSION);
//
//        $video_image = rand(0, 99999) . '_' . date('dmYhis') . "_video." . $ext;
//
//        //Main Image
//        $tpath1 = 'images/video/' . $video_image;
//
//        if ($ext != 'png') {
//            $pic1 = compress_image($thumbnail, $tpath1, 80);
//        } else {
//            $tmp = $_FILES['video_thumbnail']['tmp_name'];
//            move_uploaded_file($tmp, $tpath1);
//        }
//    } else {
//        $ext = pathinfo($_FILES['video_thumbnail']['name'], PATHINFO_EXTENSION);
//
//        $video_image = rand(0, 99999) . '_' . date('dmYhis') . "_video." . $ext;
//
//        //Main Image
//        $tpath1 = 'images/video/' . $video_image;
//
//        if ($ext != 'png') {
//            $pic1 = compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);
//        } else {
//            $tmp = $_FILES['video_thumbnail']['tmp_name'];
//            move_uploaded_file($tmp, $tpath1);
//        }
//    }

    $data = array(
        'audio_title' => cleanInput($_POST['audio_title']),
        'audio_description' => addslashes($_POST['audio_description']),
    );

    $qry = Update('tbl_audio', $data, "WHERE id = '" . $_GET['audio_id'] . "'");

    $_SESSION['class'] = "success";
    $_SESSION['msg'] = "11";

    if (isset($_GET['redirect'])) {
        header("Location:" . $_GET['redirect']);
    } else {
        header("Location:edit_audio.php?audio_id=" . $_POST['audio_id']);
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
            echo '<a href="manage_audio.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
                    <input  type="hidden" name="audio_id" id="vid_id" value="<?php echo $_GET['audio_id']; ?>" />
                    <div class="section">
                        <div class="section-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Category :-</label>
                                <div class="col-md-6">
                                    <select name="cat_id" id="cat_id" class="select2" disabled="">
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
                                <label class="col-md-3 control-label">Audio Title :-</label>
                                <div class="col-md-6">
                                    <input type="text" name="audio_title" id="audio_title" value="<?php echo $row['audio_title']; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div id="audio_local_display" class="form-group">
                                <label class="col-md-3 control-label">Audio Upload :-</label>
                                <div class="col-md-6">

                                    <input type="hidden" name="audio_file_name" id="audio_file_name" value="" class="form-control">
                                    <input type="file" name="audio_local" id="audio_local" value="" class="form-control" disabled>

                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                    </div>

                                    <div class="msg"></div>
                                    <input type="button" id="btn" class="btn-success" value="Upload" />
                                </div>
                            </div><br>
                            <div id="thumbnail" class="form-group">
                                <label class="col-md-3 control-label">Thumbnail Image:-
                                    <p class="control-label-help">(Recommended resolution: 300*400,400*500 or Rectangle Image)</p>
                                </label>
                                <div class="col-md-6">
                                    <div class="fileupload_block">
                                        <input type="file" name="audio_thumbnail" value="" id="fileupload" disabled="">
                                        <div class="fileupload_img"><img type="image" src="<?= ($row['audio_thumbnail'] != '') ? 'images/audio/' . $row['audio_thumbnail'] : 'assets/images/square.jpg' ?>" style="width: 120px;height: 120px" alt="Radio image" /></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Audio Description :-</label>
                                <div class="col-md-6">                    
                                    <textarea name="audio_description" id="audio_description" class="form-control"><?php echo stripslashes($row['audio_description']); ?></textarea>
                                    <script>CKEDITOR.replace('audio_description');</script>
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

<!--<script>
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
            var id = document.getElementById('vid_id').value;
            formData.append('id', id);
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
                    //alert(data);
                    $('#video_file_name').val(data);
                    $('.msg').text("File uploaded successfully!!");
                    $('#btn').removeAttr('disabled');
                }
            });
        });
    });
</script>-->
<!--<script type="text/javascript">
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
</script>-->

<!--<script type="text/javascript">
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
</script>-->