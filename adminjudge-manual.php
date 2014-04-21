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
	<?php
	if($_SESSION['judger'] != $adminuser)
	{
		echo "<script>alert(\"对不起，您没有权限进行决策！\"); window.location.href=\"adminindex.php\";</script>";
		exit();
	}
	if($_GET["id"] != "")
	{
		if($_GET["action"] == "ok") $tmpstatus = $CurrentStatus + 1;
		else $tmpstatus = 0 - $CurrentStatus;
		mysql_query("UPDATE profile SET status = ".$tmpstatus." WHERE profileid = ".$_GET["id"]);
	}
	?>
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
								<li>
									<a href="admininterview.php">面试评价</a>
								</li>
								<li class="active">
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
							<li>
								<a href="adminhistory.php"><i class="icon-edit"></i> 评价记录</a>
							</li>
							</li>
							<li class="nav-header">
								决策
							</li>
							<li class="active">
								<a href="adminjudge.php"><i class="icon-white icon-check"></i> 结果筛选</a>
							</li>
							<li class="divider">
							<li>
								<a href="admin2014.php?action=logout"><i class="icon-stop"></i> 注销登录</a>
							</li>
						</ul>
					</div>
				</div>
				<?php
				$result = mysql_query("SELECT profile.profileid, name, class FROM profile, record WHERE profile.profileid = record.profileid AND profile.status = ".$CurrentStatus);
				$basicinfo = mysql_fetch_array($result);
				if ($basicinfo["profileid"] == "")
				{
					echo "<script>alert(\"本轮面试已全部决策完成！\"); window.location.href=\"adminjudge.php\";</script>\n";
					exit();
				}
				?>
				<div class="span9">
					<legend>手动决策</legend>
					<div class="alert alert-block alert-info">
						<div class="row-fluid">
							<h4 class="span8"><?php echo $basicinfo["profileid"]." | ".$basicinfo["name"]." | ".$basicinfo["class"]." | ".$CurrentStatus; ?>轮面试</h4>
							<div class="span2"><a href="adminjudge-manual.php?id=<?php echo $basicinfo["profileid"]."&action=ok";?>" class="btn btn-success btn-block">通 过</a></div>
							<div class="span2"><a href="adminjudge-manual.php?id=<?php echo $basicinfo["profileid"]."&action=fail";?>" class="btn btn-danger btn-block">淘 汰</a></div>
						</div>
					</div>
					<div class="row-fluid">
						<?php
						$result = mysql_query("SELECT * FROM record WHERE profileid=".$basicinfo["profileid"]." AND status=".$CurrentStatus);
						$judgeinfo = mysql_fetch_array($result);
						?>
						<div class="span6">
							<h3><?php echo $grade[$judgeinfo["grade"]]." - ".$judgeinfo["judger"];?></h3>
							<ul class="messages">
								<li class="well">
									<p class="message">
										<span class="meta"><em>基础技能：</em></span>
										<p><?php echo $judgeinfo["basic"];?></p>
										<span class="meta"><em>加分技能：</em></span>
										<p><?php echo $judgeinfo["advance"];?></p>
										<span class="meta"><em>总体评价：</em></span>
										<p><?php echo $judgeinfo["judge"];?></p>
									</p>
								</li>
							</ul>
						</div>
						<?php
						$judgeinfo = mysql_fetch_array($result);
						?>
						<div class="span6">
							<h3><?php echo $grade[$judgeinfo["grade"]]." - ".$judgeinfo["judger"];?></h3>
							<ul class="messages">
								<li class="well">
									<p class="message">
										<span class="meta"><em>基础技能：</em></span>
										<p><?php echo $judgeinfo["basic"];?></p>
										<span class="meta"><em>加分技能：</em></span>
										<p><?php echo $judgeinfo["advance"];?></p>
										<span class="meta"><em>总体评价：</em></span>
										<p><?php echo $judgeinfo["judge"];?></p>
									</p>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="js/jquery-1.10.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
	</body>
</html>
