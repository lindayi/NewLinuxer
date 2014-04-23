<?php

function checkid($username, $password)
{
    $HTTP_REQUEST_HEADER = array(
    "method"=>"POST", 
    "timeout"=>30,
    "Content-Type"=>"application/x-www-form-urlencoded",
    "Referer"=>"http://222.24.19.202/default_ysdx.aspx", //此处修改为正方教务系统免验证码登陆页URL
    "Host"=>"222.24.19.202" //此处修改为正方教务系统服务器IP
    );

    $ch = curl_init();
    $url = "http://222.24.19.202/default_ysdx.aspx";  //此处修改为正方教务系统免验证码登陆页URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $HTTP_REQUEST_HEADER);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "__VIEWSTATE=dDw1MjQ2ODMxNzY7Oz799QJ05KLrvCwm73IGbcfJPI91Aw%3D%3D&TextBox1=".$username."&TextBox2=".$password."&RadioButtonList1=%D1%A7%C9%FA&Button1=++%B5%C7%C2%BC++");     
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookfile);   // 连接断开后保存cookie
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookfile);	// cookie 写入文件
    curl_setopt($ch, CURLOPT_COOKIESESSION, 1); 
    //以下为SSL设置
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);

    //抓取URL并把它传递给浏览器
    $res = curl_exec($ch);

    echo curl_error($ch);

    //关闭cURL资源，并且释放系统资源
    curl_close($ch);
    if(strncmp("<script>window.open", $res, 19) == 0) return 0;
    else return -1;
}

?>
