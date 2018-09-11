<?php

namespace Omnipay\Panda\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class UnityCompletePurchaseResponse
 * @package Omnipay\Panda\Message
 */
class UnityCompleteRefundResponse extends AbstractResponse
{

    public function isPaid()
    {
        return $this->data['is_paid'] && $this->data['data']['object']['succeed'];
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['is_paid'] && $this->data['data']['object']['succeed'];
    }
}
