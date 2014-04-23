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
							<li class="active">
								<a href="admininterview.php"><i class="icon-white icon-pencil"></i> 面试评价</a>
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
				<?php
					if($_GET["profileid"] != "")
					{
						$result = mysql_query("SELECT * FROM record WHERE judger = '".$_GET["judger"]."' AND profileid = '".$_GET["profileid"]."' AND status = '".$_GET["status"]."'");
						$row = mysql_fetch_array($result);
						if ($row["profileid"] == "")
						{
							mysql_query("INSERT INTO record (profileid, basic, advance, judge, grade, judger, status) VALUES ('".$_GET["profileid"]."', '".$_GET["basic"]."', '".$_GET["advance"]."', '".$_GET["judge"]."', '".$_GET["grade"]."', '".$_GET["judger"]."', '".$_GET["status"]."')");
							echo "<div class=\"alert alert-info\">\n
									<strong>提示！</strong> 评价保存成功，请输入下一个面试者的编号。\n
								  </div>\n";
						}
						else
						{
							mysql_query("UPDATE record SET profileid = '".$_GET["profileid"]."', basic = '".$_GET["basic"]."', advance = '".$_GET["advance"]."', judge = '".$_GET["judge"]."', grade = '".$_GET["grade"]."', judger = '".$_GET["judger"]."', status = '".$_GET["status"]."' WHERE profileid = '".$_GET["profileid"]."' AND status = '".$_GET["status"]."' AND judger = '".$_GET["judger"]."'");
							echo "<div class=\"alert\">\n
									<strong>警告！</strong> 您曾对此人本轮做出评价，新提交评价将覆盖原评价。\n
								  </div>\n";
						}
					}
					if($_POST["profileid"] == "")
					{
						echo "<form id=\"edit-profile\" class=\"form-horizontal\" action=\"admininterview.php\" method=\"post\">\n";
						echo "	<fieldset>\n";
						echo "	<legend>面试评价</legend>\n";
						echo "	<div class=\"control-group\">\n";
						echo "		<label class=\"control-label\" for=\"profileid\">编号：</label>\n";
						echo "		<div class=\"controls\">\n";
						echo "			<input type=\"text\" class=\"input-xlarge\" name =\"profileid\" id=\"profileid\" value=\"\" required />\n";
						echo "			<p class=\"help-block\">请输入当前面试者编号。</p>\n";
						echo "		</div>\n";
						echo "	</div>\n";
						echo "	<div class=\"form-actions\">\n";
						echo "		<button type=\"submit\" class=\"btn btn-primary\">开始面试</button>\n";
						echo "	</div>\n";
						echo "	</fieldset>\n";
						echo "</form>\n";
					}
					else
					{
						$result = mysql_query("SELECT * FROM profile WHERE profileid = ".$_POST["profileid"]);
						$row = mysql_fetch_array($result);
						if ($row["profileid"] == "")
						{
							echo "<script>alert(\"系统中无此编号记录！\"); window.location.href = \"admininterview.php\";</script>";
							exit();
						}
						echo "<ul class=\"breadcrumb\">\n
							<li>NO.".$row["profileid"]." <span class=\"divider\">|</span></li>\n
							<li>".$row["schoolnum"]." <span class=\"divider\">|</span></li>\n
							<li>".$row["name"]." <span class=\"divider\">|</span></li>\n
							<li>".$row["class"]." <span class=\"divider\">|</span></li>\n
							<li>".$row["tel"]." <span class=\"divider\">|</span></li>\n
							<li> <div id=\"timediv\"></div></li>\n
						</ul>\n
						<div class=\"row\">\n
							<div class=\"span5\">\n
								<form id=\"edit-profile\" class=\"form-horizontal\" action=\"admininterview.php\" method=\"get\">\n
									<fieldset>\n
										<legend>面试评价</legend>\n
										<input type=\"hidden\" name=\"profileid\" value=\"".$row["profileid"]."\" />
										<input type=\"hidden\" name=\"judger\" value=\"".$_SESSION["judger"]."\" />
										<input type=\"hidden\" name=\"status\" value=\"".$row["status"]."\" />
										<input type=\"hidden\" name=\"action\" value=\"save\" />
										<div class=\"control-group\">\n
											<label class=\"control-label\" for=\"basic\">基本技能</label>\n
											<div class=\"controls\">\n
												<textarea class=\"input-xlarge\" id=\"basic\" name=\"basic\" rows=\"3\" placeholder=\"C语言，计算机基础等\" required /></textarea>\n
											</div>\n
										</div>\n
										<div class=\"control-group\">\n
											<label class=\"control-label\" for=\"advance\">加分技能</label>\n
											<div class=\"controls\">\n
												<textarea class=\"input-xlarge\" id=\"advance\" name=\"advance\" rows=\"3\" placeholder=\"数据结构，算法，Linux等\" required /></textarea>\n
											</div>\n
										</div>\n
										<div class=\"control-group\">\n
											<label class=\"control-label\" for=\"judge\">总体评价</label>\n
											<div class=\"controls\">\n
												<textarea class=\"input-xlarge\" id=\"judge\" name=\"judge\" rows=\"3\" placeholder=\"总体水平评价，面试官主观看法等\" required /></textarea>\n
											</div>\n
										</div>\n
										<div class=\"control-group\">\n
											<label class=\"control-label\" for=\"grade\">等级</label>\n
											<div class=\"controls\">\n
												<select class=\"span3\" name=\"grade\">\n
													<option value=\"5\">S  — 非常棒，极力推荐</option>\n
													<option value=\"4\">A+ — 很不错，通过</option>\n
													<option value=\"3\">A- — 还可以，通过</option>\n
													<option value=\"2\">B  — 一般，待定</option>\n
													<option value=\"1\">C  — 较差，淘汰</option>\n
												</select>\n
											</div>\n
										</div>\n
										<div class=\"form-actions\">\n
											<button type=\"submit\" class=\"btn btn-primary\">保存评价</button>\n
											<a class=\"btn\" href=\"admininterview.php\">更换面试对象</a>\n
										</div>\n
									</fieldset>\n
								</form>\n
							</div>\n
							<div class=\"span4\">\n
								<legend>面试记录</legend>\n";
						$result = mysql_query("SELECT * FROM record WHERE profileid = ".$row["profileid"]." AND status < ".$row["status"]);
						while ($rowrecord = mysql_fetch_array($result))
						{
							echo"	<ul class=\"messages\">\n
										<li class=\"well\">\n
											<p class=\"message\">\n
												基础技能：".$rowrecord["basic"]."<br />\n
												加分技能：".$rowrecord["advance"]."<br />\n
												总体评价：".$rowrecord["judge"]."<br />\n
											</p>\n
											<span class=\"meta\">环节 <em>".$rowrecord["status"]."轮面试</em> 等级 <em>".$grade[$rowrecord["grade"]]."</em> 面试官 <em>".$rowrecord["judger"]."</em></span>\n
										</li>\n
									</ul>\n";
						}
							echo"	</div>\n
							</div>\n";
					}
				?>
				</div>
			</div>
		</div>
		<script language="javascript">
			var second=0;
			var minute=0;
			var hour=0;
			window.setTimeout("interval();",1000);
			function interval()
			{
				second++;
				if(second==60)
				{
				second=0;minute+=1;
				}
				if(minute==60)
				{
				minute=0;hour+=1;
				}
				var obj = document.getElementById("timediv");
				obj.innerHTML = "面试已持续："+hour+"时"+minute+"分"+second+"秒";
				window.setTimeout("interval();",1000);
			}
		</script>
		<script src="js/jquery-1.10.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
	</body>
</html>
