<?php 

require_once "project_system.php";
$project = new project_system();
if(@$project->is_member($_SESSION['member'])){
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
		<nav><h1>專案討論系統</h1></nav><br>
		<div>
			<h2>專案列表</h2>
			<ul>
				<li></li>
				<li></li>
			</ul>
		</div>
	</body>
	
	</html>
	';
}else{	// 登入會員
	if(@$_POST['login']!=null){
		$query = $project->auth($_POST['username'],$_POST['password']);
		if(is_array($query)){
			$_SESSION['member'] = $query;
			echo "<h1>登入成功</h1>";
			header('refresh:2;url="/"');
		}else{
			echo "<h1>登入失敗</h1>";
			header('refresh:2;url="/"');
		}
	}else{
	echo'
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