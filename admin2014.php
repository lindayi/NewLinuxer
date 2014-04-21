<?php
	include_once("config.php");
	$lifeTime = 0.5 * 3600; 
	session_set_cookie_params($lifeTime); 
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>2014纳新系统 - 管理登陆</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="css/site.css" rel="stylesheet">
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div id="login-page" class="container">
		<?php
			if($_GET['action'] == "logout"){
		                unset($_SESSION['judger']);
                                echo "<div class=\"alert alert-info\">\n";
                                echo "  <strong>提示！</strong> 注销成功。请在下方重新登录。\n";
                                echo "</div>\n";

			}
			if(isset($_SESSION['judger']))
                        {
                                echo "<div class=\"alert alert-info\">\n";
                                echo "  <strong>提示！</strong> ".$_SESSION['judger']." 已登录系统。<a href=\"adminindex.php\">进入</a> | <a href=\"admin2014.php?action=logout\">注销</a>\n";
                                echo "</div>\n";
                        }

			if($_POST["password"] != "" && $_POST["password"] != $Admin_Password && $_POST["judger"] != $adminuser)
		        {
                		echo "<div class=\"alert\">\n";
		                echo "  <strong>警告！</strong> 密码错误。请检查你的输入。\n";
                		echo "</div>\n";
        		}
			if($_POST["judger"] == $adminuser && $_POST["password"] != $adminpass)
			{
				echo "<div class=\"alert\">\n";
                                echo "  <strong>警告！</strong> 密码错误。请检查你的输入。\n";
                                echo "</div>\n";
			}
			if($_POST["password"] == $Admin_Password && $_POST["judger"] != $adminuser)
			{
				$_SESSION['judger'] = $_POST["judger"];
				echo "<script>window.location.href = 'adminindex.php';</script>";
			}
			if($_POST["judger"] == $adminuser && $_POST["password"] == $adminpass)
			{
				$_SESSION['judger'] = $_POST["judger"];
                                echo "<script>window.location.href = 'adminindex.php';</script>";
			}
		?>

			<form id="login-form" class="well " action="admin2014.php" method="post">
				<input name="judger" type="text" class="input-xlarge" placeholder="面试官" required /> <br />
				<input name="password" type="password" class="input-xlarge" placeholder="密码"  required /> <br />
				<button type="submit" class="btn btn-block btn-large btn-primary">登陆</button>
			</form>	
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
	</body>
</html>
