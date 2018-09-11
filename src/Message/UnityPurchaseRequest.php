<?php

namespace Omnipay\Panda\Message;

use Guzzle\Http\Message\Header;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Panda\Helper;

/**
 * Class UnityPurchaseRequest
 *
 * @package Omnipay\Panda\Message
 */
class UnityPurchaseRequest extends AbstractUnityRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();

        $data = array(
            'trade_no'     => $this->getTradeNo(),
            'merchant_id'  => $this->getMerchantId(),
            'paymethod'    => $this->getPaymethod(),
            'payment_type' => $this->getPaymentType(),
            'time'         => $this->getTime(),
            'notify_url'   => $this->getNotifyUrl(),
            'notice_url'   => $this->getNoticeUrl(),
            'amount'       => $this->getAmount(),
            'currency'     => $this->getCurrency(),
            'subject'      => $this->getSubject(),
            'description'  => $this->getDescription(),
        );

        return $data;
    }


    private function validateData()
    {
        $this->validate(
            'trade_no',
            'merchant_id',
            'paymethod',
            'payment_type',
            'time',
            'notify_url',
            'notice_url',
            'amount',
            'currency',
            'subject',
            'description'
        );
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $data['sign'] = Header::sign($data, $this->getkey());

        if ($this->data['payment_type'] == 'pc_web' || $this->data['payment_type'] == 'mobile_web') {
            $unity = $data;
        } else {
            $unity = Helper::sendHttpRequest($this->getEndpoint(), $data);
        }

        return $this->response = new UnityPurchaseResponse($this, $unity);
    }
}
