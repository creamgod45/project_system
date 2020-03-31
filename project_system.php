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
			$mysqli = mysqli_connect("localhost","admin","1234","project_system");
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
			$row = mysqli_fetch_array($result);
			foreach($row as $key => $value){
				if(is_numeric($key)){
					unset($row[$key]);
				}
			}
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
		
		function get_member($access_token){
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
			$th_key = time();
			$sj_object = json_decode($option[2], true);
			$sql = "INSERT INTO `project`(`project_token`, `project_title`, `project_content`, `project_member`, `created_time`) 
								  VALUES ('$pj_token'    , '$pj_title'    , '$pj_content'    , '$pj_member'    , '$time')";
			$query = $conn->query($sql);
			if($query){
				for ($i=1; $i <= count($sj_object); $i++) { 
					$sj_title = $sj_object[$i]['pjt_name'];
					$sj_content = $sj_object[$i]['pjt_dec'];
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
			$access_token = $option[0];
			$value = $option[1];
			$sql = "UPDATE `project` SET `project_member`='$value' WHERE `project_token`='$access_token'";
			$query = $conn->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		function checkmember($str){
			if($str){

			}else {
				return '沒有指派任何會員';
			}
		}
		
		// 資料庫斷開連接
		function __destruct(){
			$conn = $this->__construct();
			$conn->close();
		}
	}
?>