<?php
	date_default_timezone_set("Asia/Taipei");
	@session_start();

	define("keyw0", "專案討論系統");
	define("keyw1" ,"面相");
	define("keyw2" ,"面相說明");
	define("keyw3" ,"專案名稱");
	define("keyw4" ,"專案說明");
	define("keyw5" ,"意見");
	define("keyw6" ,"評分指標");
	define("keyw7" ,"評分意見");
	define("keyw9" ,"編號");
	define("keyw10" ,"發表時間");
	define("keyw11" ,"評分");
	define("keyw12" ,"已被評價人數");
	define("keyw13" ,"標題");
	define("keyw14" ,"說明");
	define("keyw15" ,"切換意見功能");

	$time = date('Y-m-d H:i:s');

	function conn(){
		$mysqli = mysqli_connect("localhost",'root','','project_system');
		if($mysqli->connect_error){
			die($mysqli->connect_error);
			exit;
		}
		mysqli_set_charset($mysqli,'utf8');
		return $mysqli;
	}

	function token(){
		return md5(time());
	}

	function squery($option){
		$conn = conn();
		switch ($option[0]) {
			case 'get':
				$result = $conn->query($option[1]);
				$row = mysqli_fetch_array($result);
				$conn->close();
				return $row;
			break;
			case 'getlist':
				$result = $conn->query($option[1]);
				$x = 1;
				$object = [];
				while($row = mysqli_fetch_array($result)){
					$object[$x] = $row;
					unset($row);
					$x++;
				}
				$conn->close();
				return $object;
			break;
			case 'run':
				$conn->query($option[1]);
				if($conn->error){
					echo $conn->error;
					$conn->close();
					return false;
				}else{
					$conn->close();
					return true;
				}
			break;
		}
	}

	function result($boolean, $option){
		if($boolean){
			echo "<h1>$option[0]</h1>";
			header('refresh:'.(string)$option[2].';url="'.$option[3].'"');
		}else{
			echo "<h1>$option[1]</h1>";
			header('refresh:'.(string)$option[2].';url="'.$option[3].'"');
		}
	}

	function alert_text($string){
		return "<h1>$string</h1>";
	}
	
	function refresh($option){
		header('refresh:'.(string)$option[0].';url="'.$option[1].'"');
	}

	function post($index){
		return $_POST[$index];
	}

	function get($index){
		return $_GET[$index];
	}

	function sess($index){
		return $_SESSION[$index];
	}

	function v($var){var_dump($var);}

	function obj_e($array){
		$string = "";
		foreach($array as $key => $value){
			if($key===0){
				$string .= $key .":".$value;
			}else{
				$string .= "/" . $key .":".$value;
			}
		}
		unset ($key);
		unset ($value);
		return $string;
	}

	function obj_d($string){
		$array = [];
		$tmp = explode('/',$string);
		for($i=0;$i<=count($tmp)-1;$i++){
			$tmp1 = explode(':',$tmp[$i]);
			$array[$i] = $tmp1;
		}
		return $array;
	}

	function head(){
		return '
		<head>
			<link rel="stylesheet" href="core.css">
			<link rel="stylesheet" href="app.css">
			<script src="core.js"></script>
			<script src="app.js"></script>
			<title>'.keyw0.'</title>
		</head>';
	}

	function findsql($option){
		$sql = "SELECT * FROM `$option[0]` WHERE `$option[1]` = '$option[2]'";
		return squery(['get', $sql]);
	}

	//---------------------------------------- main

	function aauth($array){
		if($array[0]==="admin"&&$array[1]==="1234"){
			$_SESSION['admin'] = true;
			return true;
		}else{
			$_SESSION['admin'] = false;
			return false;
		}
	}

	function auth($array){
		$row = squery(['get', "SELECT * FROM `member` WHERE `username` = '$array[0]' AND `password` = '$array[1]'"]);
		if($array[0] === $row[3] AND $array[1] === $row[4] AND $array[0] != null){
			$_SESSION['member'] = $row;
			return true;
		}else{
			return false;
		}
	}

	function ismember($array){
		$row = squery(['get', "SELECT * FROM `member` WHERE `access_token` = '$array[1]'"]);
		if(is_array($row)){
			return true;
		}else{
			return false;
		}
	}

	function pj_member($option){
		$array = obj_d($option[1][4]);
		for($i=1;$i<=count($array)-1;$i++){
			if($array[$i][0] === $option[0][2]){
				return [true,$array[$i][1]];
			}
		}
	}

	function pj_member_c($string){
		$x=0;
		$str = "";
		$a = obj_d($string);
		for($i=1;$i<=count($a)-1;$i++){
			if($a[$i][1]=="1"){
				$str .= "專案組長：".$a[$i][0]."<br>";
			}else{
				if($x===0){
					$x=1;
					$str .= "專案組員：";
				}
				$str .= $a[$i][0]."<br>";
			}
		}
		return $str;
	}

	function getscore($key){
		$row = squery(['getlist', "SELECT * FROM `score` WHERE `score_key` = '$key'"]);
		$num = count($row);
		$score = 0;
		if($num){
			for($i=1;$i<=$num;$i++){
				$score += $row[$i]['score'];
			}
			$score = $score / $num;
			return '
			<div>'.keyw11.'：'.$score.'</div>
			<div>'.keyw12.'：'.$num.'</div>
			';
		}else{
			return '
			<div>'.keyw11.'：0</div>
			<div>'.keyw12.'：0</div>
			';
		}
	}
	
?>