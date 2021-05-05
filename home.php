<?php
$page_title = "Dashboard";
include("includes/header.php");
include("includes/function.php");

$qry_language = "SELECT COUNT(*) as num FROM tbl_language";
$total_language = mysqli_fetch_array(mysqli_query($mysqli, $qry_language));
$total_language = $total_language['num'];

$qry_city = "SELECT COUNT(*) as num FROM tbl_city";
$total_city = mysqli_fetch_array(mysqli_query($mysqli, $qry_city));
$total_city = $total_city['num'];

$qry_radio = "SELECT COUNT(*) as num FROM tbl_radio";
$total_radio = mysqli_fetch_array(mysqli_query($mysqli, $qry_radio));
$total_radio = $total_radio['num'];


$qry_category = "SELECT COUNT(*) as num FROM tbl_category";
$total_category = mysqli_fetch_array(mysqli_query($mysqli, $qry_category));
$total_category = $total_category['num'];

$qry_video = "SELECT COUNT(*) as num FROM tbl_video";
$total_video = mysqli_fetch_array(mysqli_query($mysqli, $qry_video));
$total_video = $total_video['num'];

$qry_demand = "SELECT COUNT(*) as num FROM tbl_mp3";
$total_demand = mysqli_fetch_array(mysqli_query($mysqli, $qry_demand));
$total_demand = $total_demand['num'];

$qry_reports = "SELECT COUNT(*) as num FROM tbl_reports";
$total_reports = mysqli_fetch_array(mysqli_query($mysqli, $qry_reports));
$total_reports = $total_reports['num'];


$countStr = '';
$no_data_status = false;
$count = $monthCount = 0;

for ($mon = 1; $mon <= 12; $mon++) {

    if (date('n') < $mon) {
        break;
    }

    if (isset($_GET['filterByYear'])) {

        $year = $_GET['filterByYear'];

        $month = date('M', mktime(0, 0, 0, $mon, 1, $year));

        $sql_user = "SELECT `id` FROM tbl_users WHERE DATE_FORMAT(FROM_UNIXTIME(`registered_on`), '%c') = '$mon' AND DATE_FORMAT(FROM_UNIXTIME(`registered_on`), '%Y') = '$year'";
    } else {

        $month = date('M', mktime(0, 0, 0, $mon, 1, date('Y')));

        $sql_user = "SELECT `id` FROM tbl_users WHERE DATE_FORMAT(FROM_UNIXTIME(`registered_on`), '%c') = '$mon'";
    }

    $count = mysqli_num_rows(mysqli_query($mysqli, $sql_user));

    $countStr .= "['" . $month . "', " . $count . "], ";


    if ($count != 0) {
        $monthCount++;
    }
}

if ($monthCount != 0) {
    $no_data_status = false;
} else {
    $no_data_status = true;
}

$countStr = rtrim($countStr, ", ");
?>       

<?php
$sql_smtp = "SELECT * FROM tbl_smtp_settings WHERE id='1'";
$res_smtp = mysqli_query($mysqli, $sql_smtp);
$row_smtp = mysqli_fetch_assoc($res_smtp);

$smtp_warning = true;

if (!empty($row_smtp)) {

    if ($row_smtp['smtp_type'] == 'server') {
        if ($row_smtp['smtp_host'] != '' AND $row_smtp['smtp_email'] != '') {
            $smtp_warning = false;
        } else {
            $smtp_warning = true;
        }
    } else if ($row_smtp['smtp_type'] == 'gmail') {
        if ($row_smtp['smtp_ghost'] != '' AND $row_smtp['smtp_gemail'] != '') {
            $smtp_warning = false;
        } else {
            $smtp_warning = true;
        }
    }
}

if ($smtp_warning) {
    ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <h4 id="oh-snap"><i class="fa fa-exclamation-triangle"></i> SMTP Setting is not config<a class="anchorjs-link" href="#oh-snap!-you-got-an-error!"><span class="anchorjs-icon"></span></a></h4>
                <p style="margin-bottom: 10px">Config the smtp setting otherwise <strong>forgot password</strong> OR <strong>email</strong> feature will not be work.</p> 
            </div>
        </div>
    </div>
<?php } ?>


<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_language.php" class="card card-banner card-green-light">
            <div class="card-body"> <i class="icon fa fa-language fa-4x"></i>
                <div class="content">
                    <div class="title">Language</div>
                    <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_language); ?></div>
                </div>
            </div>
        </a> 
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_city.php" class="card card-banner card-blue-light">
            <div class="card-body"> <i class="icon fa fa-sitemap fa-4x"></i>
                <div class="content">
                    <div class="title">City</div>
                    <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_city); ?></div>
                </div>
            </div>
        </a> 
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_radio.php" class="card card-banner card-pink-light">
            <div class="card-body"> <i class="icon fa fa-microphone fa-4x"></i>
                <div class="content">
                    <div class="title">Radio</div>
                    <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_radio); ?></div>
                </div>
            </div>
        </a> 
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_category.php" class="card card-banner card-orange-light">
            <div class="card-body"> <i class="icon fa fa-sitemap fa-4x"></i>
                <div class="content">
                    <div class="title">Categories</div>
                    <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_category); ?></div>
                </div>
            </div>
        </a> 
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_video.php" class="card card-banner card-pink-light">
            <div class="card-body"> <i class="icon fa fa-video-camera fa-4x"></i>
                <div class="content">
                    <div class="title">Video</div>
                    <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_video); ?></div>
                </div>
            </div>
        </a> 
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_mp3.php" class="card card-banner card-alicerose-light">
            <div class="card-body"> <i class="icon fa fa-music fa-4x"></i>
                <div class="content">
                    <div class="title">On Demand</div>
                    <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_demand); ?></div>
                </div>
            </div>
        </a> 
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_reports.php" class="card card-banner card-yellow-light">
            <div class="card-body"> <i class="icon fa fa-bug fa-4x"></i>
                <div class="content">
                    <div class="title">Reports</div>
                    <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_reports); ?></div>
                </div>
            </div>
        </a> 
    </div>

</div>

<div class="row">
    <div class="col-lg-12">
        <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px;">
            <div class="col-lg-10">
                <h3>Users Analysis</h3>
                <p>New registrations</p>
            </div>
            <div class="col-lg-2" style="padding-top: 20px">
                <form method="get" id="graphFilter">
                    <select class="form-control" name="filterByYear" style="box-shadow: none;height: auto;border-radius: 0px;font-size: 16px;">
                        <?php
                        $currentYear = date('Y');
                        $minYear = 2020;

                        for ($i = $currentYear; $i >= $minYear; $i--) {
                            ?>
                            <option value="<?= $i ?>" <?= (isset($_GET['filterByYear']) && $_GET['filterByYear'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </form>
            </div>
            <div class="col-lg-12">
                <?php
                if ($no_data_status) {
                    ?>
                    <h3 class="text-muted text-center" style="padding-bottom: 2em">No data found !</h3>
                    <?php
                } else {
                    ?>
                    <div id="registerChart">
                        <p style="text-align: center;"><i class="fa fa-spinner fa-spin" style="font-size:3em;color:#aaa;margin-bottom:50px" aria-hidden="true"></i></p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px">
            <h3>Most viewed series</h3>
            <p>Series with more views.</p>
            <table class="table table-hover">
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/series/91174_mumbai-police-narco-nacco-meme-759.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Narcos" style="color: inherit;">
                                Narcos                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 1 K</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/series/48629_d0bd7hlw0aagvyc-cropped.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Game Of Thrones" style="color: inherit;">
                                Game Of Thrones                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 650</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/series/47283_GoneGirl1.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Gone Girl" style="color: inherit;">
                                Gone Girl                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 635</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/series/42989_mirzapur-prime-1200.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Mirzapur" style="color: inherit;">
                                Mirzapur                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 599</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/series/78883_arrow.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Arrow" style="color: inherit;">
                                Arrow                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 588</p> 
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px">
            <h3>Most viewed movies</h3>
            <p>Movies with more views.</p>
            <table class="table table-hover">
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/46142_baaghi-3-movie-review-001.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Baaghi 3" style="color: inherit;">
                                Baaghi 3                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 1.8 K</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/37351_09B_AEG_DomPayoff_1Sht_REV-7c16828.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Avengers Endgame" style="color: inherit;">
                                Avengers Endgame                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 1.4 K</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/95676_subtitle_l.png" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Subtitle/Quality" style="color: inherit;">
                                Subtitle/Quality                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 723</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/25950_Maari 2.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Maari" style="color: inherit;">
                                Maari                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 521</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/30429_20gjhgj-660_112918050831_120318094858.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="2.0" style="color: inherit;">
                                2.0                   
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 268</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/54606_yjhd_5cf0a51c5ca94.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Yeh Jawaani Hai Deewani" style="color: inherit;">
                                Yeh Jawaani Hai Deewani                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 238</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/51702_c5b60f21775411e6b879b77c8bf4d3fc_1581945832220_l_medium.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Bhoot Returns" style="color: inherit;">
                                Bhoot Returns                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 207</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/21919_maxresdefault.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Sultan (2016 film)" style="color: inherit;">
                                Sultan (2016 film)                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 192</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/16961_noticias2010_-3672742.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="The Fate of the Furious 8" style="color: inherit;">
                                The Fate of the Furious 8                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 146</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/movies/51953_47821_Gone-Girl-2014.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Gone Girl" style="color: inherit;">
                                Gone Girl                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 145</p> 
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px">
            <h3>Most viewed channels</h3>
            <p>Channels with more views.</p>
            <table class="table table-hover">
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/4573_mygov_15008929499017401.png" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Doordarshan" style="color: inherit;">
                                Doordarshan                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 853</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/51046_9xM.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="DEMO M3U8 - Sony Ten 1 HD" style="color: inherit;">
                                DEMO M3U8 - Sony Ten 1 HD                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 701</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/68281_booba_cartoon.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Booba Cartoon for Kids" style="color: inherit;">
                                Booba Cartoon for Kids                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 698</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/51046_9xM.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="9XM" style="color: inherit;">
                                9XM                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 597</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/17953_star-sports-1.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="Star Sports" style="color: inherit;">
                                Star Sports                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 586</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/88773_mtv.png" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="MTV" style="color: inherit;">
                                MTV                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 548</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/54473_chuchu_tv.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="ChuChu TV" style="color: inherit;">
                                ChuChu TV                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 538</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/72882_6478_NDTV.png" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="NDTV India" style="color: inherit;">
                                NDTV India                   
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 537</p> 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float: left;padding-right: 20px">
                            <img src="images/63074_WB_Kids.jpg" style="width: 40px;height: 40px;border-radius: 50%"/>  
                        </div>
                        <div>
                            <a href="javascript:void(0)" title="WB Kids" style="color: inherit;">
                                WB Kids                    
                                <p style="font-weight: 500"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;">Views: 450</p> 
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>

<?php
if (!$no_data_status) {
    ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'line']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Users');

            data.addRows([<?= $countStr ?>]);

            var options = {
                curveType: 'function',
                fontSize: 15,
                hAxis: {
                    title: "Months of <?= (isset($_GET['filterByYear'])) ? $_GET['filterByYear'] : date('Y') ?>",
                    titleTextStyle: {
                        color: '#000',
                        bold: 'true',
                        italic: false
                    },
                },
                vAxis: {
                    title: "Nos of Users",
                    titleTextStyle: {
                        color: '#000',
                        bold: 'true',
                        italic: false,
                    },
                    gridlines: {count: 5},
                    format: '#',
                    viewWindowMode: "explicit", viewWindow: {min: 0},
                },
                height: 400,
                chartArea: {
                    left: 100, top: 20, width: '100%', height: 'auto'
                },
                legend: {
                    position: 'none'
                },
                lineWidth: 4,
                animation: {
                    startup: true,
                    duration: 1200,
                    easing: 'out',
                },
                pointSize: 5,
                pointShape: "circle",

            };
            var chart = new google.visualization.LineChart(document.getElementById('registerChart'));

            chart.draw(data, options);
        }

        $(document).ready(function () {
            $(window).resize(function () {
                drawChart();
            });
        });
    </script>

<?php } ?>

<script type="text/javascript">

    // filter of graph
    $("select[name='filterByYear']").on("change", function (e) {
        $("#graphFilter").submit();
    });

</script>         
