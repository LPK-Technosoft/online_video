<?php 
  
    $page_title="Send Notification";

    include("includes/header.php");

    require("includes/function.php");
    require("language/language.php");

    if(isset($_POST['submit']))
    {

      if($_POST['external_link']!="")
      {
        $external_link = $_POST['external_link'];
      }
      else
      {
        $external_link = false;
      }

      $title=cleanInput($_POST['notification_title']);

      $content = array("en" => cleanInput($_POST['notification_msg']));

      $post_id=$_POST['post_id'];
      $type=$_POST['type'];
      $post_title=cleanInput($_POST['title']);

      if($_FILES['big_picture']['name']!="")
      {
          $big_picture=rand(0,99999)."_".$_FILES['big_picture']['name'];
          $tpath2='images/'.$big_picture;
          move_uploaded_file($_FILES["big_picture"]["tmp_name"], $tpath2);

          $file_path = getBaseUrl().'images/'.$big_picture;

          $fields=array(
                  'app_id' => ONESIGNAL_APP_ID,
                  'included_segments' => array('All'),                                            
                  'data' => array("foo" => "bar", "type"=>$type ,"post_id" => $post_id, "title"=> $post_title, "external_link"=>$external_link),
                  'headings'=> array("en" => $title),
                  'contents' => $content,
                  'big_picture' =>$file_path                    
                  );
      }
      else
      {
          $fields = array(
                  'app_id' => ONESIGNAL_APP_ID,
                  'included_segments' => array('All'),                                      
                  'data' => array("foo" => "bar","type"=>$type,"post_id"=>$post_id,"title"=>$post_title,"external_link"=>$external_link),
                  'headings'=> array("en" => $title),
                  'contents' => $content
                  );

      }

      $fields = json_encode($fields);
      print("\nJSON sent:\n");
      print($fields);

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
      'Authorization: Basic '.ONESIGNAL_REST_KEY));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

      $response = curl_exec($ch);
      curl_close($ch);

      $_SESSION['class']="success";
      $_SESSION['msg']="16";
      header( "Location:send_notification.php");
      exit; 

    }

    if(isset($_POST['notification_submit']))
    {

        $data = array(
          'onesignal_app_id' => trim($_POST['onesignal_app_id']),
          'onesignal_rest_key' => trim($_POST['onesignal_rest_key']),
        );

        $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

        $_SESSION['class']="success";
        $_SESSION['msg']="11";
        header( "Location:send_notification.php");
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
          <div class="card-body mrg_bottom" style="padding: 0px"> 

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#notification_settings" name="Notification Settings" aria-controls="notification_settings" role="tab" data-toggle="tab"><i class="fa fa-wrench"></i> Notification Settings</a></li>
                <li role="presentation"><a href="#send_notification" aria-controls="send_notification" name="Send notification" role="tab" data-toggle="tab"><i class="fa fa-send"></i> Send Notification</a></li>
            </ul>

            <div class="tab-content">

              <div role="tabpanel" class="tab-pane active" id="notification_settings">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12">
                      <form action="" name="settings_api" method="post" class="form form-horizontal" enctype="multipart/form-data" id="api_form">
                        <div class="section">
                          <div class="section-body">
                            <div class="form-group">
                              <label class="col-md-3 control-label">OneSignal App ID :-</label>
                              <div class="col-md-6">
                                <input type="text" name="onesignal_app_id" id="onesignal_app_id" value="<?php echo $settings_details['onesignal_app_id'];?>" class="form-control">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-3 control-label">OneSignal Rest Key :-</label>
                              <div class="col-md-6">
                                <input type="text" name="onesignal_rest_key" id="onesignal_rest_key" value="<?php echo $settings_details['onesignal_rest_key'];?>" class="form-control">
                              </div>
                            </div>              
                            <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                              <button type="submit" name="notification_submit" class="btn btn-primary">Save</button>
                            </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

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
                            <input type="hidden" value="0" name="type">
                            <input type="hidden" value="" name="title">
                            <div class="col-md-9 mrg_bottom link_block">
                              <div class="form-group">
                                <label class="col-md-4 control-label">Radio :-<br/>(Optional)
                                <p class="control-label-help">To directly open single radio when click on notification</p></label>
                                <div class="col-md-8">
                                  <select name="post_id" id="radio_id" class="select2" data-type="radio">
                                    <option value="0">--Select--</option>
                                  </select>
                                </div>
                              </div>  
                              <div class="or_link_item">
                              <h2>OR</h2>
                              </div>
                              <div class="form-group">
                                <label class="col-md-4 control-label">Song :-<br/>(Optional)
                                <p class="control-label-help">To directly open single Song when click on notification</p></label>
                                <div class="col-md-8">
                                  <select name="post_id" id="song_id" class="select2" data-type="song">
                                    <option value="0">--Select--</option>
                                  </select>
                                </div>
                              </div> 
                            <div class="or_link_item">
                            <h2>OR</h2>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label">External Link :-<br/>(Optional)</label>
                              <div class="col-md-8">
                                <input type="text" name="external_link" id="external_link" class="form-control" value="" placeholder="http://www.viaviweb.com">
                              </div>
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
        
<?php include("includes/footer.php");?>

<script type="text/javascript">

  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
    document.title = $(this).text()+" | <?=APP_NAME?>";
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }

  $(".select2").change(function(e){

    var _val=$(this).val();

    if(_val!=0){
      $(this).parents('.link_block').find("input").attr("disabled","disabled");
      $(this).parents('.link_block').find(".select2").attr("disabled","disabled");
      $(this).removeAttr("disabled");

      $("input[name='type']").val($(this).data("type"));
      $("input[name='title']").val($(this).children("option").filter(":selected").text());

    }
    else{
      $(this).parents('.link_block').find(".select2").removeAttr("disabled");
      $(this).parents('.link_block').find("input").removeAttr("disabled");
      $("input[name='type']").val('');
      $("input[name='title']").val('');
    }

});

  $(function(){
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
