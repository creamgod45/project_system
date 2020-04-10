<html>
	<?php include "plugins.php"; echo head();?>
	<body>
	<?php	
	if(@sess('admin')){
		switch(@get('page')){
			case 'view_member':
			break;
			case 'add_mebmer':
			break;
			default: 
				echo '
					<ul style="display:flex;">
						<li style="display:block;">使用者管理
							<ul>
								<li><a href="">新增</a></li>
								<li><a href="">刪除</a></li>
								<li><a href="">修改</a></li>
								<li><a href="">檢視</a></li>
							</ul>
						</li>
						<li style="display:block;">專案管理
							<ul>
								<li><a href="">新增</a></li>
								<li><a href="">指定專案成員</a></li>
								<li><a href="">修改專案成員</a></li>
								<li><a href="">修改專案</a></li>
								<li><a href="">刪除專案</a></li>
								<li><a href="">檢視專案</a></li>
							</ul>
						</li>
						<li style="display:block;">統計管理
							<ul>
								<li><a href="">新增</a></li>
								<li><a href="">刪除</a></li>
								<li><a href="">修改</a></li>
								<li><a href="">檢視</a></li>
							</ul>
						</li>
					</ul>
				';
			break;
		}
	}else{
		if(@post('auth')!=null){
			$query = aauth([post('username'),post('password')]);
			result($query,['登入成功','登入失敗', 1, '/lite/admin.php']);
		}else{
			echo '
			<form action="" method="POST">
				<input type="text" name="username" placeholder="帳號">
				<input type="password" name="password" placeholder="密碼">
				<input type="submit" name="auth" value="登入">
			</form>
			';
		}
	}
	?>
	</body>
</html>