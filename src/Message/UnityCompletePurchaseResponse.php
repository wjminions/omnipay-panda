<?php

namespace Omnipay\Panda\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class UnityCompletePurchaseResponse
 * @package Omnipay\Panda\Message
 */
class UnityCompletePurchaseResponse extends AbstractResponse
{

    public function isPaid()
    {
        return $this->data['is_paid'];
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['is_paid'];
    }
}
