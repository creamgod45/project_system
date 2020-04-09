<?php 
	
	date_default_timezone_set("Asia/Taipei");
	session_start();

    /**
     * 訂單系統 order system v1.2.0
     * @author creamgod45 <creamgod45@yun.sk>
     * @copyright 2020 無限二維條碼取餐APP
     * @since 1.0.0
     * @version 1.2.0
     */
	class project_system{
		
		// 資料庫連接
		function __construct(){
			$mysqli = mysqli_connect("localhost","root","","project_system");
			if($mysqli->connect_error){
				die("mysql error:".$mysqli->connect_error);
				exit;
			}
			@mysqli_set_charset($mysqli, "utf8");
			return $mysqli;
		}
		
		function token(){
			return md5(time());
		}
		
		// 管理員登入
		function admin_auth($username, $password){
			if( $username === "admin" and $password === "1234"){
				$_SESSION['admin_key']=md5(time());
				return true;
			}else{
				return false;
			}
		}
		
		// 登入
		function auth($username,$password){
			$conn = $this->__construct();
			$sql = "SELECT * FROM `member` WHERE `username` = '$username' and `password` = '$password'";
			$result = $conn->query($sql);
			$row = mysqli_fetch_assoc($result);
			if($username === $row['username'] and $password === $row['password']){
				return $row;
			}else{
				return false;
			}
		}

		function findmember($key,$str){
			$conn = $this->__construct();
			$sql = "SELECT * FROM `member` WHERE `$key`='$str'";
			$result = $conn->query($sql);
			$row = mysqli_fetch_assoc($result);
			return $row;
		}
		
		function create_member($option){
			$conn = $this->__construct();
			$access_token = $this->token();
			$name = $option[0];
			$username = $option[1];
			$password = $option[2];
			$time = date("Y-m-d H:i:s");
			$sql = "INSERT INTO `member`(`access_token`, `name`, `username`, `password`, `created_time`) 
			                     VALUES ('$access_token','$name','$username','$password','$time')";
			if($conn->query($sql)){
				return true;
			}else{
				return false;
			}
		}

		function remove_member($access_token){
			$conn =  $this->__construct();
			$sql = "DELETE FROM `member` WHERE `access_token` = '$access_token'";
			$query = $conn->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		function edit_member($option){
			$conn =  $this->__construct();
			$access_token = $option[0];
			$name = $option[1];
			$username = $option[2];
			$password = $option[3];
			$sql = "UPDATE `member` SET `name`='$name',`username`='$username',`password`='$password' WHERE `access_token` = '$access_token'";
			$query = $conn->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}
		
		function get_member(){
			$conn = $this->__construct();
			$sql = "SELECT * FROM `member`";
			$result = $conn->query($sql);
			$x = 1;
			$object = [];
			while($row = mysqli_fetch_assoc($result)){
				$object[$x] = $row;
				unset($row);
				$x++;
			}
			return $object;
		}
		
		function get_once_member($access_token){
			$conn = $this->__construct();
			$sql = "SELECT * FROM `member` WHERE `access_token` = '$access_token'";
			$result = $conn->query($sql);
			$x = 1;
			$object = [];
			while($row = mysqli_fetch_assoc($result)){
				$object[$x] = $row;
				unset($row);
				$x++;
			}
			return $object;
		}
		
		// 識別管理員
		function is_adminstrator($admin){
			if($admin){
				return true;
			}else{
				return false;
			}
		}
		
		// 識別會員
		function is_member($member){
			$conn = $this->__construct();
			$access_token = $member['access_token'];
			$sql = "SELECT `access_token` FROM `member` WHERE `access_token` = '$access_token'";
			$result = $conn->query($sql);
			$row = mysqli_fetch_row($result);
            if($member['access_token'] === $row[0] and $row[0] != ""){
                return true;
            }else{
                return false;
            }
		}

		//============================ PROJECT ============================//

		function createproject($option){
			$conn = $this->__construct();
			$pj_title = $option[0];
			$pj_content = $option[1];
			$pj_token = $this->token();
			$pj_member = "";
			$time = date('Y-m-d H-i-s');
			$sj_object = json_decode($option[2], true);
			$sql = "INSERT INTO `project`(`project_token`, `project_title`, `project_content`, `project_member`, `created_time`) 
								  VALUES ('$pj_token'    , '$pj_title'    , '$pj_content'    , ''    , '$time')";
			$query = $conn->query($sql);
			if($query){
				for ($i=1; $i <= count($sj_object); $i++) { 
					$sj_title = $sj_object[$i]['pjt_name'];
					$sj_content = $sj_object[$i]['pjt_dec'];
					$th_key = $i;
					$sql = "INSERT INTO `subject`(`project_token`, `theme_key`, `subject_title`, `subject_content`, `subject_enable`, `created_time`) 
										  VALUES ('$pj_token'    , '$th_key'  , '$sj_title'    , '$sj_content'    , 'true'          , '$time')";
					$query = $conn->query($sql);
				}
				if($query){
					return true;
				}else{
					return $conn->error;
				}
			}else{
				return $conn->error;
			}
		}

		function setproject($option){
			$conn = $this->__construct();
			$pj_token = $option[0];
			$pj_title = $option[1];
			$pj_content = $option[2];
			$sj_object = $option[3];
			$time = date('Y-m-d H-i-s');
			$sql = "UPDATE `project` SET `project_title`='$pj_title',`project_content`='$pj_content' WHERE `project_token`='$pj_token'";
			$query = $conn->query($sql);
			if($query){				
				$sql = "SELECT * FROM `subject` WHERE `project_token`='$pj_token'";
				$result = $conn->query($sql);
				$subject_num = mysqli_num_rows($result);
				$query = [];
				for ($i=1; $i <= 10; $i++) {
					$sql = "DELETE FROM `subject` WHERE `theme_key` = '$i' AND `project_token` = '$pj_token'";
					$conn->query($sql);
				}
				for ($i=1; $i <= count($sj_object); $i++) { 
					$sj_title = $sj_object[$i]['pjt_name'];
					$sj_content = $sj_object[$i]['pjt_dec'];
					$sql = "INSERT INTO `subject`(`project_token`, `theme_key`, `subject_title`, `subject_content`, `subject_enable`, `created_time`) 
										  VALUES ('$pj_token'    , '$i'       , '$sj_title'    , '$sj_content'    , 'true'          , '$time')"; 
					$query = $conn->query($sql);
					echo $query;
				}
				return true;
			}else{
				return $conn->error;
			}
		}

		function deleteproject($token){
			$conn = $this->__construct();
			$sql = "DELETE FROM `project` WHERE `project_token`='$token'";
			$query = $conn->query($sql);
			if($query){
				$sql = "DELETE FROM `subject` WHERE `project_token` = '$pj_token'";
				$query = $conn->query($sql);
				if($query){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		function projectmember($member, $project){
			$name = $member['name'];
			$member = $project['project_member'];
			$object = [];
			$tmp1 = explode('/',$member);
			for ($i=1; $i <=count($tmp1)-1; $i++) { 
				$tmp2 = explode(':',$tmp1[$i]);
				$r_name = $tmp2[0];
				$r_leader = $tmp2[1];
				if($name === $r_name){
					return [true, $r_leader];
				}
			}
			return [false, 0];
		}
		
		function getproject($token){
			$conn = $this->__construct();
			$sql = "SELECT * FROM `project` WHERE `project_token` = '$token'";
			$result = $conn->query($sql);
			$row = mysqli_fetch_assoc($result);
			return $row;
		}
		

		function getproject_arr(){
			$conn = $this->__construct();
			$sql = "SELECT * FROM `project`";
			$result = $conn->query($sql);
			$x = 1;
			$object = [];
			while($row = mysqli_fetch_assoc($result)){
				$object[$x] = $row;
				unset($row);
				$x++;
			}
			return $object;
		}

		function setprojectmember($access_token, $option){
			$conn = $this->__construct();
			$value = $option;
			$sql = "UPDATE `project` SET `project_member`='$value' WHERE `project_token`='$access_token'";
			$query = $conn->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}
		function role_check($value){
			if($value==1){
				return '組長';
			}else{
				return '組員';
			}
		}

		function checkmember($str){
			if($str==""){
				return '沒有指派任何組員';
			} else {
				$string = "<ul style='margin:0;list-style: cjk-ideographic;'>";
				$tmp=[];
				$row = explode('/',$str);
				for($i=1;$i<=count($row)-1;$i++){
					$tmp[$i] = explode(':',$row[$i]);
					$string .= '<li>'.$tmp[$i][0]."&nbsp;".$this->role_check($tmp[$i][1])."</li>";
				}
				return $string."</ul>";
			}
		}

		function checkmembers($str,$token){
			if($str==""){
				return '沒有指派任何組員';
			} else {
				$string = "<ul style='margin:0;list-style: cjk-ideographic;'>";
				$tmp=[];
				$row = explode('/',$str);
				for($i=1;$i<=count($row)-1;$i++){
					$tmp[$i] = explode(':',$row[$i]);
					$string .= '<li><form style="display:inline;" action="" method="POST">'.$tmp[$i][0]."&nbsp;".$this->role_check($tmp[$i][1])."<input type=\"hidden\" name='name' value='".$tmp[$i][0]."'><input type=\"hidden\" name='token' value='$token'><input type='hidden' name='member' value='$str'><input type='submit' name='aprojectmember' value='刪除成員'></form></li>";
				}
				return $string."</ul>";
			}
		}

		function getsubject($token){
			$conn = $this->__construct();
			$sql = "SELECT * FROM `subject` WHERE `project_token`='$token' ORDER BY `subject`.`theme_key` ASC";
			$result = $conn->query($sql);
			$object = [];
			$x=1;
			while($row =mysqli_fetch_assoc($result)){
				$object[$x]=$row;
				$x++;
			}
			return $object;
		}

		function setsubject($option){
			$conn = $this->__construct();
			$th_key = $option[0];
			$pj_token = $option[1];
			$item = $this->getsubject($pj_token);
			$boolean = $item[$th_key]['subject_enable'];
			switch ($boolean) {
				case "true":
					$boolean = "false";
					break;
				
				default:
					$boolean = "true";
					break;
			}
			$sql = "UPDATE `subject` SET `subject_enable`='$boolean' WHERE `theme_key`='$th_key' AND `project_token` = '$pj_token'";
			$conn->query($sql);
			return true;
		}

		//============================ comment ============================//

		function addcomment($option){
			$conn = $this->__construct();
			$access_token = $option[0];
			$type = $option[1];
			$data = $option[2];
			$th_key = $option[3];
			$token = $option[4];
			$score_key = md5(time());
			$time = date('Y-m-d H:i:s');
			$sql1 = "INSERT INTO `comment`(`access_token`, `project_token`, `theme_key`, `score_key`, `comment_type`, `comment_content`, `created_time`)VALUES ('$access_token', '$token', '$th_key' , '$score_key', '$type'      , '$data'          , '$time')";
			$query = $conn->query($sql1);
		}

		function getcomment($th_key, $token){
			$conn = $this->__construct();
			$sql = "SELECT * FROM `comment` WHERE `theme_key` = '$th_key' AND `project_token` = '$token'";
			$result = $conn->query($sql);
			$x = 1;
			$object=[];
			while($row=mysqli_fetch_assoc($result)){
				$object[$x] = $row;
				unset($row);
				$x++;
			}
			return $object;
		}

		//============================ score ============================//

		function getscore($score_key){
			$conn = $this->__construct();
			$sql = "SELECT * FROM `score` WHERE `score_key` = '$score_key'";
			$result = $conn->query($sql);
			$x = 1;
			$object=[];
			while($row=mysqli_fetch_assoc($result)){
				$object[$x] = $row;
				unset($row);
				$x++;
			}
			$score = 0;
			$score_list = $object;
			$score_num = count($object);
			unset($object);
			if($score_num){
				for ($i=1; $i <= $score_num; $i++) { 
					$score += $score_list[$i]['score'];
				}
				$score = $score / $score_num;
				return '
				<div>評分：'.$score.'</div>
				<div>已被評價人數：'.$score_num.'</div>
				';
			}else{
				return '
				<div>評分：0</div>
				<div>已被評價人數：0</div>
				';
			}
		}

		function addscore($option){
			$conn = $this->__construct();
			$token = $option[0];
			$key = $option[1];
			$score = $option[2];
			$time = date('Y-m-d H:i:s');
			$sql = "INSERT INTO `score`(`access_token`, `score_key`, `score` , `created_time`) 
								VALUES ('$token'      , '$key'     , '$score', '$time')";
			$conn->query($sql);
			return true;
		}

		// 資料庫斷開連接
		function __destruct(){
			$conn = $this->__construct();
			$conn->close();
		}
	}
?>