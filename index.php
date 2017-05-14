<?php

// 初始化
$curlobj = curl_init();
// 设置访问网页的URL
curl_setopt($curlobj, CURLOPT_URL, "https://www.lagou.com//jobs/positionAjax.json?px=new&city=深圳&needAddtionalResult=false");

// 设置HTTPS支持
// 使用Cookie时，必须先设置时区
date_default_timezone_set('PRC');
// 对认证证书来源的检查从证书中检查SSL加密算法是否存在
curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, false);
//检查公用名是否存在，并且是否与提供的主机名匹配。
curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, 2);

// Cookie相关设置，这部分设置需要在所有会话开始之前设置
// 使用Cookie时，必须先设置时区
// date_default_timezone_set('PRC');
// curl_setopt($curlobj, CURLOPT_COOKIESESSION, true);
// curl_setopt($curlobj, CURLOPT_COOKIEFILE, "cookiefile");
// curl_setopt($curlobj, CURLOPT_COOKIEJAR, "cookiefile");
// curl_setopt($curlobj, CURLOPT_COOKIE, session_name() . '=' . session_id());

//启用时会将头文件的信息作为数据流输出。
curl_setopt($curlobj, CURLOPT_HEADER, false);

//启用时会发送一个常规的POST请求，
//类型为：application/x-www-form-urlencoded。
curl_setopt($curlobj, CURLOPT_POST, true);
//设置将要传递的参数
if (isset($_POST['page'])) {
    $page = $_POST['page'];
} else {
    $page = 1;
}
$data = 'first=true&pn=' . $page . '&kd=web前端开发 腾讯';
curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data);
//设置要发送的头部字段
$headertext = array(
    "Content-Type:application/x-www-form-urlencoded;charset=UTF-8",
    "Cookie:user_trace_token=20170514143159-08bc2590-386f-11e7-bf18-5254005c3644; PRE_UTM=; PRE_HOST=; PRE_SITE=; PRE_LAND=https%3A%2F%2Fpassport.lagou.com%2Flogin%2Flogin.html; LGUID=20170514143159-08bc29fa-386f-11e7-bf18-5254005c3644; JSESSIONID=ABAAABAACDBABJB1147527334C14C5D5A6D28878E0C0F27; _putrc=A98CC95B20F217D6; login=true; unick=%E6%9D%A8%E5%86%AC; showExpriedIndex=1; showExpriedCompanyHome=1; showExpriedMyPublish=1; hasDeliver=5; TG-TRACK-CODE=index_search; _gat=1; _gid=GA1.2.1434194587.1494744837; Hm_lvt_4233e74dff0ae5bd0a3d81c6ccf756e6=1493517068,1494677248,1494728606; Hm_lpvt_4233e74dff0ae5bd0a3d81c6ccf756e6=1494744838; _ga=GA1.2.868080790.1494743550; LGSID=20170514143159-08bc27c6-386f-11e7-bf18-5254005c3644; LGRID=20170514145327-0868bc68-3872-11e7-a9ae-525400f775ce; SEARCH_ID=46f7cc97a2dc48cda0198b698f32698e; index_location_city=%E6%B7%B1%E5%9C%B3",
    "Content-Lenght:" . strlen($data),
);
curl_setopt($curlobj, CURLOPT_HTTPHEADER, $headertext);

// 将 curl_exec() 获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
//执行命令
$contentString = curl_exec($curlobj);
if (!curl_error($curlobj)) {
    //对数据进行筛选
    $contentObj = json_decode($contentString);
    $result     = $contentObj->{"content"}->{"positionResult"}->{"result"};
    for ($i = 0; $i < count($result); $i++) {
        //采集详情页职位描述数据
        $curlpage = curl_init();
        curl_setopt($curlpage, CURLOPT_URL, "https://www.lagou.com/jobs/" . $result[$i]->{"positionId"} . ".html");
        date_default_timezone_set('PRC');
        curl_setopt($curlpage, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlpage, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlpage, CURLOPT_HEADER, false);
        curl_setopt($curlpage, CURLOPT_POST, false);
        curl_setopt($curlpage, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($curlpage, CURLOPT_RETURNTRANSFER, true);
        $jobString = curl_exec($curlpage);
        if (!curl_error($curlpage)) {
            $jobStart   = strpos($jobString, '<dd class="job_bt">');
            $jobEnd     = strpos($jobString, '<dd class="job-address clearfix">');
            $jobContent = substr($jobString, $jobStart, $jobEnd - $jobStart);
            echo $jobContent . '<hr/>';
        } else {
            echo 'Curl error' . curl_error($curlpage);

        }
    }
} else {
    echo 'Curl error' . curl_error($curlobj);
}
//关闭curl
curl_close($curlobj);
$page = $page + 1;
echo '<form action="/Test/cURL/findjobs.php" method="POST"><input type="submit" name="page" value="' . $page . '"></form>';
