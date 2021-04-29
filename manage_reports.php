<?php 
  
  $page_title="Manage Reports";

  include("includes/header.php");
  require("includes/function.php");
  require("language/language.php");
  
  function get_user_info($user_id)
  {
    global $mysqli;
     
    $user_qry="SELECT * FROM tbl_users WHERE id='".$user_id."'";
    $user_result=mysqli_query($mysqli,$user_qry);
    $user_row=mysqli_fetch_assoc($user_result);

    return $user_row;
  }

   function get_post_info($post_id,$type)
   { 
    global $mysqli;   

    if($type=='song')
    {
        $qry_data='SELECT * FROM tbl_mp3 WHERE id='.$post_id.'';     
        $data_row = mysqli_fetch_array(mysqli_query($mysqli,$qry_data));
        return $data_row['mp3_title'];
    }
    else
    {
        $qry_data='SELECT * FROM tbl_radio WHERE id='.$post_id.'';     
        $data_row = mysqli_fetch_array(mysqli_query($mysqli,$qry_data));    
        return $data_row['radio_name'];
    }
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
            <li role="presentation" class="active"><a href="#radio_report" aria-controls="radio_report" role="tab" data-toggle="tab">Radio Report</a></li>
            <li role="presentation"><a href="#song_report" aria-controls="song_report" role="tab" data-toggle="tab">Songs Report</a></li>
        </ul>
      
       <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="radio_report">
            <div class="section">
              <div class="section-body">
                <div class="col-md-12">
                  <table class="datatable table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Radio</th>
                        <th>Report</th>
                        <th>Date</th> 
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php
                        $sql="SELECT * FROM tbl_radio
                            LEFT JOIN tbl_reports ON tbl_radio.`id`=tbl_reports.`post_id`
                            WHERE tbl_reports.`type`='radio' ORDER BY tbl_reports.`id` DESC";

                        $res=mysqli_query($mysqli, $sql);
                        $i=1;
                        while($row=mysqli_fetch_assoc($res))
                        {?>
                        <tr>
                          <td><?php echo get_user_info($row['user_id'])['name'];?></td>
                          <td><?php echo $row['radio_name'];?></td>
                          <td><?=nl2br($row['report'])?></td>
                          <td nowrap=""><?=date('d-m-Y',$row['report_on'])?></td>
                          <td>
                           	<a href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-toggle="tooltip" data-tooltip="Delete" class="btn btn-danger btn_delete btn_delete"><i class="fa fa-trash"></i></a>
                          </td>

                        </tr>
                    <?php 
                        }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div role="tabpanel" class="tab-pane" id="song_report">
            <div class="section">
              <div class="section-body">
                <div class="col-md-12">
                  <table class="datatable table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Song</th>
                        <th>Report</th> 
                        <th>Date</th> 
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                   <?php 
                      $sql="SELECT * FROM tbl_mp3
                            LEFT JOIN tbl_reports ON tbl_mp3.`id`=tbl_reports.`post_id`
                            WHERE tbl_reports.`type`='song' ORDER BY tbl_reports.`id` DESC";

                      $res=mysqli_query($mysqli, $sql);
                      $i=1;
                      while($row=mysqli_fetch_assoc($res))
                      {
                    ?>
                        <tr>
                          <td><?php echo get_user_info($row['user_id'])['name'];?></td>
                          <td><?php echo $row['mp3_title'];?></td>
                          <td><?=$row['report']?></td>
                          <td nowrap=""><?=date('d-m-Y',$row['report_on'])?></td>
                          <td>
                            <a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn_delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                    <?php 
                        }
                    ?>
                    </tbody>
                  </table>
                </div>
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
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }

  $('a[data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'bottom',
    html: true
  });

 $(".btn_delete").click(function(e){
		e.preventDefault();
		var _ids=$(this).data("id");
		swal({
          title: "Are you sure to delete?",
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

        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
              type:'post',
              url:'processData.php',
              dataType:'json',
              data:{'id':_ids,'action':'removeReports'},
              success:function(res){
                  console.log(res);
                  if(res.status=='1'){
                    swal({
					  title: "Successfully", 
					  text: "Data has been deleted...", 
					  type: "success"
					},function() {
					  location.reload();
					});
                  }
                  else{
                  	swal("Something went to wrong !");
                  }
                }
            });
          }
          else{
            swal.close();
          }

        });

	});


</script>    
