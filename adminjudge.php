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
		if($_GET["action"] == "fail") $tmpstatus = 0 - $CurrentStatus;
		if($_GET["action"] == "ok") $tmpstatus = $CurrentStatus + 1;
		if($_GET["action"] == "reset") $tmpstatus = $CurrentStatus;
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
				<div class="span9">
					<legend>结果筛选</legend>
					<div class="alert alert-block alert-info">
						<h4>当前进度： 第<?php echo $CurrentStatus; ?>轮面试</h4>
						<br />
						<div class="progress progress-striped active">
							<div class="bar" style="width: <?php echo $CurrentStatus / 4 * 100;?>%;"></div>
						</div>
						<div class="row-fluid">
							<div class="span4">
								<a href="adminjudge-a.php" class="btn btn-large btn-block btn-success">自动通过全A评价</a>
							</div>
							<div class="span4">
								<a href="adminjudge-c.php" class="btn btn-large btn-block btn-danger">自动淘汰全C评价</a>
							</div>
							<div class="span4">
								<a href="adminjudge-manual.php" class="btn btn-large btn-block btn-primary">手动决策</a>
							</div>
						</div>
					</div>
					<div class="tabbable">
					  <ul class="nav nav-tabs">
						<li class="active"><a href="#tab1" data-toggle="tab">本轮待决策名单</a></li>
						<li class><a href="#tab2" data-toggle="tab">本轮已通过名单</a></li>
						<li class><a href="#tab3" data-toggle="tab">本轮已淘汰名单</a></li>
					  </ul>
					  <div class="tab-content">
						<div class="tab-pane active" id="tab1">
						  <table class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>编号</th><th>姓名</th><th>专业班级</th><th>电话</th><th>评价1</th><th>评价2</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$result = mysql_query("SELECT DISTINCT profile.profileid, name, class, tel FROM profile, record WHERE profile.profileid = record.profileid AND profile.status = ".$CurrentStatus);
								while($row = mysql_fetch_array($result))
								{
									echo "<tr><td>".$row["profileid"]."</td><td>".$row["name"]."</td><td>".$row["class"]."</td><td>".$row["tel"]."</td><td><strong>";
									$subresult = mysql_query("SELECT * FROM record WHERE profileid = ".$row["profileid"]." AND status = ".$CurrentStatus);
									$judgerow = mysql_fetch_array($subresult);
									echo $grade[$judgerow["grade"]]."</strong>-".$judgerow["judger"]."</td><td><strong>";
									$judgerow = mysql_fetch_array($subresult);
									echo $grade[$judgerow["grade"]]."</strong>-".$judgerow["judger"]."</td></tr>\n";
								}
								?>
							</tbody>
						  </table>
						</div>
						<div class="tab-pane" id="tab2">
						  <table class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>编号</th><th>姓名</th><th>专业班级</th><th>电话</th><th>评价1</th><th>评价2</th><th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$result = mysql_query("SELECT DISTINCT profile.profileid, name, class, tel FROM profile, record WHERE profile.profileid = record.profileid AND profile.status > ".$CurrentStatus);
								while($row = mysql_fetch_array($result))
								{
									echo "<tr><td>".$row["profileid"]."</td><td>".$row["name"]."</td><td>".$row["class"]."</td><td>".$row["tel"]."</td><td><strong>";
									$subresult = mysql_query("SELECT * FROM record WHERE profileid = ".$row["profileid"]." AND status = ".$CurrentStatus);
									$judgerow = mysql_fetch_array($subresult);
									echo $grade[$judgerow["grade"]]."</strong>-".$judgerow["judger"]."</td><td><strong>";
									$judgerow = mysql_fetch_array($subresult);
									echo $grade[$judgerow["grade"]]."</strong>-".$judgerow["judger"]."</td><td><a href=\"adminjudge.php?id=".$row["profileid"]."&action=fail\">淘汰</a> | <a href=\"adminjudge.php?id=".$row["profileid"]."&action=reset\">撤销</a></td></tr>\n";
								}
								?>
							</tbody>
						  </table>
						</div>
						<div class="tab-pane" id="tab3">
						  <table class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>编号</th><th>姓名</th><th>专业班级</th><th>电话</th><th>评价1</th><th>评价2</th><th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$result = mysql_query("SELECT DISTINCT profile.profileid, name, class, tel FROM profile, record WHERE profile.profileid = record.profileid AND profile.status = -".$CurrentStatus);
								while($row = mysql_fetch_array($result))
								{
									echo "<tr><td>".$row["profileid"]."</td><td>".$row["name"]."</td><td>".$row["class"]."</td><td>".$row["tel"]."</td><td><strong>";
									$subresult = mysql_query("SELECT * FROM record WHERE profileid = ".$row["profileid"]." AND status = ".$CurrentStatus);
									$judgerow = mysql_fetch_array($subresult);
									echo $grade[$judgerow["grade"]]."</strong>-".$judgerow["judger"]."</td><td><strong>";
									$judgerow = mysql_fetch_array($subresult);
									echo $grade[$judgerow["grade"]]."</strong>-".$judgerow["judger"]."</td><td><a href=\"adminjudge.php?id=".$row["profileid"]."&action=ok\">通过</a> | <a href=\"adminjudge.php?id=".$row["profileid"]."&action=reset\">撤销</a></td></tr>\n";
								}
								?>
							</tbody>
						  </table>
						</div>
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
