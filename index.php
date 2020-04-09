<?php 

require_once "project_system.php";
$project = new project_system();
if(@$project->is_member($_SESSION['member'])){
	if(@$_POST['submit']){
		@$text = $_POST['comment'];
		@$datatype = $_POST['file_dataurl'];
		@$file = $_FILES['file'];
		if(isset($datatype)){
			$subfilename = explode(".", $file['name']);
			$subfilename = $subfilename[1];
			$filename = md5(time()).".".$subfilename;
			$target_file = "files/".$filename;
			echo '檔案類型：'.$datatype."<br>";
			if (move_uploaded_file($file["tmp_name"], $target_file)) {
				echo $target_file. "上傳完成";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}else{
		$pj_list = $project->getproject_arr();
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
		</head>';
		switch(@$_GET['page']){
			case 'view_project':
				@$pj_token = $_GET['token'];
				echo '<body>';
				$project_item = $project->getproject($pj_token);
				$subject_list = $project->getsubject($pj_token);
				echo '
				<div class="prj">
					<div class="prj_viewer">
						<div class="prj_header">
							<ul class="frame unlist">
								<li><h2>專案名稱：'.$project_item['project_title'].'</h2></li>
								<li>專案說明：'.$project_item['project_content'].'</li>
								<div class="item_list">';
							for($i=1;$i<=count($subject_list);$i++){
								echo '
									<ul class="prj_item unlist">
										<li><h3>'.$subject_list[$i]['subject_title'].'</h3></li>
										<li>'.$subject_list[$i]['subject_content'].'</li>
										<form action="" method="POST" class="comment" enctype="multipart/form-data">
											<label for="file'.$i.'" class="file_btn"><img width="24" src="assets/file.png"></label>
											<input id="file'.$i.'" class="file" type="file" name="file" onchange="fileAsData(this, '.$i.')">
											<input type="hidden" id="dataurl'.$i.'" name="file_dataurl" value="0">
											<input class="text_box" id="text_'.$i.'" type="text" name="comment">
											<input class="btn" type="submit" name="submit">
										</form>
									</ul>
								';
							}
				echo '			</div>
							</ul>
						</div>
					</div>
				</div></body>';
			break;
			default: 
				echo '<body><nav><h1>專案討論系統</h1></nav><br><br>';
				for ($i=1; $i <= count($pj_list); $i++) { 
					$query = $project->projectmember($_SESSION['member'],$pj_list[$i]);
					if($query[0]){
						echo '
						<div class="prj_viewer">
							<div><a href="/index.php?page=view_project&token='.$pj_list[$i]['project_token'].'">'.$pj_list[$i]['project_title'].'</a></div>
						</div>
						';
					}
				}
				echo '</body>';
			break;
		}
		echo '</html>';
	}
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
		var_dump($_SESSION['member']);
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