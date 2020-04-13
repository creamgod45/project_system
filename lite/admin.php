<html>
	<?php include "plugins.php"; echo head();?>
	<body>
	<?php	
	if(@sess('admin')){
		switch(@get('page')){
			case 'view_mb':
				echo '
				<div>
					<table>
						<tr>
							<th>編號</th>
							<th>名稱</th>
							<th>帳號</th>
							<th>密碼</th>
							<th>建立時間</th>
						</tr>';
						$mb_list = squery(['getlist', "SELECT * FROM `member`"]);
						for($i=1;$i<=count($mb_list);$i++){
							echo '
							<tr>
								<th>'.$mb_list[$i][0].'</th>
								<th>'.$mb_list[$i][2].'</th>
								<th>'.$mb_list[$i][3].'</th>
								<th>'.$mb_list[$i][4].'</th>
								<th>'.$mb_list[$i][5].'</th>
							</tr>
							';
						}
						echo '
					</table>
				</div>
				';
			break;
			case 'add_mb':
				if(@post('submit')){
					$t = token();
					$n = post('name');
					$u = post('username');
					$p = post('password');
					result(
						squery(
							[
								'run', 
								"INSERT INTO `member`( 
									`access_token`, 
									`name`, 
									`username`, 
									`password`, 
									`created_time`
								) VALUES ('$t','$n','$u','$p','$time')"
							]
						), 
						[
							'新增成功',
							'新增失敗', 
							1, 
							'/lite/admin.php?page=add_mb'
						]
					);
				}else{
					echo '
					<form action="" method="POST">
						<input type="text" name="name" placeholder="名稱">
						<input type="text" name="username" placeholder="帳號">
						<input type="password" name="password" placeholder="密碼">
						<input type="submit" name="submit" value="建立">
					</form>
					';
				}
			break;
			case "del_mb":
				if(@post('submit')){
					$aid = post('aid');
					result(
						squery(
							[
								'run', 
								"DELETE FROM `member` WHERE `access_token` = '$aid'"
							]
						), 
						[
							'刪除成功',
							'刪除失敗', 
							1, 
							'/lite/admin.php?page=del_mb'
						]
					);
				}else{
					echo '
					<table>
						<tr>
							<th>使用者</th>
							<th>操作</th>
						</tr>';
					$mb_list = squery(['getlist', "SELECT * FROM `member`"]);
					for($i=1;$i<=count($mb_list);$i++){
						echo '
						<tr>
							<th>'.$mb_list[$i]['name'].'</th>
							<th>
								<form action="" method="POST">
									<input type="hidden" name="aid" value="'.$mb_list[$i][1].'">
									<input type="submit" name="submit" value="刪除使用者">
								</form>
							</th>
						</tr>
						';
					}
					echo '
					</table>';
				}
			break;
			case "edit_mb":
				if(@post('submit')){
					$a = post('aid');
					$n = post('name');
					$u = post('username');
					$p = post('password');
					result(
						squery(
							[
								'run', 
								"UPDATE `member` SET `name`='$n',`username`='$u',`password`='$p' WHERE `access_token` = '$a'"
							]
						), 
						[
							'編輯成功',
							'編輯失敗', 
							1, 
							'/lite/admin.php?page=edit_mb'
						]
					);
				}else{
					$mb_list = squery(['getlist', "SELECT * FROM `member`"]);
					for($i=1;$i<=count($mb_list);$i++){
					echo '
					<div>
						<form action="" method="POST">
							<input type="hidden" name="aid" value="'.$mb_list[$i][1].'">
							<input type="text" name="name" placeholder="名稱" value="'.$mb_list[$i][2].'">
							<input type="text" name="username" placeholder="帳號" value="'.$mb_list[$i][3].'">
							<input type="password" name="password" placeholder="密碼" value="'.$mb_list[$i][4].'">
							<input type="submit" name="submit" value="編輯">
						</form>
					</div>
					';
					}
				}
			break;
			case 'view_pj':
				$a = squery(
					[
						'getlist', 
						"SELECT * FROM `project`"
					]
				);
				echo '
				<table>
					<tr>
						<th>專案名稱</th>
						<th>專案說明</th>
						<th>專案成員</th>
						<th>專案面相</th>
						<th>建立時間</th>
					</tr>';
				for($i=1;$i<=count($a);$i++){
					echo '
					<tr>
						<th>'.$a[$i][2].'</th>
						<th>'.$a[$i][3].'</th>
						<th>'.pj_member_c($a[$i][4]).'</th>
						<th>
						';
						$b = $a[$i][1];
						$c = squery(
							[
								'getlist', 
								"SELECT * FROM `subject` WHERE `project_token` = '$b'"
							]
						);
						for($y=1;$y<=count($c);$y++){
							echo '
							<ul>
								<li style="text-align:left;">面相標題：'.$c[$y][3].'</li>
								<li style="text-align:left;">面相說明：'.$c[$y][4].'</li>
							</ul>
							';
						}
						echo '
						</th>
						<th>'.$a[$i][5].'</th>
					</tr>
					';
				}
				echo '
				</table>';
			break;
			case 'add_pj':
				if(@post('submit')){
					result(
						squery(
							[
								'', 
								""
							]
						), 
						[
							'成功',
							'失敗', 
							1, 
							'/lite/index.php?page=view_pj'
						]
					);
				}else{
					echo '
					<form action="" method="POST">
						<div>
							<input type="text" name="pj_name" placeholder="'.keyw3.'">
							<input type="text" name="pj_dec" placeholder="'.keyw4.'">
						</div>
						<div id="sj_box_add_pj"></div>
						<a onclick="add_pj(\'add_pj\');" href="javascript:void(0);">新增面相</a>
						<input type="submit" name="auth" value="登入">
					</form>
					';
				}
			break;			
			case 'view_ct':
				
			break;
			default: 
				echo '
					<ul style="display:flex;">
						<li style="display:block;margin:0px 8px;">使用者管理
							<ul>
								<li><a href="/lite/admin.php?page=add_mb">新增</a></li>
								<li><a href="/lite/admin.php?page=del_mb">刪除</a></li>
								<li><a href="/lite/admin.php?page=edit_mb">修改</a></li>
								<li><a href="/lite/admin.php?page=view_mb">檢視</a></li>
							</ul>
						</li>
						<li style="display:block;margin:0px 8px;">專案管理
							<ul>
								<li><a href="/lite/admin.php?page=add_pj">新增</a></li>
								<li><a href="/lite/admin.php?page=">指定專案成員</a></li>
								<li><a href="/lite/admin.php?page=">修改專案成員</a></li>
								<li><a href="/lite/admin.php?page=">修改專案</a></li>
								<li><a href="/lite/admin.php?page=">刪除專案</a></li>
								<li><a href="/lite/admin.php?page=view_pj">檢視專案</a></li>
							</ul>
						</li>
						<li style="display:block;margin:0px 8px;">統計管理
							<ul>
								<li><a href="/lite/admin.php?page=">新增</a></li>
								<li><a href="/lite/admin.php?page=">刪除</a></li>
								<li><a href="/lite/admin.php?page=">修改</a></li>
								<li><a href="/lite/admin.php?page=">檢視</a></li>
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