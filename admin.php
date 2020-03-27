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
		if($query){
			echo '<H1>修改成功';
			header('refresh:1;url="/admin.php"');
		}else {
			echo '<H1>修改失敗';
			header('refresh:1;url="/admin.php"');
		}
	}elseif(@$_POST['createproject']){
		$object=[];
		$tmp1 = explode('/',$_POST['pjt_array']);
		unset($tmp1[0]);
		for ($i=1; $i <= 10; $i++) { 
			$tmp2 = explode(':',$tmp1[$i]);
			$object[$i]['pjt_name']= $tmp2[0];
			$object[$i]['pjt_dec']= $tmp2[1];
		}
		$json = json_encode($object);
		
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
						<ul>
							<li><a id="create_user" href="javascript:void(0)">新增</a></li>
							<li><a id="edit_user" href="javascript:void(0)">修改</a></li>
							<li><a id="delete_user" href="javascript:void(0)">刪除</a></li>
							<li><a id="cuser_panel" href="javascript:void(0)">檢視</a></li>
						</ul>
					</li>
					<li><a href="javascript:void(0)">專案管理</a>
						<ul>
							<li><a id="cp" href="javascript:void(0)">新增</a></li>
							<li><a href="javascript:void(0)">指定專案成員</a></li>
							<li><a href="javascript:void(0)">修改專案成員</a></li>
							<li><a href="javascript:void(0)">修改專案</a></li>
							<li><a href="javascript:void(0)">刪除專案</a></li>
							<li><a href="javascript:void(0)">檢視專案</a></li>
						</ul>
					</li>
					<li><a href="javascript:void(0)">統計管理</a></li>
				</ul>
				</nav>
				<main class="nav_space"><ul>';
				// user
				$member_list = $project->get_member("513f42e9bf55ae62a69173c9b609ae18");
				echo '<div id="user_panel">';
				for($i=1;$i<=count($member_list);$i++){
					echo '
						<ul class="user_card">
							<li>用戶ID：'.$member_list[$i]['id'].'</li>
							<li>用戶姓名：'.$member_list[$i]['name'].'</li>
							<li>用戶帳號：'.$member_list[$i]['username'].'</li>
							<li>用戶密碼：'.$member_list[$i]['password'].'</li>
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
					<form action="" method="POST" class="dialog_main" style="overflow:auto;height:280px;">
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
					<form action="" method="POST" class="dialog_main" onsubmit="return pjt_load();" style="overflow:auto;height:280px;">
						<div style="float:right;" id="close_cps">&times;</div>
						<div><label>專案名稱：</label><input class="input" type="text" name="pj_name" required /></div>
						<div><label>專案說明：</label><input class="input" type="text" name="pj_dec" required /></div>
						<div><label>面相1標題：</label><input class="input" type="text" id="pjt_name_1"></div>
						<div><label>面相1說明：</label><input class="input" type="text" id="pjt_dec_1"></div>
						<div id="pjt_box"></div>
						<div><a href="javascript:void(0)" onclick="add_pjt()">新增面相</a></div>
						<input type="hidden" name="pjt_array" id="pjt_array">
						<input class="input btn" name="createproject" type="submit" value="新增專案">
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