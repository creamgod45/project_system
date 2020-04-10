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
					<ul>
						<li>使用者管理</li>
						<ul>
							<li><a href="/lite/index.php">新增</a></li>
							<li><a href="">刪除</a></li>
							<li><a href="">修改</a></li>
							<li><a href="">檢視</a></li>
						</ul>
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