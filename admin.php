<?php 

require_once "project_system.php";
$project = new project_system();
if(@$project->is_adminstrator($_SESSION['adminstrator'])){
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
                <li><a href="javascript:void(0)">新增</a></li>
                <li><a href="javascript:void(0)">修改</a></li>
                <li><a href="javascript:void(0)">刪除</a></li>
                <li><a id="cuser_panel" href="javascript:void(0)">檢視</a></li>
            </ul>
        </li>
        <li><a href="javascript:void(0)">專案管理</a>
            <ul>
                <li><a href="javascript:void(0)">新增</a></li>
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
	echo '<div id="user_panel" style="display:none;">';
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
	</ul></main>
	<div class="dialog">
		<div class="dialog_main">akjsfapsgfpajkspfjpo</div>
	</div>
</body>

</html>
	';
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