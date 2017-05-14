### cURL概念简介和步骤解析
确认当前PHP是否支持cURL  
在phpinfo()中查找cURL
cURL.support   enabled
说明当前PHP支持cURL

#### cURL操作步骤解析

1. 初始化cURL
curl_init()
2. 箱服务器发送请求和接收服务器数据
curl_exec()
3. 关闭cURL
curl_close()

### cURL实战
#### 用cURL制作一个简单的网页爬虫
