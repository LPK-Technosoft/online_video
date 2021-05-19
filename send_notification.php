<?php
$page_title = "Send Notification";

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

class SendNotification {

    public function __construct() {
        
    }

    public function sendPushNotificationToGCMSever($tokenArray, $message, $title, $body) {

        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => $tokenArray,
            'data' => $message,
            'notification' => $message,
        );
        //echo json_encode($fields);
        $headers = array(
            'Authorization:key=' . SERVER_KEY,
            'Content-Type:application/json'
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

}

if (isset($_POST['submit'])) {

    $title = cleanInput($_POST['notification_title']);

    $content = cleanInput($_POST['notification_msg']);


    if ($_FILES['big_picture']['name'] != "") {
        $big_picture = rand(0, 99999) . "_" . $_FILES['big_picture']['name'];
        $tpath2 = 'images/' . $big_picture;
        move_uploaded_file($_FILES["big_picture"]["tmp_name"], $tpath2);

        $file_path = getBaseUrl() . 'images/' . $big_picture;

        $fields = array(
            'title' => $title,
            'message' => $content,
            'picture' => $file_path
        );
    } else {
        $fields = array(
            'title' => $title,
            'message' => $content,
        );
    }
    $notification_qry = Insert("tbl_notifications", $fields);

    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    $user_qry = "SELECT fcm_token FROM firebase_token_list";
    $res = mysqli_query($mysqli, $user_qry);
    while ($row = mysqli_fetch_array($res)) {
        $data[] = array($row['fcm_token']);
    }
    if (!empty($data)) {
        $serverObject = new SendNotification();

        $data = array_column($data, 0);
        $notification = ["body" => $_POST['notification_msg'],
            "title" => $_POST['notification_title'],
            "picture" => $file_path,
            "content_available" => true,
            "sound" => "default",
            "priority" => "high"];
        $jsonString = $serverObject->sendPushNotificationToGCMSever($data, $notification, "Online Radio App", $_POST['notification_title']);

        $jsonObject = json_decode($jsonString);
        $jsonObject = json_decode(json_encode($jsonObject), TRUE);
        $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
            "fcm_success" => $jsonObject['success'],
            "fcm_failure" => $jsonObject['failure'],
            "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
            "fcm_type" => "Online Radio App",
        );
        $msg = '<script>swal("Success!","Apps Notification Results Success: ' . $jsonObject['success'] . ' Failure: ' . $jsonObject['failure'] . '", "success")</script>';

        $qry = Insert("firebase_result", $fcmResult);
        $_SESSION['class'] = "success";
        $_SESSION['msg'] = "16";
        header("Location:send_notification.php");
        exit;
    }
}
?>

<?php
if (!function_exists("array_column")) {

    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if (!isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            } else {
                if (!isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if (!is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title"><?= $page_title ?></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="card-body mrg_bottom" style="padding: 0px"> 

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#send_notification" aria-controls="send_notification" name="Send notification" role="tab" data-toggle="tab"><i class="fa fa-send"></i> Send Notification</a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="send_notification">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="" method="post" class="form form-horizontal" enctype="multipart/form-data">
                                        <div class="section">
                                            <div class="section-body">

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Title :-</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="notification_title" id="notification_title" class="form-control" value="" placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Message :-</label>
                                                    <div class="col-md-6">
                                                        <textarea name="notification_msg" id="notification_msg" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Image :-<br/>(Optional)<p class="control-label-help">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>

                                                    <div class="col-md-6">
                                                        <input type="file" name="big_picture" value="" id="fileupload" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-9 col-md-offset-3">
                                                        <button type="submit" name="submit" class="btn btn-primary">Send</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>

    <script type="text/javascript">

        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
            document.title = $(this).text() + " | <?= APP_NAME ?>";
        });

        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
        }

        $(".select2").change(function (e) {

            var _val = $(this).val();

            if (_val != 0) {
                $(this).parents('.link_block').find("input").attr("disabled", "disabled");
                $(this).parents('.link_block').find(".select2").attr("disabled", "disabled");
                $(this).removeAttr("disabled");

                $("input[name='type']").val($(this).data("type"));
                $("input[name='title']").val($(this).children("option").filter(":selected").text());

            } else {
                $(this).parents('.link_block').find(".select2").removeAttr("disabled");
                $(this).parents('.link_block').find("input").removeAttr("disabled");
                $("input[name='type']").val('');
                $("input[name='title']").val('');
            }

        });

        $(function () {
            $('.select2').select2({
                ajax: {
                    url: 'getData.php',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var query = {
                            type: $(this).data("type"),
                            search: params.term,
                            page: params.page || 1
                        }
                        return query;
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                }
            });
        });
    </script>       
