<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
    include_once("function.php");
    include_once("conn.php");
    include_once("filter.php");
    include_once("config.php");

    //$schoolnum = $_POST["schoolnum"];
    //$password = $_POST["password"];

    if(checkid($schoolnum,$password) == -1)
    {
        echo "<script> alert(\"实名验证失败！请输入正确的学号和教务系统密码。\"); history.go(-1); </script>";
        exit();
    }

    $result = mysql_query("SELECT * FROM profile WHERE schoolnum = '".$schoolnum."'");
    if($row = mysql_fetch_array($result))
    {
        $retext = "<script> alert(\"报名编号：".$row["profileid"]."\\n学号：".$row["schoolnum"]."\\n姓名：".$row["name"]."\\n电话：".$row["tel"]."\\n班级：".$row["class"]."\\n状态：";
        $retext = $retext.$status[$row["status"]]."\"); history.go(-1); </script>";
        echo $retext;
    }
    else
    {
        echo "<script> alert(\"系统中没有您的报名记录，请在上方进行网上报名！\"); history.go(-1); </script>";
    }
?>
</html>
