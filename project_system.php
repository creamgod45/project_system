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
			return md5(time()/2);
		}
		
		// 管理員登入
		function admin_auth($username, $password){
			if( $username === "admin" and $password === "1234"){
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
		
		// 資料庫斷開連接
		function __destruct(){
			$conn = $this->__construct();
			$conn->close();
		}
	}
?>