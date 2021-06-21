<?php
$page_title = "Manage Audio";

include("includes/header.php");
require("includes/function.php");
require("language/language.php");

$tableName = "tbl_audio";
$limit = 12;

$stages = 3;
$page = 0;
if (isset($_GET['page'])) {
    $page = mysqli_real_escape_string($mysqli, $_GET['page']);
}

if ($page) {
    $start = ($page - 1) * $limit;
} else {
    $start = 0;
}

if (isset($_GET['status'])) {

    if ($_GET['status'] == 'enable') {
        $status = "tbl_audio.`status`='1'";
    } else if ($_GET['status'] == 'disable') {
        $status = "tbl_audio.`status`='0'";
    } else if ($_GET['status'] == 'featured') {
        $status = "tbl_audio.`featured_audio`='1'";
    } else if ($_GET['status'] == 'not_featured') {
        $status = "tbl_audio.`featured_audio`='0'";
    }

    $query = "SELECT COUNT(*) as num FROM $tableName WHERE $status";

    $audio_qry = "SELECT tbl_audio.status as audio_status,tbl_audio.*,tbl_category.* FROM tbl_audio
                  INNER JOIN tbl_category ON tbl_audio.`cat_id`= tbl_category.`cid`
                  WHERE $status 
                  ORDER BY tbl_audio.`id` DESC LIMIT $start, $limit";
    $targetpage = "manage_audio.php?status=" . $_GET['status'];

    if (isset($_GET['category'])) {

        $cat_id = $_GET['category'];

        $query = "SELECT COUNT(*) as num FROM $tableName WHERE $status AND `cat_id`='$cat_id'";

        $audio_qry = "SELECT tbl_audio.status as audio_status,tbl_audio.*,tbl_category.* FROM tbl_audio
                  LEFT JOIN tbl_category ON tbl_audio.`cat_id`= tbl_category.`cid`
                  WHERE $status AND tbl_audio.`cat_id`='$cat_id'
                  ORDER BY tbl_audio.`id` DESC LIMIT $start, $limit";
        $targetpage = "manage_audio.php?status=" . $_GET['status'] . '&category=$cat_id';
    }
    $total_pages = mysqli_fetch_array(mysqli_query($mysqli, $query));
    $total_pages = $total_pages['num'];
} else if (isset($_GET['category'])) {

    $cat_id = $_GET['category'];

    $query = "SELECT COUNT(*) as num FROM $tableName WHERE `cat_id`='$cat_id'";
    $targetpage = "manage_audio.php?category=$cat_id";

    $audio_qry = "SELECT tbl_audio.status as audio_status,tbl_audio.*,tbl_category.* FROM tbl_audio
                  LEFT JOIN tbl_category ON tbl_audio.`cat_id`= tbl_category.`cid`
                  WHERE tbl_audio.`cat_id`='$cat_id' ORDER BY tbl_audio.`id` DESC LIMIT $start, $limit";
    $total_pages = mysqli_fetch_array(mysqli_query($mysqli, $query));
    $total_pages = $total_pages['num'];
} else if (isset($_GET['keyword'])) {

    $keyword = addslashes(trim($_GET['keyword']));

    $query = "SELECT COUNT(*) as num FROM tbl_audio
                  LEFT JOIN tbl_category ON tbl_audio.`cat_id`= tbl_category.`cid`
                  WHERE (`audio_title` LIKE '%$keyword%' OR `audio_description` LIKE '%$keyword%') 
                  ORDER BY tbl_audio.`id` DESC";

    $targetpage = "manage_audio.php?keyword=" . $_GET['keyword'];

    $total_pages = mysqli_fetch_array(mysqli_query($mysqli, $query));
    $total_pages = $total_pages['num'];

    $audio_qry = "SELECT tbl_audio.status as audio_status,tbl_audio.*,tbl_category.* FROM tbl_audio
                  LEFT JOIN tbl_category ON tbl_audio.`cat_id`= tbl_category.`cid`
                  WHERE (`audio_title` LIKE '%$keyword%' OR `audio_description` LIKE '%$keyword%') 
                  ORDER BY tbl_audio.`id` DESC LIMIT $start, $limit";
} else {

    $query = "SELECT COUNT(*) as num FROM $tableName";

    $targetpage = "manage_audio.php";

    $total_pages = mysqli_fetch_array(mysqli_query($mysqli, $query));
    $total_pages = $total_pages['num'];

    $audio_qry = "SELECT tbl_audio.status as audio_status,tbl_audio.*,tbl_category.* FROM tbl_audio
                  LEFT JOIN tbl_category ON tbl_audio.`cat_id`= tbl_category.`cid` 
                  ORDER BY tbl_audio.`id` DESC LIMIT $start, $limit";
    // echo $video_qry;
}

$result = mysqli_query($mysqli, $audio_qry);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title"><?= $page_title ?></div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="search_list">
                        <div class="search_block">
                            <form method="get" id="searchForm" action="">
                                <input class="form-control input-sm" placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="keyword" value="<?php
                                if (isset($_GET['keyword'])) {
                                    echo $_GET['keyword'];
                                }
                                ?>" required="required">
                                <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
                            </form>  
                        </div>
                        <div class="add_btn_primary"> <a href="add_audio.php?redirect=<?= $redirectUrl ?>">Add Audio</a> </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <form id="filterForm" accept="" method="GET">
                    <div class="col-md-3 col-xs-12">
                        <div style="padding: 0px 0px 5px;">
                            <select name="category" class="form-control select2 filter">
                                <option value="">All Category</option>
                                <?php
                                $sql = "SELECT * FROM tbl_category ORDER BY category_name";
                                $res = mysqli_query($mysqli, $sql);
                                while ($row = mysqli_fetch_array($res)) {
                                    ?>                       
                                    <option value="<?php echo $row['cid']; ?>" <?php
                                    if (isset($_GET['category']) && $_GET['category'] == $row['cid']) {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $row['category_name']; ?></option>                           
                                            <?php
                                        }
                                        mysqli_free_result($row);
                                        ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div style="padding: 0px 0px 5px;">
                            <select name="status" class="form-control select2 filter">
                                <option value="">All</option>
                                <option value="enable" <?php
                                if (isset($_GET['status']) && $_GET['status'] == 'enable') {
                                    echo 'selected';
                                }
                                ?>>Enable</option>
                                <option value="disable" <?php
                                if (isset($_GET['status']) && $_GET['status'] == 'disable') {
                                    echo 'selected';
                                }
                                ?>>Disable</option>
                                <option value="featured" <?php
                                if (isset($_GET['status']) && $_GET['status'] == 'featured') {
                                    echo 'selected';
                                }
                                ?>>Featured</option>
                                <option value="not_featured" <?php
                                if (isset($_GET['status']) && $_GET['status'] == 'not_featured') {
                                    echo 'selected';
                                }
                                ?>>Not Featured</option>

                            </select>
                        </div>
                    </div>
                </form>
                <div class="col-md-3 col-xs-12 text-right" style="float: right;">
                    <div class="checkbox" style="width: 95px;margin-top: 5px;margin-left: 10px;right: 100px;position: absolute;">
                        <input type="checkbox" id="checkall_input">
                        <label for="checkall_input">
                            Select All
                        </label>
                    </div>
                    <div class="dropdown" style="float:right">
                        <button class="btn btn-primary dropdown-toggle btn_cust" type="button" data-toggle="dropdown">Action
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu" style="right:0;left:auto;">
                            <li><a href="" class="actions" data-action="enable">Enable</a></li>
                            <li><a href="" class="actions" data-action="disable">Disable</a></li>
                            <li><a href="" class="actions" data-action="delete">Delete !</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 mrg-top">
                    <div class="row">
                        <?php
                        $i = 0;
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <div class="col-lg-3 col-sm-6 col-xs-12">
                                <div class="block_wallpaper">
                                    <div class="wall_category_block">
                                        <h2><?php echo $row['category_name']; ?></h2> 
                                        <?php if ($row['featured_audio'] != "0") { ?>
                                            <a class="toggle_btn_a" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-action="deactive" data-column="featured_audio" data-toggle="tooltip" data-tooltip="Featured"><div style="color:green;"><i class="fa fa-check-circle"></i></div></a> 
                                        <?php } else { ?>
                                            <a class="toggle_btn_a" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-action="active" data-column="featured_audio" data-toggle="tooltip" data-tooltip="Set Featured"><i class="fa fa-circle"></i></a> 
                                        <?php } ?> 
                                        <div class="checkbox" style="float: right;">
                                            <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i; ?>" value="<?php echo $row['id']; ?>" class="post_ids">
                                            <label for="checkbox<?php echo $i; ?>">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="wall_image_title">
                                        <p style="font-size: 16px;"><?php echo $row['audio_title']; ?></p>

                                        <ul>
                                            <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['views']; ?> Views"><i class="fa fa-eye"></i></a></li>                      

                                            <li><a href="edit_audio.php?audio_id=<?php echo $row['id']; ?>&redirect=<?= $redirectUrl ?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                                            <li><a href="javascript:void(0)" class="btn_delete_a" data-id="<?php echo $row['id']; ?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a></li>

                                            <?php
                                            if ($row['audio_status'] != "0") {
                                                ?>
                                                <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li>

                                            <?php } else { ?>

                                                <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>

                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <span><img src="<?= ($row['audio_thumbnail'] != '') ? 'images/audio/' . $row['audio_thumbnail'] : 'assets/images/square.jpg' ?>" /></span>
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

    <?php include("includes/footer.php"); ?>       


    <script type="text/javascript">

        $(".filter").on("change", function (e) {
            $("#filterForm *").filter(":input").each(function () {
                if ($(this).val() == '')
                    $(this).prop("disabled", true);
            });
            $("#filterForm").submit();
        });

        $(".toggle_btn a, .toggle_btn_a").on("click", function (e) {
            e.preventDefault();

            var _for = $(this).data("action");
            var _id = $(this).data("id");
            var _column = $(this).data("column");
            var _table = 'tbl_audio';

            $.ajax({
                type: 'post',
                url: 'processData.php',
                dataType: 'json',
                data: {id: _id, for_action: _for, column: _column, table: _table, 'action': 'toggle_status', 'tbl_id': 'id'},
                success: function (res) {
                    // alert(res);
                    if (res.status == '1') {
                        location.reload();
                    }
                }
            });
        });

        // for delete action
        $(".btn_delete_a").click(function (e) {

            e.preventDefault();

            var _ids = $(this).data("id");
            var _table = 'tbl_audio';

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
                    function (isConfirm) {
                        if (isConfirm) {

                            $.ajax({
                                type: 'post',
                                url: 'processData.php',
                                dataType: 'json',
                                data: {'id': _ids, 'table': _table, 'for_action': 'delete', 'action': 'multi_action'},
                                success: function (res) {
                                    console.log(res);
                                    if (res.status == '1') {
                                        swal({
                                            title: "Successfully",
                                            text: "Audio is deleted.",
                                            type: "success"
                                        }, function () {
                                            location.reload();
                                        });
                                    } else if (res.status == '-2') {
                                        swal(res.message);
                                    }
                                }
                            });
                        } else {
                            swal.close();
                        }
                    });
        });
        // end delete action

        $(".actions").click(function (e) {
            e.preventDefault();

            var _ids = $.map($('.post_ids:checked'), function (c) {
                return c.value;
            });
            var _action = $(this).data("action");

            if (_ids != '') {
                swal({
                    title: "Action: " + $(this).text(),
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
                        function (isConfirm) {
                            if (isConfirm) {

                                var _table = 'tbl_audio';

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
                                    success: function (res) {
                                        console.log(res);
                                        $('.notifyjs-corner').empty();
                                        if (res.status == '1') {
                                            swal({
                                                title: "Successfully",
                                                text: "You have successfully done",
                                                type: "success"
                                            }, function () {
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

        $("#checkall_input").click(function () {

            totalItems = 0;

            $('input:checkbox').not(this).prop('checked', this.checked);
            $.each($("input[name='post_ids[]']:checked"), function () {
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

        $(".post_ids").click(function (e) {

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
