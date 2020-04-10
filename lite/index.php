<html>
	<?php include "plugins.php"; echo head();?>
	<body>
	<?php	
	if(@ismember(sess('member'))){
		if(@post('pj_enable')){
			$pj_token = post('pj_token');
			$th_key = post('th_key');
			$sj_list = squery(['getlist', "SELECT * FROM `subject` WHERE `project_token`='$pj_token' ORDER BY `theme_key` ASC"]);
			$boolean = $sj_list[$th_key][5];
			if($boolean === "true"){
				$boolean = 'false';
			}else{
				$boolean = 'true';
			}
			result(
				squery(
					[
						'run', 
						"UPDATE `subject` SET `subject_enable`='$boolean' WHERE `theme_key` = '$th_key' AND `project_token` = '$pj_token'"
					]
				), 
				[
					'更改成功',
					'更改失敗', 
					1, 
					'/lite/index.php?page=view_pj&token='.post('pj_token')
				]
			);

		}elseif(@post('score_sj')){
			$aid = sess('member')[1];
			$score_key = post('score_key');
			$score = post('score');
			result(
				squery(
					[
						'run', 
						"INSERT INTO `score`(`access_token`, `score_key`, `score`, `created_time`) VALUES ('$aid','$score_key','$score','$time')"
					]
				), 
				[
					'評價成功',
					'評價失敗', 
					1, 
					'/lite/index.php?page=view_pj&token='.post('pj_token')
				]
			);
		}elseif(@post('cmt')){
			$file = $_FILES['file'];
			$dataurl = post('dataurl');
			$aid = sess('member');
			$aid = $aid[1];
			$pj_token = post('pj_token');
			$th_key = post('th_key');
			$score_key = token();
			if(@$dataurl){
				list($filename , $subfile) = explode('.',$file['name']);
				$filename = md5(time()).'.'.$subfile;
				$path = "./files/".$filename;
				$content = post('title').':'.$filename.':'.post('text');
				if(move_uploaded_file($file['tmp_name'], $path)){
					result(squery(['run', "INSERT INTO `comment`(`access_token`, `project_token`, `theme_key`, `score_key`, `comment_type`, `comment_content`, `created_time`) VALUES ('$aid','$pj_token','$th_key','$score_key','$dataurl','$content','$time')"]), ['上傳完成','上傳失敗',1,'/lite/index.php?page=view_pj&token='.post('pj_token')]);	
				}else{
					alert_text('抱歉!無法上傳檔案');
					refresh([1,'/lite/index.php?page=view_pj&token='.post('pj_token')]);
				}
			}else{
				$content = post('title').':'.post('text');
				result(squery(['run', "INSERT INTO `comment`(`access_token`, `project_token`, `theme_key`, `score_key`, `comment_type`, `comment_content`, `created_time`) VALUES ('$aid','$pj_token','$th_key','$score_key','text','$content','$time')"]), ['發表成功','發表失敗', 1, '/lite/index.php?page=view_pj&token='.post('pj_token')]);
			}
		}else{
			@$pj_list = squery(['getlist', "SELECT * FROM `project` WHERE 1"]);
			switch(@get('page')){
				case 'view_pj':
					$pj_token = get('token');
					$pj_item = squery(['get',"SELECT * FROM `project` WHERE `project_token` = '$pj_token'"]);
					$sj_list = squery(['getlist',"SELECT * FROM `subject` WHERE `project_token` = '$pj_token' ORDER BY `id` ASC"]);
					echo '
					<ul>
						<h2>'.keyw3.'：'.$pj_item[2].'</h2>
						<b>'.keyw4.'：'.$pj_item[3].'</b>
						<div>';
						for($i=1;$i<=count($sj_list);$i++){
							echo '
							<ul>
								<form action="" method="POST">
									<input type="hidden" name="th_key" value="'.$sj_list[$i][2].'">
									<input type="hidden" name="pj_token" value="'.$pj_token.'">
									<input type="submit" name="pj_enable" value="'.keyw15.'">
								</form>
								<div>'.keyw2.'：'.$sj_list[$i][3].'</div>
								<div>'.keyw3.'：'.$sj_list[$i][4].'</div>';
								$th_key = $sj_list[$i]['theme_key'];
								$cmt_list = squery(['getlist', "SELECT * FROM `comment` WHERE `theme_key` = '$th_key' AND `project_token` = '$pj_token'"]);
								for($y=1;$y<=count($cmt_list);$y++){
									$info = explode(':',$cmt_list[$y][6]);
									if($cmt_list[$y][5] != "text"){
										echo '
										<ul>
											<div class="comment_item">
												<div>'.keyw9.':'.$y.'</div>
												<div>'.keyw10.':'.$cmt_list[$y][7].'</div>
												'.getscore($cmt_list[$y][2]).'<hr>
												<div><h2>'.keyw13.':'.$info[0].'</h2></div>
												<div>'.keyw14.'：'.$info[2].'</div>
												<div>
													<'.$cmt_list[$y][5].' width="100%" controls>
														<source src="./files/'.$info[1].'">
													</'.$cmt_list[$y][5].'>
												</div>
												<hr>
												<form class="score_item" action="" method="POST">
													<li>評分意見：</li>
													<li>
														<span class="score_title">1</span>
														<span class="score_title">2</span>
														<span class="score_title">3</span>
														<span class="score_title">4</span>
														<span class="score_title">5</span>
													</li>
													<li>
														<input type="radio" name="score" value="1" checked>
														<input type="radio" name="score" value="2">
														<input type="radio" name="score" value="3">
														<input type="radio" name="score" value="4">
														<input type="radio" name="score" value="5">
													</li>
													<input type="hidden" name="pj_token" value="'.$pj_token.'">
													<input type="hidden" name="score_key" value="'.$cmt_list[$y]['score_key'].'">
													<input type="submit" name="score_sj" value="評分">
												</form>
											</div>
										</ul>
										';
									}else{
										echo '
										<ul>
											<div class="comment_item">
												<div>'.keyw9.':'.$y.'</div>
												<div>'.keyw10.':'.$cmt_list[$y][7].'</div>
												'.getscore($cmt_list[$y][2]).'<hr>
												<div><h2>'.keyw13.':'.$info[0].'</h2></div>
												<div>'.keyw14.'：'.$info[1].'</div>
												<hr>
												<form class="score_item" action="" method="POST">
													<li>評分意見：</li>
													<li>
														<span class="score_title">1</span>
														<span class="score_title">2</span>
														<span class="score_title">3</span>
														<span class="score_title">4</span>
														<span class="score_title">5</span>
													</li>
													<li>
														<input type="radio" name="score" value="1" checked>
														<input type="radio" name="score" value="2">
														<input type="radio" name="score" value="3">
														<input type="radio" name="score" value="4">
														<input type="radio" name="score" value="5">
													</li>
													<input type="hidden" name="pj_token" value="'.$pj_token.'">
													<input type="hidden" name="score_key" value="'.$cmt_list[$y]['score_key'].'">
													<input type="submit" name="score_sj" value="評分">
												</form>
											</div>
										</ul>
										';
									}
								}
								if(count($cmt_list) === 0){
									echo '尚無意見';
								}
								if($sj_list[$i][5] === "true"){
									echo '
										<form action="" method="POST" enctype="multipart/form-data">
											<input type="file" name="file" onchange="filetype(this,'.$i.');">
											<input type="text" name="title" required>
											<input type="text" name="text" required>
											<input type="hidden" id="file'.$i.'" name="dataurl">
											<input type="hidden" name="th_key" value="'.$sj_list[$i][2].'">
											<input type="hidden" name="pj_token" value="'.$pj_token.'">
											<input type="submit" name="cmt" value="發表意見">
										</form>
									';
								}
								echo'
							</ul>
							';
						}
						echo '
						</div>
					</ul>
					';
				break;
				default: 
					echo '<h1>專案列表</h1>';
					for($i=1;$i<=count($pj_list);$i++){
						$result = pj_member([sess('member'),$pj_list[$i]]);
						if($result[0]){
							echo '
							<div>
								<div>
									<a href="/lite/index.php?page=view_pj&token='.$pj_list[$i][1].'">'.$pj_list[$i][2].'</a>
								</div>
							</div>
							';
						}
					}
					
				break;
			}
		}
	}else{
		if(@post('auth')!=null){
			result(auth([post('username'),post('password')]),['登入成功','登入失敗', 1, '/lite/index.php']);
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