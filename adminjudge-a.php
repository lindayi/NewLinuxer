<?php
	session_start();
	if(!isset($_SESSION['judger'])){
		header("Location:admin2014.php");
		exit();
	}
	include_once("conn.php");
	include_once("config.php");

	$result = mysql_query("SELECT DISTINCT profile.profileid, name, class, tel FROM profile, record WHERE profile.profileid = record.profileid AND profile.status = ".$CurrentStatus);
	while($row = mysql_fetch_array($result))
	{
		$subresult = mysql_query("SELECT * FROM record WHERE profileid = ".$row["profileid"]." AND status = ".$CurrentStatus);
		$row2 = mysql_fetch_array($subresult);
		$r1 = $row2["grade"];
		$row2 = mysql_fetch_array($subresult);
		$r2 = $row2["grade"];
		$tmpstatus = $CurrentStatus + 1;
		if (($r1 >= 3)&&($r2 >= 3))
			mysql_query("UPDATE profile SET status = ".$tmpstatus." WHERE profileid = ".$row["profileid"]);
	}
	echo "<script>window.location.href=\"adminjudge.php\"</script>";
?>
