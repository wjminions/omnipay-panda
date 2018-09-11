<?php
namespace Omnipay\Panda;

/**
 * Class Helper
 * @package Omnipay\Panda
 */
class Helper
{
    /**
     * 签名
     *
     * @param array $data
     * @param string $key
     * @return string
     */
    public static function sign($data, $key)
    {
        unset($data['sign']);

        ksort($data);
        reset($data);

        $query = urldecode(http_build_query($data));

        return md5($query . $key);
    }

    /**
     * 模拟请求
     *
     * @param $url
     * @param $params
     * @return mixed
     */
    public static function sendHttpRequest($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/x-www-form-urlencoded;charset=UTF-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
