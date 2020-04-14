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
					result(squery(['run', "UPDATE `member` SET `name`='$n',`username`='$u',`password`='$p' WHERE `access_token` = '$a'"]), ['編輯成功','編輯失敗', 1, '/lite/admin.php?page=edit_mb']);
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
				$a = squery(['getlist', "SELECT * FROM `project`"]);
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
						$c = squery(['getlist', "SELECT * FROM `subject` WHERE `project_token` = '$b'"]);
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
					$a = post('pj_name');
					$b = post('pj_dec');
					$c = obj_d(post('sj_array'));
					$d = token();
					for($i=1;$i<=count($c)-1;$i++){
						$sj_name = $c[$i][0];
						$sj_dec = $c[$i][1];
						$result = squery(['run',"INSERT INTO `subject`(`project_token`, `theme_key`, `subject_title`, `subject_content`, `subject_enable`, `created_time`) VALUES ('$d','$i','$sj_name','$sj_dec','true','$time')"]);
					}
					result(squery(['run', "INSERT INTO `project`(`project_token`, `project_title`, `project_content`, `project_member`, `created_time`) VALUES ('$d','$a','$b','','$time')"]), ['建立成功','建立失敗', 1, '/lite/admin.php?page=view_pj']);
				}else{
					echo '
					<form action="" onsubmit="sj_load(\'add_pj\');" method="POST">
						<div>
							<input type="text" name="pj_name" placeholder="'.keyw3.'">
							<input type="text" name="pj_dec" placeholder="'.keyw4.'">
						</div>
						<div id="sj_box_add_pj"></div>
						<a onclick="add_pj(\'add_pj\');" href="javascript:void(0);">新增面相</a>
						<input type="hidden" id="sj_array_add_pj" name="sj_array">
						<input type="submit" name="submit" value="新增">
					</form>
					';
				}
			break;
			case 'set_pjm':
				if(@post('submit')){
					$str = '';
					$a = post('leader');
					$b = [];
					$c = 1;
					foreach($_POST as $key => $value){
						if($value === "member" && $key != $a){
							$b[$c]=$key;
							$c++;
						}
					}
					$a = findsql(['member','access_token',$a]);
					$str .= "/".$a['name'].":1";
					foreach($b as $key => $value){
						$e = findsql(['member','access_token',$value]);
						$str .= "/".$e['name'].":0";
					}
					$f = post('pj_key');
					result(
						squery(
							[
								'run', 
								"UPDATE `project` SET `project_member`='$str' WHERE `project_token` = '$f'"
							]
						), 
						[
							'指派成功',
							'指派失敗', 
							1, 
							'/lite/admin.php?page=view_pj'
						]
					);
				}else{
					$pj_list = squery(['getlist', "SELECT * FROM `project`"]);
					$mb_list = squery(['getlist', "SELECT * FROM `member`"]);
					for($i=1;$i<=count($pj_list);$i++){
						echo '
						<div>
							<form action="" method="POST">
								<h2>'.keyw3.":".$pj_list[$i][2].'</h2>
								<table>
									<tr>
										<th>使用者名稱</th>
										<th>指派組長</th>
										<th>指派組員</th>
									</tr>';
									for($y=1;$y<=count($mb_list);$y++){
										echo '
										<tr>
											<th>'.$mb_list[$y]['name'].'</th>
											<th><input type="radio" name="leader" value="'.$mb_list[$y][1].'"></th>
											<th><input type="checkbox" name="'.$mb_list[$y][1].'" value="member"></th>
										</tr>
										';
									}
									echo '
								</table>
								<input type="hidden" name="pj_key" value="'.$pj_list[$i][1].'">
								<input type="submit" name="submit" value="送出">
							</form>
						</div>
						';
					}
				}
			break;
			case 'set_pjms':
				if(@post('submit')){
					$a = post('pj_key');
					$b = post('aid');
					$c = squery(['get', "SELECT * FROM `project` WHERE `project_token` = '$a'"]);
					$d = obj_d($c[4]);
					$e = findsql(['member','access_token',$b]);
					for($i=1;$i<=count($d)-1;$i++){
						if($d[$i][0] === $e['name']){
							unset($d[$i]);
						}
					}
					$d = obj_e($d);
					result(
						squery(
							[
								'run', 
								"UPDATE `project` SET `project_member`='$d' WHERE `project_token` = '$a'"
							]
						), 
						[
							'成功',
							'失敗', 
							1, 
							'/lite/admin.php?page=view_pj'
						]
					);
				}else{
					$pj_list = squery(['getlist', "SELECT * FROM `project`"]);
					for($i=1;$i<=count($pj_list);$i++){
						echo '
						<ul>
							<li>
								<h2>'.keyw3.":".$pj_list[$i][2].'</h2>';
								$a = obj_d($pj_list[$i][4]);
								for($y=1;$y<=count($a)-1;$y++){
									@$b = findsql(['member','name',$a[$y][0]]);
									echo '
									<form action="" method="POST">
										<span>'.$b[2].'</span>
										<input type="hidden" name="pj_key" value="'.$pj_list[$i][1].'">
										<input type="hidden" name="aid" value="'.$b[1].'">
										<input type="submit" name="submit" value="刪除成員">
									</form>
									';
								}
								echo '
							</li>
						</ul>
						';
					}
				}
			break;
			case 'set_pj':
				
			break;
			case 'del_pj':
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
							'/lite/.php?page='
						]
					);
				}else{
					for($i=1;$i<=count($);$i++){}
					echo '';
				}
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
								<li><a href="/lite/admin.php?page=set_pjm">指定專案成員</a></li>
								<li><a href="/lite/admin.php?page=set_pjms">修改專案成員</a></li>
								<li><a href="/lite/admin.php?page=set_pj">修改專案</a></li>
								<li><a href="/lite/admin.php?page=del_pj">刪除專案</a></li>
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