<?php
ini_set('display_errors', 'On');
$res = curlHttp('http://nginx/mysql.php');
var_dump($res);





/**
 * curl抓取网页方法
 *
 * @param string $url  目标网址
 * @param array  $data 传输数据
 * @param string $urlype 请求类型
 * @param int    $ssl  是否是https网关
 * @param bool   $raw  是否输出原生内容
 *
 * @param bool   $is_mobile 是否是手机ua
 *
 * @return array $output 返回内容  [body]页面内容 [http_code]是响应码
 */
function curlHttp($url, $data=[], $urlype='get', $ssl=1, $raw=false, $is_mobile = false)
{
    $output = [];
    $data = is_array($data) ? http_build_query($data) : $data;
    if ($urlype == 'get') {
        $url = $url . '?' . $data;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($urlype == 'post') {
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
    }
    if ($ssl) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_BINARYTRANSFER,1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch,CURLOPT_MAXREDIRS,8);
//    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_REFERER, true);
//    curl_setopt($ch, CURLOPT_COOKIEJAR, true);
//    curl_setopt($ch, CURLOPT_COOKIEFILE, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $ua = $is_mobile
        ? 'Mozilla/5.0 (iPad; U; CPU OS 3_2_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B500 Safari/531.21.10'
//        ? 'Dalvik/1.6.0 (Linux; U; Android 4.1.2; DROID RAZR HD Build/9.8.1Q-62_VQW_MR-2)'
        : 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36';
    curl_setopt($ch,CURLOPT_USERAGENT, $ua);
    $res = curl_exec($ch);
    if ($raw) {
        return curl_getinfo($ch);
    }

    $output['body'] = $res === false ? 'CURL RETURN ERROR:' . curl_error($ch) : $res;
    $output['http_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $output;
}
