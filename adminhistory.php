<?php
	session_start();
	if(!isset($_SESSION['judger'])){
		header("Location:admin2014.php");
		exit();
	}
	include_once("conn.php");
	include_once("config.php");
?>
<!DOCTYPE html>
<html> 
	<head>
		<meta charset="utf-8">
		<title>管理后台 - 2014纳新系统</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="css/site.css" rel="stylesheet">
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div class="container">
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="#">Xiyou Linux Group</a>
						<div class="nav-collapse">
							<ul class="nav">
								<li>
									<a href="adminindex.php">管理面板</a>
								</li>
								<li class="active">
									<a href="admininterview.php">面试评价</a>
								</li>
								<li>
									<a href="adminjudge.php">结果筛选</a>
								</li>
							</ul>
							<ul class="nav pull-right">
								<li>
									<a href="adminhistory.php"><?php echo $_SESSION["judger"];?></a>
								</li>
								<li>
									<a href="admin2014.php?action=logout">注销登录</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="padding-top:40px">
				<div class="span3">
					<div class="well" style="padding: 8px 0;">
						<ul class="nav nav-list">
							<li class="nav-header">
								概览
							</li>
							<li>
								<a href="adminindex.php"><i class="icon-home"></i> 管理面板</a>
							</li>
							<li>
								<a href="adminrecord.php"><i class="icon-th-list"></i> 报名记录
								<span class="badge badge-info">
                                                                <?php
                                                                        $result = mysql_query("SELECT COUNT(*) FROM profile");
                                                                        $row = mysql_fetch_array($result);
                                                                        echo $row[0];
                                                                ?>
                                                                </span>
                                                                </a>
							</li>
							<li class="nav-header">
								面试
							</li>
							<li>
								<a href="admininterview.php"><i class="icon-pencil"></i> 面试评价</a>
							</li>
							<li class="active">
								<a href="adminhistory.php"><i class="icon-white icon-edit"></i> 评价记录</a>
							</li>
							</li>
							<li class="nav-header">
								决策
							</li>
							<li>
								<a href="adminjudge.php"><i class="icon-check"></i> 结果筛选</a>
							</li>
							<li class="divider">
							<li>
								<a href="admin2014.php?action=logout"><i class="icon-stop"></i> 注销登录</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="span9">
					<legend>评价记录</legend>
		<?php
		$result = mysql_query("SELECT profile.profileid, name, class, record.status, grade, basic, advance, judge, time FROM record, profile WHERE judger = '".$_SESSION["judger"]."' AND record.profileid = profile.profileid ORDER BY recordid DESC");
		while($row = mysql_fetch_array($result))
		{
			echo "<div class=\"row\">\n
				<div class=\"span2\">\n
					<ul class=\"nav nav-list\">\n
						<li class=\"nav-header\">\n
							报名信息\n
						</li>\n
						<li>".$row["profileid"]." | <strong>".$row["name"]."</strong></li>\n
						<li>班级：".$row["class"]."</li>\n
						<li class=\"nav-header\">\n
							面试信息\n
						</li>\n
						<li>环节：<strong>".$row["status"]."</strong> 轮面试</li>\n
						<li>等级：<strong>".$grade[$row["grade"]]."</strong></li>\n
						<li class=\"nav-header\">时间</li>\n
						<li>".$row["time"]."</li>\n
					</ul>\n
				</div>\n
				<div class=\"span7\">\n
					<ul class=\"messages\">\n
						<li class=\"well\">\n
							<p class=\"message\">\n
								<span class=\"meta\"><em>基础技能：</em></span>\n
								<p>".$row["basic"]."</p>\n
								<span class=\"meta\"><em>加分技能：</em></span>\n
								<p>".$row["advance"]."</p>\n
								<span class=\"meta\"><em>总体评价：</em></span>\n
								<p>".$row["judge"]."</p>\n
							</p>\n
						</li>\n
					</ul>\n
				</div>\n
			</div>\n";
		}
		?>
				</div>
			</div>
		</div>
		<script src="js/jquery-1.10.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
	</body>
</html>
