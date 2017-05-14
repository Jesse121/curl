<?php
//访问个人博客
// $curl = curl_init("http://www.jesse131.cn/blog/");
// curl_exec($curl);
// curl_close($curl);

//下载个人博客页面并替换相关字条
// $curlobj = curl_init();
// curl_setopt($curlobj, CURLOPT_URL, "http://www.jesse131.cn/blog/");
// //CURLOPT_URL 需要获取的URL地址
// curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
// //CURLOPT_RETURNTRANSFER 将 curl_exec() 获取的信息以文件流的形式返回，而不是直接输出。
// $output = curl_exec($curlobj);
// echo str_replace("前端", "后端", $output);

//获取深圳天气信息
// $data    = 'theCityCode=深圳&theUserID=';
// $curlobj = curl_init();
// curl_setopt($curlobj, CURLOPT_URL, "http://www.webxml.com.cn/WebServices/WeatherWS.asmx/getWeather");
// curl_setopt($curlobj, CURLOPT_HEADER, 0);
// curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($curlobj, CURLOPT_POST, 1);
// curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data);
// curl_setopt($curlobj, CURLOPT_HTTPHEADER, array(
//     "Content-Type:application/x-www-form-urlencoded",
//     "User-Agent:Fiddler",
//     "Content-Lenght:" . strlen($data),
// ));
// $rtn = curl_exec($curlobj);
// if (!curl_error($curlobj)) {
//     echo '<pre>';
//     echo $rtn;
//     echo '</pre>';
// } else {
//     echo 'Curl error' . curl_error($curlobj);
// }
// curl_close($curlobj);

/*
 *  实例描述：登录慕课网并下载个人空间页面
 * 自定义实现页面链接跳转抓取
 */
$data    = 'username=yangshengtian@163.com&password=131978abc&remember=1';
$curlobj = curl_init(); // 初始化
curl_setopt($curlobj, CURLOPT_URL, "http://www.imooc.com/user/login"); // 设置访问网页的URL
curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true); // 执行之后不直接打印出来

// Cookie相关设置，这部分设置需要在所有会话开始之前设置
date_default_timezone_set('PRC'); // 使用Cookie时，必须先设置时区
curl_setopt($curlobj, CURLOPT_COOKIESESSION, true);
curl_setopt($curlobj, CURLOPT_HEADER, 0);
// 注释掉这行，因为这个设置必须关闭安全模式 以及关闭open_basedir，对服务器安全不利
//curl_setopt($curlobj, CURLOPT_FOLLOWLOCATION, 1);

curl_setopt($curlobj, CURLOPT_POST, 1);
curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data);
curl_setopt($curlobj, CURLOPT_HTTPHEADER, array("application/x-www-form-urlencoded; charset=utf-8",
    "Content-length: " . strlen($data),
));
curl_exec($curlobj); // 执行
curl_setopt($curlobj, CURLOPT_URL, "http://www.imooc.com/u/1369565");
curl_setopt($curlobj, CURLOPT_POST, 0);
curl_setopt($curlobj, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
$output = curl_exec($curlobj); // 执行
curl_close($curlobj); // 关闭cURL
echo $output;
