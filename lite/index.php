<?php
include "plugins.php";
switch(@$_GET['page']){
	case 'view_member':
		echo '檢視成員'.head();
	break;
	case 'add_mebmer':
		echo '新增成員'.head().'';
	break;
	default: 
		echo '<html>'.head().'
		<body>
			<a href="/index.php">首頁</a>
			<a href="/index.php?page=view_member">檢視成員</a>
			<a href="/index.php?page=add_mebmer">新增成員</a>
		</body>
		</html>';
	break;
}
?>