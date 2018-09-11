<?php

namespace Omnipay\Panda\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Panda\Helper;

/**
 * Class UnityRefundRequest
 * @package Omnipay\Panda\Message
 */
class UnityRefundRequest extends AbstractUnityRequest
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
            'amount',
            'subject',
            'app_key',
            'ch_id'
        );

        $data = array (
            //商户订单号
            'order_no'        => $this->getOrderNo(),
            //交易金额，单位分
            'amount'         => $this->getAmount(),
            //主题
            'subject' => $this->getSubject(),
            //内容
            'body' => $this->getBody(),
            //app_id
            'app' => $this->getApp(),
            //支付方式
            'channel' => $this->getChannel(),
            //callback地址
            'callback' => $this->getCallback(),
            //app_key
            'app_key' => $this->getAppKey(),
            //货币
            'currency' => $this->getCurrency(),
            //私钥地址
            'private_key_path' => $this->getPrivateKeyPath(),
            //交易id
            'ch_id' => $this->getChId()
        );

        return $data;
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
//        require dirname(__FILE__) . '/../../../../pingplusplus/Panda-php/init.php';

        \Panda\Panda::setApiKey($data['app_key']);           // 设置 API Key
        \Panda\Panda::setPrivateKeyPath($data['private_key_path']);   // 设置私钥

        // 通过发起一次退款请求创建一个新的 refund 对象，只能对已经发生交易并且没有全额退款的 Unity 对象发起退款
        $ch = \Panda\Unity::retrieve($data['ch_id']);// Unity 对象的 id

        $re = $ch->refunds->create(
            array(
                'amount' => $data['amount'],// 退款的金额, 单位为对应币种的最小货币单位，例如：人民币为分（如退款金额为 1 元，此处请填 100）。必须小于等于可退款金额，默认为全额退款
                'description' => $data['subject']
            )
        );

        return $this->response = new UnityRefundResponse($this, json_decode($re));
    }
}
