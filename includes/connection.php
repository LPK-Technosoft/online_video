<?php

error_reporting(0);
ob_start();
session_start();

header("Content-Type: text/html;charset=UTF-8");


if ($_SERVER['HTTP_HOST'] == "localhost" or $_SERVER['HTTP_HOST'] == "192.168.1.125") {
    //local  
    DEFINE('DB_USER', 'root');
    DEFINE('DB_PASSWORD', '');
    DEFINE('DB_HOST', 'localhost'); //host name depends on server
    DEFINE('DB_NAME', 'online_video');
} else {
    //local live 

    DEFINE('DB_USER', 'root');
    DEFINE('DB_PASSWORD', '');
    DEFINE('DB_HOST', 'localhost'); //host name depends on server
    DEFINE('DB_NAME', 'online_video');
}


$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

mysqli_query($mysqli, "SET NAMES 'utf8'");



//Settings
$setting_qry = "SELECT * FROM tbl_settings where id='1'";
$setting_result = mysqli_query($mysqli, $setting_qry);
$settings_details = mysqli_fetch_assoc($setting_result);

define("ONESIGNAL_APP_ID", $settings_details['onesignal_app_id']);
define("ONESIGNAL_REST_KEY", $settings_details['onesignal_rest_key']);

define("APP_NAME", $settings_details['app_name']);
define("APP_LOGO", $settings_details['app_logo']);
define("APP_FROM_EMAIL", $settings_details['email_from']);

define("API_LATEST_LIMIT", $settings_details['api_latest_limit']);
define("API_CITY_ORDER_BY", $settings_details['api_city_order_by']);
define("API_CITY_POST_ORDER_BY", $settings_details['api_city_post_order_by']);
define("API_LANG_ORDER_BY", $settings_details['api_lang_order_by']);
define("SERVER_KEY", 'AAAA4912N7w:APA91bFh51jg2H6HlP4UUO4EtdTqQysK7dSr9MfgQqKcBOoKn_oDWmoABeIq43BVWBoZIgILGpaHvEMUuTGi8KEiK5hulexlZwU4Hy6cbQZ_bf-cOWbpzYk_EC07X2PfxINJuyiaecVZ');


//Profile
if (isset($_SESSION['id'])) {
    $profile_qry = "SELECT * FROM tbl_admin where id='" . $_SESSION['id'] . "'";
    $profile_result = mysqli_query($mysqli, $profile_qry);
    $profile_details = mysqli_fetch_assoc($profile_result);

    define("PROFILE_IMG", $profile_details['image']);
}
?> 

