<?php
$page_title = (isset($_GET['lang_id'])) ? 'Edit Language' : 'Add Language';

include("includes/header.php");
require("includes/function.php");
require("language/language.php");

if (isset($_POST['submit']) and isset($_GET['add'])) {


    foreach ($_POST['language_name'] as $key => $value) {
        $data = array(
            'language_name' => $value
        );

        $qry = Insert('tbl_language', $data);
    }

    $_SESSION['class'] = "success";
    $_SESSION['msg'] = "10";
    header("Location:manage_language.php");
    exit;
}

if (isset($_GET['lang_id'])) {

    $qry = "SELECT * FROM tbl_language WHERE lid='" . $_GET['lang_id'] . "'";
    $result = mysqli_query($mysqli, $qry);
    $row = mysqli_fetch_assoc($result);
}
if (isset($_POST['submit']) AND isset($_POST['lang_id'])) {

    $data = array(
        'language_name' => $_POST['language_name'][0]
    );

    $update = Update('tbl_language', $data, "WHERE lid = '" . $_POST['lang_id'] . "'");

    $_SESSION['class'] = "success";
    $_SESSION['msg'] = "11";
    if (isset($_GET['redirect'])) {
        header("Location:" . $_GET['redirect']);
    } else {
        header("Location:add_language.php?lang_id=" . $_POST['lang_id']);
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
            echo '<a href="manage_color.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
                <form action="" name="addedit_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <input  type="hidden" name="lang_id" value="<?php echo $_GET['lang_id']; ?>" />
                    <div class="section">
                        <div class="section-body">
                            <div class="input-container">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Language Name :-</label>
                                    <div class="col-md-6">
                                        <input type="text" name="language_name[]" value="<?php
                                        if (isset($_GET['lang_id'])) {
                                            echo $row['language_name'];
                                        }
                                        ?>" class="form-control" required>
                                        <a href="" class="btn_remove" style="float: right;color: red;font-weight: 600;opacity: 0;">&times; Remove</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (!isset($_GET['lang_id'])) {
                                ?>
                                <div id="dynamicInput"></div>
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">                      
                                        <button type="button" class="btn btn-success btn-xs add_more">Add More Subject</button>
                                    </div>
                                </div>
                                <br/>
                                <?php
                            }
                            ?>
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

    $(".btn_remove:eq(0)").hide();

    $(".add_more").click(function (e) {

        var flag = 0;

        var flag2 = 0;

        var _html = $(".input-container").html();

        $.each($(".input-container").find("input"), function (index, value) {
            if ($(this).val() == '') {
                flag = flag + 1;
            }
        });

        $.each($("#dynamicInput").find("input"), function (index, value) {

            $(this).css("margin-bottom", "0px");
            $(this).next("a").css("margin-bottom", "15px");

            if ($(this).val() == '') {
                flag2 = flag2 + 1;
            }
        });

        if (flag == 0 && flag2 == 0) {

            $("#dynamicInput").append(_html);

            $(".btn_remove:not(:eq(0))").css("opacity", "1").show();

            $.each($("#dynamicInput").find("input"), function (index, value) {

                $(this).css("margin-bottom", "0px");
                $(this).next("a").css("margin-bottom", "15px");
            });

            $(".btn_remove").click(function (e) {
                e.preventDefault();
                $(this).parents(".form-group").remove();
            });
        } else {
            alert("Enter preview all field data!");
            return false;
        }
    });

    $(".btn_remove").click(function (e) {
        e.preventDefault();
        $(this).parents(".form-group").remove();
    });
</script>       
