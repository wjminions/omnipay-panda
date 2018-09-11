<?php

namespace Omnipay\Panda\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Panda\Helper;

/**
 * Class UnityQueryRequest
 *
 * @package Omnipay\Panda\Message
 */
class UnityQueryRequest extends AbstractUnityRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate(
            'app_key',
            'order_no'
        );

        $data = array(
            //app_id
            'app'              => $this->getApp(),
            //支付方式
            'channel'          => $this->getChannel(),
            //callback地址
            'callback'         => $this->getCallback(),
            //app_key
            'app_key'          => $this->getAppKey(),
            //货币
            'currency'         => $this->getCurrency(),
            //私钥地址
            'private_key_path' => $this->getPrivateKeyPath(),
            //交易id
            'order_no'         => $this->getOrderNo()
        );

        return $data;
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {

        \Panda\Panda::setApiKey($data['app_key']);           // 设置 API Key
        \Panda\Panda::setPrivateKeyPath($data['private_key_path']);   // 设置私钥

        // 查询支付成功列表
        $ch = \Panda\Unity::all(array(
            'limit'    => 10,
            'app'      => array('id' => $data['app']),
            'channel'  => $data['channel'],
            'paid'     => true,
            'refunded' => false,
            'reversed' => false
        ));

        $data['is_paid'] = false;

        foreach ($ch->data as $Unity) {
            if ($Unity['order_no'] == $data['order_no'] && $Unity['paid'] && ! $Unity['refunded'] && ! $Unity['reversed']) {
                $data['is_paid'] = true;

                $data['id']              = $Unity->id;
                $data["object"]          = $Unity->object;
                $data["created"]         = $Unity->created;
                $data["livemode"]        = $Unity->livemode;
                $data["paid"]            = $Unity->paid;
                $data["refunded"]        = $Unity->refunded;
                $data["reversed"]        = $Unity->reversed;
                $data["app"]             = $Unity->app;
                $data["channel"]         = $Unity->channel;
                $data["client_ip"]       = $Unity->client_ip;
                $data["amount"]          = $Unity->amount;
                $data["amount_settle"]   = $Unity->amount_settle;
                $data["currency"]        = $Unity->currency;
                $data["subject"]         = $Unity->subject;
                $data["body"]            = $Unity->body;
                $data["time_paid"]       = $Unity->time_paid;
                $data["time_expire"]     = $Unity->time_expire;
                $data["time_settle"]     = $Unity->time_settle;
                $data["amount_refunded"] = $Unity->amount_refunded;
                $data["failure_code"]    = $Unity->failure_code;
                $data["failure_msg"]     = $Unity->failure_msg;
                $data["description"]     = $Unity->description;

                break;
            }
        }

        return $data;// 输出 Ping++ 返回 Unity 对象
    }
}
