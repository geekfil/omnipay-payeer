<?php

namespace Omnipay\Payeer;

use Omnipay\Common\AbstractGateway;

/**
 * Gateway Class
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Payeer';
    }

    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    public function getApiId()
    {
        return $this->getParameter('api_id');
    }

    public function setApiId($value)
    {
        return $this->setParameter('api_id', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('api_key');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('api_key', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchant_id');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchant_id', $value);
    }

    public function getMerchantKey()
    {
        return $this->getParameter('merchant_key');
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchant_key', $value);
    }

    public function getMerchantLang()
    {
        return $this->getParameter('merchant_lang');
    }

    public function setMerchantLang($value)
    {
        return $this->setParameter('merchant_lang', $value);
    }

    public function getDefaultParameters()
    {
        return [
            'account' => '',
            'api_id' => '',
            'api_key' => '',
            'merchant_id' => '',
            'merchant_key' => '',
            'merchant_lang' => '',
        ];
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeer\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeer\Message\CompletePurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeer\Message\RefundRequest', $parameters);
    }
}
