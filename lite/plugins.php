<?php
	function head()
	{
		return '
		<head>
			<link rel="stylesheet" href="jquery-ui.min.css">
			<link rel="stylesheet" href="app.css">
			<script src="jquery.js"></script>
			<script src="jquery-ui.min.js"></script>
			<script src="app.js"></script>
			<title>0.0</title>
		</head>';
	}
	function pdo_runas($sql, $option)
	{
		$pdo = new PDO('mysql:host=localhost;dbname=project;charset=utf8','staff','password');
        $sql=$pdo->prepare($sql);
        return $sql->execute($option);
	}
?>