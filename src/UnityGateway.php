<?php

namespace Omnipay\Panda;

use Omnipay\Common\AbstractGateway;

/**
 * Class UnityGateway
 * @package Omnipay\Panda
 */
class UnityGateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Panda_Unity';
    }


    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }


    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }


    public function setTradeNo($value)
    {
        return $this->setParameter('trade_no', $value);
    }


    public function getTradeNo()
    {
        return $this->getParameter('trade_no');
    }


    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }


    public function getAmount()
    {
        return $this->getParameter('amount');
    }


    public function setSubject($value)
    {
        return $this->setParameter('subject', $value);
    }


    public function getSubject()
    {
        return $this->getParameter('subject');
    }


    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }


    public function getDescription()
    {
        return $this->getParameter('description');
    }


    public function setMerchantId($value)
    {
        return $this->setParameter('merchant_id', $value);
    }


    public function getMerchantId()
    {
        return $this->getParameter('merchant_id');
    }


    public function setPaymethod($value)
    {
        return $this->setParameter('paymethod', $value);
    }


    public function getPaymethod()
    {
        return $this->getParameter('paymethod');
    }


    public function setPaymentType($value)
    {
        return $this->setParameter('payment_type', $value);
    }


    public function getPaymentType()
    {
        return $this->getParameter('payment_type');
    }


    public function setTime($value)
    {
        return $this->setParameter('time', $value);
    }


    public function getTime()
    {
        return $this->getParameter('time');
    }


    public function setNotifyUrl($value)
    {
        return $this->setParameter('notify_url', $value);
    }


    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    public function setNoticeUrl($value)
    {
        return $this->setParameter('notice_url', $value);
    }


    public function getNoticeUrl()
    {
        return $this->getParameter('notice_url');
    }


    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }


    public function getCurrency()
    {
        return $this->getParameter('currency');
    }


    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }


    public function getKey()
    {
        return $this->getParameter('key');
    }


    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Panda\Message\UnityPurchaseRequest', $parameters);
    }


    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Panda\Message\UnityCompletePurchaseRequest', $parameters);
    }


    public function query(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Panda\Message\UnityQueryRequest', $parameters);
    }


    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Panda\Message\UnityRefundRequest', $parameters);
    }


    public function completeRefund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Panda\Message\UnityCompleteRefundRequest', $parameters);
    }
}
