<?php

namespace Omnipay\Panda\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Panda\Helper;

/**
 * Class UnityCompletePurchaseRequest
 * @package Omnipay\Panda\Message
 */
class UnityCompletePurchaseRequest extends AbstractUnityRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->getRequestParams();
    }


    public function setRequestParams($value)
    {
        $this->setParameter('request_params', $value);
    }


    public function getRequestParams()
    {
        return $this->getParameter('request_params');
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
        $sign = Helper::sign($data, $this->getkey());

        $data['is_paid'] = false;
        if ($data['sign'] == $sign && $data['status'] == 'success') {
            $data['is_paid'] = true;
        }

        return $this->response = new UnityCompletePurchaseResponse($this, $data);
    }
}
