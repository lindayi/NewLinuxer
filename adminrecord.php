<?php

	include_once( "conn.php" );
	include_once( "config.php" );

	$pro_id = $_POST["Id_range"];
	$major = $_POST["Major"];
	$audition = $_POST["Audition"];


	//setcookie( "MAJOR",$major, time()+1800 );
	//setcookie( "PRO_ID",$pro_id, time()+1800 );
	//setcookie( "AUDITION",$audition, time()+1800 );

	//专业查询SQL
	if( $major == "" )
		$major = "like '%'";
	if( $major == "rj" )
		$major = "like '软件%'";
	if( $major == "wl" )
		$major = "like '网络%'";
	if( $major == "jk" )
		$major = "like '计科%'";
	if( $major == "ot" )
		$major = "not like '软件%' and class not like '网络%' and class not like '计科%'";

	//面试场次查询
	if( $audition == "" )
		$audition = "like '%'";
	if( $audition == "fir" )
		$audition = "= '1'";
	if( $audition == "sec" )
		$audition = "= '2'";
	if( $audition == "the" )
		$audition = "= '3'";

	//面试id查询
	if( $pro_id != "" && $pro_id != "1010" )
		$pro_id = ">= ".$pro_id." and profileid <= ".($pro_id + 19);
	if( $pro_id == "" )
		$pro_id = "like '%'";
	if( $pro_id == "1010" )
		$pro_id = ">1010 and profileid <= 1400 ";


	session_start();
	if(!isset($_SESSION['judger'])){
		header("Location:admin2014.php");
		exit();
	}


//全部报名总人数
//	$sql = "SELECT count(*) FROM profile ";
//	$Total_num = mysql_query( $sql, $conn);
//	$Total_num = mysql_fetch_array( $Total_num );

//最后一个人profileid
	$sql = "select profileid from profile order by profileid desc limit 0,1";
	$last_num = mysql_query( $sql, $conn );
	$last_num = mysql_fetch_array( $last_num );
	$last_num = $last_num[0];

	$count = (($last_num - 1380) - (( $last_num - 1380 ) % 20 )) / 20;
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
							<li>
								<a href="adminindex.php"><i class="icon-home"></i> 管理面板</a>
							</li>
							<li class="active">
								<a href="adminrecord.php"><i class="icon-th-list"></i> 报名记录
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
<!--				<div class="hero-unit">
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
-->
					<div class="well summary">
						<form action="adminrecord.php" method="post"> 
						<ul>
							<li>
								<select id="Id_range" name="Id_range" class="span2" autofocus>
									<option value="">编号范围</option>
									<?php
										$i = 0;
										$Low_value = 0;
										$Hig_value = 0;
										
										// $count = 0
										if( $last_num < 1400 )
											echo "<option value='1010'>1010-".$last_num."</option>";
										// $count >= 1
										// $last_num >= 1400
										else
										{
											echo "<option value='1010'>1010-1400</option>";
											while ( $i < ($count-1) )
											{
												$Low_value = 1401+($i * 20 );
												$Hig_value = $Low_value + 19;
												echo "<option value=".$Low_value.">".$Low_value."-".$Hig_value."</option>";
												$i += 1;
											}
											$Low_value = $Hig_value+1;
											echo "<option value=".$Low_value.">".$Low_value."-".$last_num."</option>";
										}

									?>
								</select>
							</li>
							<li>
								<select id="Major" name="Major" class="span2">
									<option value="">专业班级</option>
									<option value='rj'<?php if($major=="like '软件%'") echo " selected";?>>软件工程</option>
									<option value='wl'<?php if($major=="like '网络%'") echo " selected";?>>网络工程</option>
									<option value='jk'<?php if($major=="like '计科%'") echo " selected";?>>计算机科学与技术</option>
									<option value='ot'<?php if($major=="not like '软件%' and class not like '网络%' and class not like '计科%'" ) echo " selected";?>>其他专业</option>
								</select>
							</li>
							<li>
								<select id="Audition" name="Audition" class="span2">
									<option value="">面试场次</option>
									<option value='fir'<?php if($audition=="= '1'") echo " selected";?>><?php echo $status[1]; ?></option>
									<option value='sec'<?php if($audition=="= '2'") echo " selected";?>><?php echo $status[2]; ?></option>
									<option value='the'<?php if($audition=="= '3'") echo " selected";?>><?php echo $status[3]; ?></option>
								</select>
							</li>
							<li class="last">
								<button type="submit" class="btn btn-primary">查询</button>
							</li>
						</ul></form>
					</div>
					<h2>
						共有 
						<?php
                                                $result = mysql_query("select count(*) from profile where class ".$major." and status ".$audition." and profileid ".$pro_id." order by profileid");
                                                $row = mysql_fetch_array($result);
                                                echo $row[0];
                                                ?>
						 个查询结果
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
							//构造sql
							$sql = "select * from profile where class ".$major." and status ".$audition." and profileid ".$pro_id." order by profileid";
							$result = mysql_query( $sql, $conn );
							while($row = mysql_fetch_array($result))
							{
								
								echo "<tr><td>".$row["profileid"]."</td><td>".$row["schoolnum"]."</td><td>".$row["name"]."</td><td>".$row["class"]."</td><td>".$row["tel"]."</td><td>".$status[$row["status"]]."</td></tr>\n";
							}
						?>
						</tbody>
					</table>
					<ul class="pager">
<!--						<li class="next">
							<a href="adminrecord.php">查看更多 &rarr;</a>
						</li>
-->
					</ul>
				</div>
			</div>
		</div>
		<script src="js/jquery-1.10.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/site.js"></script>
	</body>
</html>
