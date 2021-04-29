<?php 
  
  $page_title="Api Urls";

  include("includes/header.php");
  include("includes/function.php");

  $file_path = getBaseUrl().'api.php';
?>
<div class="row">
      <div class="col-sm-12 col-xs-12">
     	 	<div class="card">
		        <div class="card-header">
		          <?=$page_title?>
		        </div>
       			    <div class="card-body no-padding">
         		
         			 <pre>
                <code class="html">
                <br><b>API URL</b>&nbsp; <?php echo $file_path;?>    

                <br><b>Home</b>(Method: get_home_radio)
                <br><b>Latest Radio</b>(Method: get_latest_radio)
                <br><b>Featured Radio</b>(Method: get_featured_radio)
                <br><b>Language List</b>(Method: lang_list)
                <br><b>Radio list by Language</b>(Method: get_radio_by_lang_id) (Parameter: lang_id, quantity)
				        <br><b>City List</b>(Method: city_list)
                <br><b>Radio list by City</b>(Method: get_radio_by_city_id) (Parameter: city_id, quantity)
                <br><b>Single Radio</b>(Method: get_single_radio) (Parameter: radio_id)
				        <br><b>Most View Radio List</b>(Method: get_most_view)
                <br><b>Search Radio</b>(Method: get_search_radio) (Parameter: search_text)
				        <br><b>On Demand Category</b>(Method: on_demand_cat)
				        <br><b>Category wise On Demand</b>(Method: get_on_demand_cat_id) (Parameter: on_demand_cat_id)
        				<br><b>On Demand Single</b>(Method: get_on_demand_single) (Parameter: on_demand_single)
        				<br><b>Theme</b>(Method: get_themes)
        				<br><b>User Register</b>(Method: user_register) (Parameter: name, email, password, phone, auth_id, type(Normal, Google, Facebook))
                <br><b>User Login</b>(Method: user_login) (Parameter: email, password, auth_id, type[Normal, Google, Facebook])
                <br><b>User Profile</b>(Method: user_profile) (Parameter: id)
                <br><b>User Profile Update</b>(Method: user_profile_update) (Parameter: user_id, name, email, password, phone)
                <br><b>Forgot Password</b>(Method: forgot_pass) (Parameter: user_email)
                <br><b>Report</b>(Method: add_report) (Parameter: report_type, report_user_id, report_email, post_id, report_text)
                <br><b>User Suggest Song</b>(Method: add_user_suggest) (Parameter: title, description, image)
                <br><b>Favorite Post</b>(Method: favorite_post) (Parameter: post_id, user_id, type[song/radio])
                <br><b>Get Favorite Post</b>(Method: get_favorite_post) (Parameter: user_id, type[song/radio])
                <br><b>App Details</b>(Method: get_app_details)
                </code> 
             </pre>
       		
       				</div>
          	</div>
        </div>
</div>
    <br/>
    <div class="clearfix"></div>
        
<?php include("includes/footer.php");?>       
