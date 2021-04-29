<?php 
	require("includes/connection.php");
	require("includes/function.php");
	require("language/language.php");

	$response=array();

	// get total comments
	function total_comments($news_id)
	{
		global $mysqli;

		$query="SELECT COUNT(*) AS total_comments FROM tbl_comments WHERE `news_id`='$news_id'";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
		$row=mysqli_fetch_assoc($sql);
		return stripslashes($row['total_comments']);
	}


	$_SESSION['class']="success";


	switch ($_POST['action']) {
		case 'toggle_status':
			$id=$_POST['id'];
			$for_action=$_POST['for_action'];
			$column=$_POST['column'];
			$tbl_id=$_POST['tbl_id'];
			$table_nm=$_POST['table'];

			if($for_action=='active'){
				$data = array($column  =>  '1');
			    $edit_status=Update($table_nm, $data, "WHERE $tbl_id = '$id'");
			    $_SESSION['msg']="13";
			}else{
				$data = array($column  =>  '0');
			    $edit_status=Update($table_nm, $data, "WHERE $tbl_id = '$id'");
			    $_SESSION['msg']="14";
			}
			
	      	$response['status']=1;
	      	$response['action']=$for_action;
	      	echo json_encode($response);
			break;

		case 'multi_action':

			$action=$_POST['for_action'];
			$ids=implode(",", $_POST['id']);
			$table=$_POST['table'];

			if($ids==''){
				$ids=$_POST['id'];
			}

			$tbl_id='id';
			$column='status';
			if(isset($_POST['tbl_id'])){
				$tbl_id=$_POST['tbl_id'];
				$column=$_POST['column'];
			}

			if($action=='enable'){

				$sql="UPDATE $table SET $column='1' WHERE $tbl_id IN ($ids)";
				mysqli_query($mysqli, $sql);
				$_SESSION['msg']="13";				
			}
			else if($action=='disable'){
				$sql="UPDATE $table SET $column='0' WHERE $tbl_id IN ($ids)";
				if(mysqli_query($mysqli, $sql)){
					$_SESSION['msg']="14";
				}
			}
			else if($action=='delete'){

				if($table=='tbl_language'){

					$sql="SELECT * FROM tbl_radio WHERE `lang_id` IN ($ids)";
					$res=mysqli_query($mysqli, $sql);
					while ($row=mysqli_fetch_assoc($res)){
						if($row['radio_image']!="")
						{
							unlink('images/'.$row['radio_image']);
						}

						$id=$row['id'];
						$deleteSql="DELETE FROM tbl_favorite WHERE `post_id`='$id' AND `type`='radio'";
						mysqli_query($mysqli, $deleteSql);

						$deleteSql="DELETE FROM tbl_reports WHERE `post_id`='$id' AND `type`='radio'";
						mysqli_query($mysqli, $deleteSql);
					}

					$deleteSql="DELETE FROM tbl_radio WHERE `lang_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_language WHERE `lid` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

				}
				else if($table=='tbl_city'){

					$sql="SELECT * FROM tbl_radio WHERE `city_id` IN ($ids)";
					$res=mysqli_query($mysqli, $sql);
					while ($row=mysqli_fetch_assoc($res)){
						if($row['radio_image']!="")
						{
							unlink('images/'.$row['radio_image']);
						}

						$id=$row['id'];
						$deleteSql="DELETE FROM tbl_favorite WHERE `post_id`='$id' AND `type`='radio'";
						mysqli_query($mysqli, $deleteSql);

						$deleteSql="DELETE FROM tbl_reports WHERE `post_id`='$id' AND `type`='radio'";
						mysqli_query($mysqli, $deleteSql);
					}

					$deleteSql="DELETE FROM tbl_radio WHERE `city_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_city WHERE `cid` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

				}
				else if($table=='tbl_category'){

					$sql="SELECT * FROM tbl_mp3 WHERE `cat_id` IN ($ids)";
					$res=mysqli_query($mysqli, $sql);
					while ($row=mysqli_fetch_assoc($res)){

						if($row['mp3_thumbnail']!="")
						{
							unlink('images/'.$row['mp3_thumbnail']);
						}

						if($row['mp3_type'] == "local") {
							$file_name = basename($row['mp3_url']);
							unlink('uploads/' . $file_name);
						}

						$id=$row['id'];
						$deleteSql="DELETE FROM tbl_favorite WHERE `post_id`='$id' AND `type`='song'";
						mysqli_query($mysqli, $deleteSql);

						$deleteSql="DELETE FROM tbl_reports WHERE `post_id`='$id' AND `type`='song'";
						mysqli_query($mysqli, $deleteSql);
					}

					$deleteSql="DELETE FROM tbl_mp3 WHERE `cat_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_category WHERE `cid` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

				}
				else if($table=='tbl_radio')
				{

					$sql="SELECT * FROM tbl_radio WHERE `id` IN ($ids)";
					$res=mysqli_query($mysqli, $sql);
					while ($row=mysqli_fetch_assoc($res)){
						if($row['radio_image']!="")
						{
							unlink('images/'.$row['radio_image']);
						}

						$id=$row['id'];
						$deleteSql="DELETE FROM tbl_favorite WHERE `post_id`='$id' AND `type`='radio'";
						mysqli_query($mysqli, $deleteSql);

						$deleteSql="DELETE FROM tbl_reports WHERE `post_id`='$id' AND `type`='radio'";
						mysqli_query($mysqli, $deleteSql);
					}

					$deleteSql="DELETE FROM tbl_radio WHERE `id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);
				}
				else if($table=='tbl_mp3'){

					$sql="SELECT * FROM tbl_mp3 WHERE `id` IN ($ids)";
					$res=mysqli_query($mysqli, $sql);
					while ($row=mysqli_fetch_assoc($res)){

						if($row['mp3_thumbnail']!="")
						{
							unlink('images/'.$row['mp3_thumbnail']);
						}

						if($row['mp3_type'] == "local") {
							$file_name = basename($row['mp3_url']);
							unlink('uploads/' . $file_name);
						}

						$id=$row['id'];
						$deleteSql="DELETE FROM tbl_favorite WHERE `post_id`='$id' AND `type`='song'";
						mysqli_query($mysqli, $deleteSql);

						$deleteSql="DELETE FROM tbl_reports WHERE `post_id`='$id' AND `type`='song'";
						mysqli_query($mysqli, $deleteSql);
					}

					$deleteSql="DELETE FROM tbl_mp3 WHERE `id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);
				}

				else if($table=='tbl_users')
				{
					$deleteSql="DELETE FROM tbl_users WHERE `id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_favorite WHERE `user_id`='$id'";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_reports WHERE `user_id`='$id'";
					mysqli_query($mysqli, $deleteSql);

					$sql="SELECT * FROM tbl_user_suggest WHERE `user_id` IN ($ids)";
					$res=mysqli_query($mysqli, $sql);
					while ($row=mysqli_fetch_assoc($res)){

						if($row['image']!="")
						{
							unlink('images/'.$row['image']);
						}
					}

					$deleteSql="DELETE FROM tbl_user_suggest WHERE `user_id`='$id'";
					mysqli_query($mysqli, $deleteSql);
				}

				else if($table=='tbl_user_suggest')
				{
					$sql="SELECT * FROM tbl_user_suggest WHERE `id` IN ($ids)";
					$res=mysqli_query($mysqli, $sql);
					while ($row=mysqli_fetch_assoc($res)){

						if($row['image']!="")
						{
							unlink('images/'.$row['image']);
						}
					}

					$deleteSql="DELETE FROM tbl_user_suggest WHERE `id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);
				}
				else if($table=='tbl_theme')
				{
					$deleteSql="DELETE FROM tbl_theme WHERE `id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);
				}

				$_SESSION['msg']="12";

			}
			$response['status']=1;
	      	echo json_encode($response);
			break;

		case 'removeReports':

			$ids=$_POST['id'];

			$deleteSql="DELETE FROM tbl_reports WHERE `id` = '$ids'";
			mysqli_query($mysqli, $deleteSql);

			$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);
			break;	
		
		default:
			# code...
			break;
	}

?>