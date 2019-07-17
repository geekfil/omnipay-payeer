<?php

namespace Omnipay\Payeer\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
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

    public function getData()
    {
        $this->validate('account', 'currency', 'amount', 'description');

        $arHash = [
            $this->getMerchantId(),
            $this->getTransactionId(),
            $this->getAmount(),
            $this->getCurrency(),
            base64_encode($this->getDescription()),
            $this->getMerchantKey(),
        ];
        $sign = strtoupper(hash('sha256', implode(":", $arHash)));

        $data['m_shop'] = $this->getMerchantId();
        $data['m_orderid'] = $this->getTransactionId();
        $data['m_amount'] = $this->getAmount();
        $data['m_curr'] = $this->getCurrency();
        $data['m_desc'] = base64_encode($this->getDescription());
        $data['m_sign'] = $sign;
        $data['lang'] = $this->getMerchantLang();

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data, $this->getMerchantEndpoint());
    }
}
