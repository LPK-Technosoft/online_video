<?php 

$page_title="Settings";

include("includes/header.php");
require("includes/function.php");
require("language/language.php");

$qry="SELECT * FROM tbl_settings where id='1'";
$result=mysqli_query($mysqli,$qry);
$settings_row=mysqli_fetch_assoc($result);

$_SESSION['class']="success";

if(isset($_POST['submit']))
{

  if($_FILES['app_logo']['name']!="")
  {        

    unlink('images/'.$settings_row['app_logo']);   

    $app_logo=$_FILES['app_logo']['name'];
    $pic1=$_FILES['app_logo']['tmp_name'];

    $tpath1='images/'.$app_logo;      
    copy($pic1,$tpath1);


    $data = array(      
      'email_from'  =>  '-', 
      'app_name'  =>  cleanInput($_POST['app_name']),
      'app_logo'  =>  $app_logo,
      'app_description'  => addslashes($_POST['app_description']),
      'app_version'  =>  cleanInput($_POST['app_version']),
      'app_author'  =>  cleanInput($_POST['app_author']),
      'app_contact'  =>  cleanInput($_POST['app_contact']),
      'app_email'  =>  cleanInput($_POST['app_email']),   
      'app_website'  =>  cleanInput($_POST['app_website']),
      'app_developed_by'  =>  cleanInput($_POST['app_developed_by']),
      'app_fb_url'  =>  cleanInput($_POST['app_fb_url']),
      'app_twitter_url'  =>  cleanInput($_POST['app_twitter_url'])
    );

  }
  else
  {

    $data = array(
      'email_from'  =>  '-', 
      'app_name'  =>  cleanInput($_POST['app_name']),
      'app_description'  => addslashes($_POST['app_description']),
      'app_version'  =>  cleanInput($_POST['app_version']),
      'app_author'  =>  cleanInput($_POST['app_author']),
      'app_contact'  =>  cleanInput($_POST['app_contact']),
      'app_email'  =>  cleanInput($_POST['app_email']),   
      'app_website'  =>  cleanInput($_POST['app_website']),
      'app_developed_by'  =>  cleanInput($_POST['app_developed_by']),
      'app_fb_url'  =>  cleanInput($_POST['app_fb_url']),
      'app_twitter_url'  =>  cleanInput($_POST['app_twitter_url'])
    );

  } 

  $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

  $_SESSION['msg']="11";
  header( "Location:settings.php");
  exit;
}
else if(isset($_POST['admob_submit']))
{

  $data = array(
    'publisher_id'  =>  cleanInput($_POST['publisher_id']),
    'interstital_ad'  => ($_POST['interstital_ad']) ? 'true' : 'false',
    'interstital_ad_type'  =>  cleanInput($_POST['interstital_ad_type']),
    'interstital_ad_id'  =>  cleanInput($_POST['interstital_ad_id']),
    'interstital_facebook_id'  =>  cleanInput($_POST['interstital_facebook_id']),
    'interstital_ad_click'  =>  cleanInput($_POST['interstital_ad_click']),
    'banner_ad'  => ($_POST['banner_ad']) ? 'true' : 'false',
    'banner_ad_type'  =>  cleanInput($_POST['banner_ad_type']),
    'banner_ad_id'  =>  cleanInput($_POST['banner_ad_id']),
    'banner_facebook_id'  =>  cleanInput($_POST['banner_facebook_id']),
    'native_ad'  => ($_POST['native_ad']) ? 'true' : 'false',
    'native_ad_type'  =>  cleanInput($_POST['native_ad_type']),
    'native_ad_id'  =>  cleanInput($_POST['native_ad_id']),
    'native_facebook_id'  =>  cleanInput($_POST['native_facebook_id']),
    'native_position'  =>  cleanInput($_POST['native_position']),
  );

  $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

  $_SESSION['msg']="11";
  header( "Location:settings.php");
  exit;
}
else if(isset($_POST['api_submit']))
{

  $data = array(
    'api_latest_limit'  =>  cleanInput($_POST['api_latest_limit']),
    'api_city_order_by'  =>  cleanInput($_POST['api_city_order_by']),
    'api_city_post_order_by'  =>  cleanInput($_POST['api_city_post_order_by']),
    'api_lang_order_by'  =>  cleanInput($_POST['api_lang_order_by'])
  );

  $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

  $_SESSION['msg']="11";
  header( "Location:settings.php");
  exit;

}

else if(isset($_POST['app_pri_poly']))
{

  $data = array(
    'app_privacy_policy'  =>  addslashes($_POST['app_privacy_policy'])
  );

  $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

  $_SESSION['msg']="11";
  header( "Location:settings.php");
  exit;
}

else if(isset($_POST['app_update_popup']))
{

  $data = array(
    'app_update_status'  =>  ($_POST['app_update_status']) ? 'true' : 'false',
    'app_new_version'  =>  trim($_POST['app_new_version']),
    'app_update_desc'  =>  addslashes(trim($_POST['app_update_desc'])),
    'app_redirect_url'  =>  trim($_POST['app_redirect_url']),
    'cancel_update_status'  =>  ($_POST['cancel_update_status']) ? 'true' : 'false',
  );

  $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

  $_SESSION['msg']="11";
  header("Location:settings.php");
  exit;
}


?>

<style type="text/css">
  .field_lable {
    margin-bottom: 10px;
    margin-top: 10px;
    color: #666;
    padding-left: 15px;
    font-size: 14px;
    line-height: 24px;
  }

  .banner_ads_block .toggle_btn,
  .interstital_ad_item .toggle_btn {
    margin-top: 6px;
  }
</style>

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
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#app_settings" aria-controls="app_settings" role="tab" data-toggle="tab">App Settings</a></li>
          <li role="presentation"><a href="#ads_settings" aria-controls="ads_settings" role="tab" data-toggle="tab">Ads Settings</a></li>
          <li role="presentation"><a href="#api_settings" aria-controls="api_settings" role="tab" data-toggle="tab">API Settings</a></li>
          <li role="presentation"><a href="#api_privacy_policy" aria-controls="api_privacy_policy" role="tab" data-toggle="tab">App Privacy Policy</a></li>
          <li role="presentation"><a href="#app_update_popup" aria-controls="app_update_popup" role="tab" data-toggle="tab">App Update Popup</a></li>
        </ul>

        <div class="rows">
          <div class="col-md-12">
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="app_settings">   
                  <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <div class="section">
                      <div class="section-body">
                        <div class="form-group">
                          <label class="col-md-3 control-label">App Name :-</label>
                          <div class="col-md-6">
                            <input type="text" name="app_name" id="app_name" value="<?php echo $settings_row['app_name'];?>" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">App Logo :-</label>
                          <div class="col-md-6">
                            <div class="fileupload_block">
                              <input type="file" name="app_logo" id="fileupload">

                              <?php if($settings_row['app_logo']!="") {?>
                               <div class="fileupload_img"><img type="image" src="images/<?php echo $settings_row['app_logo'];?>" alt="image" style="width: 100px;height: 100px" /></div>
                             <?php } else {?>
                               <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" style="width: 100px;height: 100px" alt="image" /></div>
                             <?php }?>

                           </div>
                         </div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-3 control-label">App Description :-</label>
                        <div class="col-md-6">

                          <textarea name="app_description" id="app_description" class="form-control"><?php echo $settings_row['app_description'];?></textarea>

                          <script>CKEDITOR.replace( 'app_description' );</script>
                        </div>
                        </div>
                      <div class="form-group">&nbsp;</div>                 
                      <div class="form-group">
                        <label class="col-md-3 control-label">Facebook URL :-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_fb_url" id="app_fb_url" value="<?php echo $settings_row['app_fb_url'];?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">Twitter URL :-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_twitter_url" id="app_twitter_url" value="<?php echo $settings_row['app_twitter_url'];?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">App Version :-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_version" id="app_version" value="<?php echo $settings_row['app_version'];?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">Author :-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_author" id="app_author" value="<?php echo $settings_row['app_author'];?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">Contact :-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_contact" id="app_contact" value="<?php echo $settings_row['app_contact'];?>" class="form-control">
                        </div>
                      </div>     
                      <div class="form-group">
                        <label class="col-md-3 control-label">Email :-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_email" id="app_email" value="<?php echo $settings_row['app_email'];?>" class="form-control">
                        </div>
                      </div>                 
                      <div class="form-group">
                        <label class="col-md-3 control-label">Website :-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_website" id="app_website" value="<?php echo $settings_row['app_website'];?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">Developed By :-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_developed_by" id="app_developed_by" value="<?php echo $settings_row['app_developed_by'];?>" class="form-control">
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

                <!-- for ads settings -->
                <div role="tabpanel" class="tab-pane" id="ads_settings">
                  <form action="" name="ads_settings" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <div class="section">
                      <div class="section-body">
                        <div class="form-group">
                          <label class="col-md-2 control-label">Publisher ID <a href="#target-content5"></a>:-</label>
                          <div class="col-md-10">
                            <input type="text" name="publisher_id" id="publisher_id" value="<?php echo $settings_row['publisher_id']; ?>" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-10">
                            <h5 style="color: #F00;font-weight: 500">(Note: Publisher ID is not required for facebook ads)</h5>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="col-md-4">
                                <div class="banner_ads_block">
                                  <div class="banner_ad_item">
                                    <label class="control-label">Banner Ads:-</label>
                                    <div class="row toggle_btn">
                                      <input type="checkbox" id="checked1" name="banner_ad" value="true" class="cbx hidden" <?php if ($settings_row['banner_ad'] == 'true') { ?>checked <?php } ?> />
                                      <label for="checked1" class="lbl"></label>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group" id="#admob_banner_id">
                                      <p class="field_lable">Banner Ad Type :-</p>
                                      <div class="col-md-12">
                                        <select name="banner_ad_type" id="banner_ad_type" class="select2">
                                          <option value="admob" <?php if ($settings_row['banner_ad_type'] == 'admob') { ?>selected<?php } ?>>Admob</option>
                                          <option value="facebook" <?php if ($settings_row['banner_ad_type'] == 'facebook') { ?>selected<?php } ?>>Facebook</option>
                                        </select>
                                      </div>

                                      <p class="field_lable">Banner Ad ID :-</p>
                                      <div class="col-md-12 banner_ad_id" style="display: none">
                                        <input type="text" name="banner_ad_id" id="banner_ad_id" value="<?php echo $settings_row['banner_ad_id']; ?>" class="form-control">
                                      </div>
                                      <div class="col-md-12 banner_facebook_id" style="display: none">
                                        <input type="text" name="banner_facebook_id" id="banner_facebook_id" value="<?php echo $settings_row['banner_facebook_id']; ?>" class="form-control">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="interstital_ads_block">
                                  <div class="interstital_ad_item">
                                    <label class="control-label">Interstitial Ads:-</label>
                                    <div class="row toggle_btn">
                                      <input type="checkbox" id="checked2" name="interstital_ad" value="true" class="cbx hidden" <?php if ($settings_row['interstital_ad'] == 'true') { ?>checked <?php } ?> />
                                      <label for="checked2" class="lbl"></label>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group" id="interstital_ad_id">

                                      <p class="field_lable">Interstitial Ad Type :-</p>
                                      <div class="col-md-12">
                                        <select name="interstital_ad_type" id="interstital_ad_type" class="select2">
                                          <option value="admob" <?php if ($settings_row['interstital_ad_type'] == 'admob') { ?>selected<?php } ?>>Admob</option>
                                          <option value="facebook" <?php if ($settings_row['interstital_ad_type'] == 'facebook') { ?>selected<?php } ?>>Facebook</option>

                                        </select>
                                      </div>

                                      <p class="field_lable">Interstitial Ad ID :-</p>

                                      <div class="col-md-12 interstital_ad_id" style="display: none">
                                        <input type="text" name="interstital_ad_id" id="interstital_ad_id" value="<?php echo $settings_row['interstital_ad_id']; ?>" class="form-control">
                                      </div>

                                      <div class="col-md-12 interstital_facebook_id" style="display: none">
                                        <input type="text" name="interstital_facebook_id" id="interstital_facebook_id" value="<?php echo $settings_row['interstital_facebook_id']; ?>" class="form-control">
                                      </div>
                                      <p class="field_lable">Interstitial Ad Clicks :-</p>
                                      <div class="col-md-12">
                                        <input type="text" name="interstital_ad_click" id="interstital_ad_click" value="<?php echo $settings_row['interstital_ad_click']; ?>" class="form-control ads_click">
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="banner_ads_block">
                                  <div class="banner_ad_item">
                                    <label class="control-label">Native Ads:-</label>
                                    <div class="row toggle_btn">
                                      <input type="checkbox" id="checked4" name="native_ad" value="true" class="cbx hidden" <?php if ($settings_row['native_ad'] == 'true') { ?>checked <?php } ?> />
                                      <label for="checked4" class="lbl"></label>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group" id="#admob_banner_id">
                                      <p class="field_lable">Native Ad Type :-</p>
                                      <div class="col-md-12">
                                        <select name="native_ad_type" id="native_ad_type" class="select2">
                                          <option value="admob" <?php if ($settings_row['native_ad_type'] == 'admob') { ?>selected<?php } ?>>Admob</option>
                                          <option value="facebook" <?php if ($settings_row['native_ad_type'] == 'facebook') { ?>selected<?php } ?>>Facebook</option>
                                        </select>
                                      </div>

                                      <p class="field_lable">Native Ad ID :-</p>

                                      <div class="col-md-12 native_ad_id" style="display: none">
                                        <input type="text" name="native_ad_id" id="native_ad_id" value="<?php echo $settings_row['native_ad_id']; ?>" class="form-control">
                                      </div>
                                      <div class="col-md-12 native_facebook_id" style="display: none">
                                        <input type="text" name="native_facebook_id" id="native_facebook_id" value="<?php echo $settings_row['native_facebook_id']; ?>" class="form-control">
                                      </div>
                                      <p class="field_lable">Position of Ads:- (MUST USE ODD NUMBER)</p>
                                      <div class="col-md-12">
                                        <input type="text" name="native_position" id="native_position" value="<?php echo $settings_row['native_position']; ?>" class="form-control ads_click">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-9">
                            <button type="submit" name="admob_submit" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- end ads settings -->       

                <div role="tabpanel" class="tab-pane" id="api_settings">   
                  <form action="" name="settings_api" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <div class="section">
                      <div class="section-body">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Latest Limit:-</label>
                          <div class="col-md-6">

                            <input type="number" name="api_latest_limit" id="api_latest_limit" value="<?php echo $settings_row['api_latest_limit'];?>" class="form-control"> 
                          </div>

                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">City List Order By:-</label>
                          <div class="col-md-6">


                            <select name="api_city_order_by" id="api_city_order_by" class="select2">
                              <option value="cid" <?php if($settings_row['api_city_order_by']=='cid'){?>selected<?php }?>>ID</option>
                              <option value="city_name" <?php if($settings_row['api_city_order_by']=='city_name'){?>selected<?php }?>>Name</option>

                            </select>

                          </div>

                        </div>                  
                        <div class="form-group">
                          <label class="col-md-3 control-label">Language Order:-</label>
                          <div class="col-md-6">


                            <select name="api_lang_order_by" id="api_lang_order_by" class="select2">
                              <option value="lid" <?php if($settings_row['api_lang_order_by']=='lid'){?>selected<?php }?>>ID</option>
                              <option value="language_name" <?php if($settings_row['api_lang_order_by']=='language_name'){?>selected<?php }?>>Name</option>

                            </select>

                          </div>

                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Radio Order:-</label>
                          <div class="col-md-6">


                            <select name="api_city_post_order_by" id="api_city_post_order_by" class="select2">
                              <option value="ASC" <?php if($settings_row['api_city_post_order_by']=='ASC'){?>selected<?php }?>>ASC</option>
                              <option value="DESC" <?php if($settings_row['api_city_post_order_by']=='DESC'){?>selected<?php }?>>DESC</option>

                            </select>

                          </div>

                        </div>  

                        <div class="form-group">
                          <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="api_submit" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div> 

                <div role="tabpanel" class="tab-pane" id="api_privacy_policy">   
                  <form action="" name="api_privacy_policy" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <div class="section">
                      <div class="section-body">
                        <?php 
                          if(file_exists('privacy_policy.php'))
                          {
                        ?>
                          <div class="form-group">
                            <label class="col-md-3 control-label">App Privacy Policy URL :-</label>
                            <div class="col-md-9">
                              <input type="text" readonly class="form-control" value="<?=getBaseUrl().'privacy_policy.php'?>">
                            </div>
                          </div>
                        <?php } ?>
                        <div class="form-group">
                          <label class="col-md-3 control-label">App Privacy Policy :-</label>
                          <div class="col-md-9">
                            <textarea name="app_privacy_policy" id="privacy_policy" class="form-control"><?php echo stripslashes($settings_row['app_privacy_policy']);?></textarea>
                            <script>CKEDITOR.replace( 'privacy_policy' );</script>
                          </div>
                        </div>
                        <br/>
                        <div class="form-group">
                          <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="app_pri_poly" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div> 

                <!-- app update popup -->
                <div role="tabpanel" class="tab-pane" id="app_update_popup">   
                  <form action="" name="app_update_popup" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    
                    <div class="section">
                      <div class="section-body">
                        <div class="form-group">
                          <label class="col-md-3 control-label">App Update Popup Show/Hide:-
                            <p class="control-label-help" style="color:#F00">You can show/hide update popup from this option</p>
                          </label>
                          <div class="col-md-6">
                            <div class="row" style="margin-top: 15px">
                                <input type="checkbox" id="chk_update" name="app_update_status" value="true" class="cbx hidden" <?php if($settings_row['app_update_status']=='true'){ echo 'checked'; }?>/>
                                <label for="chk_update" class="lbl" style="left:13px;"></label>
                            </div>
                          </div>                   
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">New App Version Code :-
                            <a href="assets/images/android_version_code.png" target="_blank"><p class="control-label-help" style="color:#F00">How to get version code</p></a>
                          </label>
                          <div class="col-md-6">
                            <input type="number" min="1" name="app_new_version" id="app_new_version" required="" value="<?php echo $settings_row['app_new_version'];?>" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Description :-</label>
                          <div class="col-md-6">
                            <textarea name="app_update_desc" class="form-control"><?php echo $settings_row['app_update_desc'];?></textarea>
                          </div>
                        </div> 
                        <div class="form-group">
                          <label class="col-md-3 control-label">App Link :-
                            <p class="control-label-help">You will be redirect on this link after click on update</p>
                          </label>
                          <div class="col-md-6">
                            <input type="text" name="app_redirect_url" id="app_redirect_url" required="" value="<?php echo $settings_row['app_redirect_url'];?>" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Cancel Option :-
                            <p class="control-label-help" style="color:#F00">Cancel button option will show in app update popup</p>
                          </label>
                          <div class="col-md-6">
                            <div class="row" style="margin-top: 15px">
                                <input type="checkbox" id="chk_cancel_update" name="cancel_update_status" value="true" class="cbx hidden" <?php if($settings_row['cancel_update_status']=='true'){ echo 'checked'; }?>/>
                                <label for="chk_cancel_update" class="lbl" style="left:13px;"></label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="app_update_popup" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- end app update popup -->

              </div> 
          </div>
        </div>
        <div class="clearfix"></div>
    </div>
  </div>
</div>
</div>


<?php include("includes/footer.php");?>

<script type="text/javascript">
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });

  var activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }

  if ($("select[name='banner_ad_type']").val() === 'facebook') {
    $(".banner_ad_id").hide();
    $(".banner_facebook_id").show();
  } else {
    $(".banner_facebook_id").hide();
    $(".banner_ad_id").show();
  }

  $("select[name='banner_ad_type']").change(function(e) {
    if ($(this).val() === 'facebook') {
      $(".banner_ad_id").hide();
      $(".banner_facebook_id").show();
    } else {
      $(".banner_facebook_id").hide();
      $(".banner_ad_id").show();
    }
  });


  if ($("select[name='interstital_ad_type']").val() === 'facebook') {
    $(".interstital_ad_id").hide();
    $(".interstital_facebook_id").show();
  } else {
    $(".interstital_facebook_id").hide();
    $(".interstital_ad_id").show();
  }

  $("select[name='interstital_ad_type']").change(function(e) {

    if ($(this).val() === 'facebook') {
      $(".interstital_ad_id").hide();
      $(".interstital_facebook_id").show();
    } else {
      $(".interstital_facebook_id").hide();
      $(".interstital_ad_id").show();
    }
  });


  if ($("select[name='native_ad_type']").val() === 'facebook') {
    $(".native_ad_id").hide();
    $(".native_facebook_id").show();
  } else {
    $(".native_facebook_id").hide();
    $(".native_ad_id").show();
  }

  $("select[name='native_ad_type']").change(function(e) {

    if ($(this).val() === 'facebook') {
      $(".native_ad_id").hide();
      $(".native_facebook_id").show();
    } else {
      $(".native_facebook_id").hide();
      $(".native_ad_id").show();
    }
  });

  $("input[name='app_logo']").change(function() { 
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
            'Only jpg/jpeg, png, gif and svg files are allowed!',
            { position:"top center",className: 'error'}
            );
          }
      }
  });


</script>