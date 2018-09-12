<?php

namespace Omnipay\Panda\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class UnityResponse
 * @package Omnipay\Panda\Message
 */
class UnityRefundResponse extends AbstractResponse
{

    public function isRedirect()
    {
        return false;
    }


    public function getRedirectMethod()
    {
        return 'POST';
    }


    public function getRedirectUrl()
    {
        return false;
    }


    public function getRedirectHtml()
    {
        return false;
    }


    public function getTransactionNo()
    {
        return isset($this->data['refund_id']) ? $this->data['refund_id'] : '';
    }


    public function isPaid()
    {
        if ($this->data['is_paid']) {
            return true;
        }

        return false;
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        if ($this->data['is_paid']) {
            return true;
        }

        return false;
    }

    public function getMessage()
    {
        return isset($this->data['transaction_id']) ? $this->data['transaction_id'] : '';
    }
}
