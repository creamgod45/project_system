<?php 

require_once "project_system.php";
$project = new project_system();
if(@$project->is_adminstrator($_SESSION['adminstrator'])){
	if(@$_POST['createuser']){
		$query = $project->create_member([$_POST['name'],$_POST['username'],$_POST['password']]);
		if($query){
			echo '<H1>新增成功';
			header('refresh:1;url="/admin.php"');
		}else { 
			echo '<H1>新增失敗';
			header('refresh:1;url="/admin.php"');
		}
	}elseif(@$_POST['deleteuser']){
		$query = $project->remove_member($_POST['key']);
		if($query){
			echo '<H1>刪除成功';
			header('refresh:1;url="/admin.php"');
		}else {
			echo '<H1>刪除失敗';
			header('refresh:1;url="/admin.php"');
		}
	}elseif(@$_POST['edituser']){
		$query = $project->edit_member([$_POST['key'],$_POST['name'],$_POST['username'],$_POST['password']]);
		print_r($query);
		if($query){
			echo '<H1>修改成功';
			//header('refresh:1;url="/admin.php"');
		}else {
			echo '<H1>修改失敗'.$query;
			//header('refresh:1;url="/admin.php"');
		}
	}elseif(@$_POST['createproject']){
		$object=[];
		$tmp1 = explode('/',$_POST['pjt_array']);
		unset($tmp1[0]);
		for ($i=1; $i <= count($tmp1); $i++) { 
			$tmp2 = explode(':',$tmp1[$i]);
			$object[$i]['pjt_name']= $tmp2[0];
			$object[$i]['pjt_dec']= $tmp2[1];
		}
		$json = json_encode($object, JSON_UNESCAPED_UNICODE);
		$pj_name = $_POST['pj_name'];
		$pj_dec = $_POST['pj_dec'];
		$query = $project->createproject([$pj_name,$pj_dec,$json]);
		if($query){
			echo "<h1>建立成功";
			header('refresh:1;url="/admin.php"');
		}else{
			echo "<h1>建立失敗";
			header('refresh:1;url="/admin.php"');
		}
	}elseif(@$_POST['editprojectmember']){
		$string = "";
		$leader = $_POST['leader'];
		$tmp_member = [];
		$x=1;
		foreach($_POST as $key => $value){
			if($value==="member" && $key != $leader){
				$tmp_member[$x] = $key;
				$x++;
			}
		}
		$leader = $project->findmember('access_token',$leader);
		$string .= "/".$leader['name'].":1";
		foreach($tmp_member as $key => $value){
			$tmp = $project->findmember('access_token', $value);
			$string .= "/".$tmp['name'].":0";
		}
		$query = $project->setprojectmember($_POST['token'],$string);
		if($query){
			echo "<h1>指派成功";
			header('refresh:1;url="/admin.php"');
		}else{
			echo "<h1>指派失敗";
			header('refresh:1;url="/admin.php"');
		}
	}elseif(@$_POST['aprojectmember']){
		$name = $_POST['name'];
		$token = $_POST['token'];
		$member = $_POST['member'];
		$string ="";
		$tmp=[];
		$row = explode('/',$member);
		for($i=1;$i<=count($row)-1;$i++){
			$tmp[$i] = explode(':',$row[$i]);
			if($tmp[$i][0]===$name){
				unset($tmp[$i]);
			}else{
				$string .="/".$tmp[$i][0].":".$tmp[$i][1];
			}
		}
		$query = $project->setprojectmember($token,$string);
		if($query){
			echo "<h1>刪除成功";
			header('refresh:1;url="/admin.php"');
		}else{
			echo "<h1>刪除失敗";
			header('refresh:1;url="/admin.php"');
		}
	}elseif(@$_POST['editproject']){
		$pj_name = $_POST['pj_name'];
		$pj_dec = $_POST['pj_dec'];
		$pj_token = $_POST['token'];
		$object=[];
		$tmp1 = explode('/',$_POST['pjt_array']);
		unset($tmp1[0]);
		for ($i=1; $i <= count($tmp1); $i++) { 
			$tmp2 = explode(':',$tmp1[$i]);
			$object[$i]['pjt_name']= $tmp2[0];
			$object[$i]['pjt_dec']= $tmp2[1];
		}
		$query = $project->setproject([$pj_token,$pj_name,$pj_dec,$object]);
		if($query){
			echo "<h1>修改成功";
			header('refresh:1;url="/admin.php"');
		}else{
			echo "<h1>修改失敗";
			header('refresh:1;url="/admin.php"');
		}
	}elseif(@$_POST['deletedproject']){
		$token = $_POST['token'];
		$query = $project->deleteproject($token);
		if($query){
			echo "<h1>刪除成功";
			header('refresh:1;url="/admin.php"');
		}else{
			echo "<h1>刪除失敗";
			header('refresh:1;url="/admin.php"');
		}
	}else{
		echo '
			<html>

			<head>
				<meta charset="UTF-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1.0" />
				<script src="assets/js/core.js"></script>
				<script src="assets/js/main.js"></script>
				<link rel="stylesheet" type="text/css" href="assets/css/core.css" />
				<link rel="stylesheet" type="text/css" href="assets/css/main.css" />
				<title>專案討論系統</title>
			</head>

			<body>
				<nav>
				<ul class="down-menu">
					<li><a href="javascript:void(0)">後台管理</a></li>
					<li><a href="javascript:void(0)">使用者管理</a>
						<ul style="margin:0;padding:0;list-style:none;">
							<li><a id="create_user" href="javascript:void(0)">新增</a></li>
							<li><a id="edit_user" href="javascript:void(0)">修改</a></li>
							<li><a id="delete_user" href="javascript:void(0)">刪除</a></li>
							<li><a id="cuser_panel" href="javascript:void(0)">檢視</a></li>
						</ul>
					</li>
					<li><a href="javascript:void(0)">專案管理</a>
						<ul style="margin:0;padding:0;list-style:none;">
							<li><a id="cp" href="javascript:void(0)">新增</a></li>
							<li><a id="epm" href="javascript:void(0)">指定專案成員</a></li>
							<li><a id="apm" href="javascript:void(0)">修改專案成員</a></li>
							<li><a id="ep" href="javascript:void(0)">修改專案</a></li>
							<li><a id="dp" href="javascript:void(0)">刪除專案</a></li>
							<li><a href="javascript:void(0)">檢視專案</a></li>
						</ul>
					</li>
					<li><a href="javascript:void(0)">統計管理</a></li>
				</ul>
				</nav>
				<main class="nav_space"><ul>';
				// user
				$member_list = $project->get_member();
				echo '<div id="user_panel">';
				for($i=1;$i<=count($member_list);$i++){
					echo '
						<ul class="user_card" style="list-style:none;">
							<li>用戶ID：'.$member_list[$i]['id'].'</li>
							<li>用戶姓名：'.$member_list[$i]['name'].'</li>
							<li>用戶帳號：'.$member_list[$i]['username'].'</li>
						</ul>
					';
				}
				echo '</div>';

				echo '
				</ul>
				</main>

				<!-- create user -->
				<div id="user_card_bg" style="display:none;" class="dialog_bg"></div>
				<div id="user_card" style="display:none;" class="dialog">
					<form action="" method="POST" class="dialog_main">
						<div style="float:right;" id="close_user_card">&times;</div>
						<div><label>使用者名稱：</label><input class="input" type="text" name="name" required /></div>
						<div><label>使用者帳號：</label><input class="input" type="text" name="username" required /></div>
						<div><label>使用者密碼：</label><input class="input" type="password" name="password" required /></div>
						<input class="input btn" name="createuser" type="submit" value="新增使用者">
					</form>
				</div>

				<!-- delete user -->
				<div id="delete_users_bg" style="display:none;" class="dialog_bg"></div>
				<div id="delete_users" style="display:none;" class="dialog">
					<form action="" method="POST" class="dialog_main">
						<div style="float:right;" id="close_delete_users">&times;</div>';
						for($i=1;$i<=count($member_list);$i++){
							echo '
								<div>
									<span>使用者：'.$member_list[$i]['name'].'</span>
									<input type="hidden" name="key" value="'.$member_list[$i]['access_token'].'">
									<input type="submit" name="deleteuser" value="刪除使用者">
								</div>
							';
						}
					echo'
					</form>
				</div>

				<!-- edit user -->
				<div id="edit_users_bg" style="display:none;" class="dialog_bg"></div>
				<div id="edit_users" style="display:none;" class="dialog">
					<form action="" method="POST" class="dialog_main" style="overflow:auto;height:280px;width:30vw;height:70vh;">
						<div style="float:right;" id="close_edit_users">&times;</div>';
						for($i=1;$i<=count($member_list);$i++){
							echo '
								<h5>使用者名稱：'.$member_list[$i]['name'].'</h5>
								<div style="border:solid black 3px;">
									<div><label>使用者名稱：</label><input class="input" type="text" name="name" value="'.$member_list[$i]['name'].'" required /></div>
									<div><label>使用者帳號：</label><input class="input" type="text" name="username" value="'.$member_list[$i]['username'].'" required /></div>
									<div><label>使用者密碼：</label><input class="input" type="password" name="password" value="'.$member_list[$i]['password'].'" required /></div>
									<input type="hidden" name="key" value="'.$member_list[$i]['access_token'].'">
									<input class="input btn" name="edituser" type="submit" value="修改">
								</div>
							';
						}
					echo'
					</form>
				</div>

				<!-- create project -->
				<div id="cps_bg" style="display:none;" class="dialog_bg"></div>
				<div id="cps" style="display:none;" class="dialog">
					<form action="" method="POST" class="dialog_main" onsubmit="return pjt_load();" style="overflow:auto;height:280px;width:35vw;height:70vh;">
						<div style="float:right;" id="close_cps">&times;</div>
						<div><label>專案名稱：</label><input class="input" type="text" name="pj_name" required /></div>
						<div><label>專案說明：</label><input class="input" type="text" name="pj_dec" required /></div>
						<div><label>面相標題：</label><input class="input" type="text" id="pjt_name_1"></div>
						<div><label>面相說明：</label><input class="input" type="text" id="pjt_dec_1"></div>
						<div id="pjt_box"></div>
						<div><a href="javascript:void(0)" onclick="add_pjt()">新增面相</a></div>
						<input type="hidden" name="pjt_array" id="pjt_array">
						<input class="input btn" name="createproject" type="submit" value="新增專案">
					</form>
				</div>

				<!-- edit project member -->
				<div id="epms_bg" style="display:none;" class="dialog_bg"></div>
				<div id="epms" style="display:none;" class="dialog">
					<div class="dialog_main" style="overflow:auto;height:280px;width:50vw;height:50vh;">
						<div style="float:right;" id="close_epms">&times;</div>';
						$prject_list = $project->getproject_arr();
						for($i=1;$i<=count($prject_list);$i++){
							echo '
							<form action="" method="POST">
								<details>
									<summary>專案名稱：'.$prject_list[$i]['project_title'].'</summary>
									<div>成員：'.$project->checkmember($prject_list[$i]['project_member']).'</div>
									<table width="100%" style="height:100px;overflow:auto;border:solid black 2px;padding:8px;">
										<tr>
											<th>使用者名稱<th>
											<th>指派組長<th>
											<th>指派組員<th>
										</tr>';
									for($y=1;$y<=count($member_list);$y++){
										echo '
										<tr>
											<th>'.$member_list[$y]['name'].'<th>
											<th><input type="radio" class="leader_'.$i.'" name="leader" value="'.$member_list[$y]['access_token'].'"><th>
											<th><input type="checkbox" name="'.$member_list[$y]['access_token'].'" value="member"></th>
										</tr>
										';
									}
									echo '
									</table>
									<th><input type="hidden" name="token" value="'.$prject_list[$i]['project_token'].'"></th>
									<input name="editprojectmember" type="submit" value="指派專案成員">
								</details>
							</form>
							';
						}
						echo '
					</div>
				</div>

				<!-- a project member -->
				<div id="apms_bg" style="display:none;" class="dialog_bg"></div>
				<div id="apms" style="display:none;" class="dialog">
					<div class="dialog_main" style="overflow:auto;height:280px;width:50vw;height:50vh;">
						<div style="float:right;" id="close_apms">&times;</div>';
						$prject_list = $project->getproject_arr();
						for($i=1;$i<=count($prject_list);$i++){
							echo '
							<form action="" method="POST">
								<details>
									<summary>專案名稱：'.$prject_list[$i]['project_title'].'</summary>
									<div>成員：'.$project->checkmembers($prject_list[$i]['project_member'],$prject_list[$i]['project_token']).'</div>
								</details>
							</form>
							';
						}
						echo '
					</div>
				</div>

				<!-- edit project -->
				<div id="eps_bg" style="display:none;" class="dialog_bg"></div>
				<div id="eps" style="display:none;" class="dialog">
					<div class="dialog_main" style="overflow:auto;height:280px;width:90vw;height:90vh;">
						<div style="float:right;" id="close_eps">&times;</div>';
						$prject_list = $project->getproject_arr();
						for($i=1;$i<=count($prject_list);$i++){
							$subject_list = $project->getsubject($prject_list[$i]['project_token']);
							$subject_num = count($subject_list)+1;
							echo '
							<form action="" method="POST" onsubmit="return subject_load(\''.$prject_list[$i]['project_token'].'\');">
								<div><label>專案名稱：</label><input class="input" type="text" value="'.$prject_list[$i]['project_title'].'" name="pj_name" required /></div>
								<div><label>專案說明：</label><input class="input" type="text" value="'.$prject_list[$i]['project_content'].'" name="pj_dec" required /></div>';
								echo '
								<div id="pjt_box'.$prject_list[$i]['project_token'].'"></div>
								<script>
								var _layer = "'.$prject_list[$i]['project_token'].'";       // 儲存位置
								object[_layer] = [];                                        // 儲存位置初始化';
								for($y=1;$y<=$subject_num-1;$y++){
									echo '
									php_subject_load(_layer, {'.$y.':["'.$subject_list[$y]['subject_title'].'","'.$subject_list[$y]['subject_content'].'"]});';
								}
								echo '
								gen_subject(_layer);
								</script>
								<div><a href="javascript:void(0)" onclick="subject_add(\''.$prject_list[$i]['project_token'].'\')">新增面相</a></div>
								<input type="hidden" name="token" value="'.$prject_list[$i]['project_token'].'">
								<input type="hidden" name="pjt_array" id="pjt_array_'.$prject_list[$i]['project_token'].'">
								<input class="input btn" name="editproject" type="submit" value="編輯專案">
							</form>
							';
						}
					echo '
					</div>
				</div>				

				<!-- delete project -->
				<div id="dps_bg" style="display:none;" class="dialog_bg"></div>
				<div id="dps" style="display:none;" class="dialog">
					<form action="" method="POST" class="dialog_main" style="overflow:auto;height:280px;width:35vw;height:70vh;">
						<div style="float:right;" id="close_dps">&times;</div>';
						for($i=1;$i<=count($prject_list);$i++){
							echo '
								<li>'.$prject_list[$i]['project_title'].'<input type="hidden" name="token" value="'.$prject_list[$i]['project_token'].'"><input type="submit" name="deletedproject" value="刪除專案"></li>
							';
						}
						echo '
					</form>
				</div>

			</body>

			</html>
		';
	}
}else{	// 登入會員
	if(@$_POST['login']!=null){
		$query = $project->admin_auth($_POST['username'],$_POST['password']);
		if($query){
			$_SESSION['adminstrator'] = true;
			echo "<h1>登入成功</h1>";
			header('refresh:2;url="/admin.php"');
		}else{
			echo "<h1>登入失敗</h1>";
			header('refresh:2;url="/admin.php"');
		}
	}else{
	echo '
	<html>
	
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<script src="assets/js/core.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/css/core.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/main.css" />
		<title>專案討論系統</title>
	</head>
	
	<body>
		<nav><h1>專案討論系統</h1></nav>
		<main>
			<div class="login_panel">
				<form class="card" action="" method="POST">
					<h2 style="text-align:center;">登入系統</h2>
					<div class="inputs_box">
						<label>帳號：</label>
						<input type="text" name="username" />
					</div>
					<div class="inputs_box">
						<label>密碼：</label>
						<input type="password" name="password" />
					</div>
					<input class="submit" name="login" type="submit" value="送出" />
				</form>
			</div>
		</main>
	</body>
	
	</html>
	';
	}
}
?>