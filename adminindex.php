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
								<li class="active">
									<a href="adminindex.php">管理面板</a>
								</li>
								<li>
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
							<li class="active">
								<a href="adminindex.php"><i class="icon-white icon-home"></i> 管理面板</a>
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
					<div class="hero-unit">
						<h1>
							您好，<?php echo $_SESSION["judger"];?>
						</h1>
						<p>
							欢迎进入西邮Linux兴趣小组 2014纳新面试系统
						</p>
						<p>
							<a href="admininterview.php" class="btn btn-primary btn-large">开始面试评价</a> <a href="admin2014.php?action=logout" class="btn btn-large">注销登录</a>
						</p>
					</div>
					<div class="well summary">
						<ul>
							<li>
								<a href="adminrecord.php"><span class="count">
								<?php
									echo $row[0];
								?>
								</span> 报名总数</a>
							</li>
							<li>
								<span class="count">
								<?php
									$result = mysql_query("SELECT COUNT(DISTINCT profileid) FROM record WHERE status = 1");
									$row = mysql_fetch_array($result);
									echo $row[0];
								?>
								</span> 一轮已面试
							</li>
							<li>
								<span class="count">
								<?php
									$result = mysql_query("SELECT COUNT(DISTINCT profileid) FROM record WHERE status = 2");
									$row = mysql_fetch_array($result);
									echo $row[0];
								?>
								</span> 二轮已面试
							</li>
							<li class="last">
								<span class="count">
								<?php
									$result = mysql_query("SELECT COUNT(DISTINCT profileid) FROM record WHERE status = 3");
									$row = mysql_fetch_array($result);
									echo $row[0];
								?>
								</span> 三轮已面试
							</li>
						</ul>
					</div>
					<h2>
						最近报名
					</h2>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>
									编号
								</th>
								<th>
									学号
								</th>
								<th>
									姓名
								</th>
								<th>
									专业班级
								</th>
								<th>
									电话
								</th>
								<th>
									状态
								</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$result = mysql_query("SELECT * FROM profile ORDER BY profileid DESC LIMIT 0,10");
							while($row = mysql_fetch_array($result))
							{
								echo "<tr><td>".$row["profileid"]."</td><td>".$row["schoolnum"]."</td><td>".$row["name"]."</td><td>".$row["class"]."</td><td>".$row["tel"]."</td><td>".$status[$row["status"]]."</td></tr>\n";
							}
						?>
						</tbody>
					</table>
					<ul class="pager">
						<li class="next">
							<a href="adminrecord.php">查看更多 &rarr;</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<script src="js/jquery-1.10.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
	</body>
</html>
