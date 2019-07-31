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

    public function setSuccessUrl($value)
    {
        return $this->setParameter('success_url', $value);
    }

    public function setFailUrl($value)
    {
        return $this->setParameter('fail_url', $value);
    }

    public function setStatusUrl($value)
    {
        return $this->setParameter('status_url', $value);
    }

    public function setParamsKey($value)
    {
        return $this->setParameter('params_key', $value);
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
        ];

        $data['m_shop'] = $this->getMerchantId();
        $data['m_orderid'] = $this->getTransactionId();
        $data['m_amount'] = $this->getAmount();
        $data['m_curr'] = $this->getCurrency();
        $data['m_desc'] = base64_encode($this->getDescription());
        $data['lang'] = $this->getMerchantLang();
        $data['m_cipher_method'] = 'AES-256-CBC';
        $data['m_params'] = $this->mParams();

        $arHash[] = $data['m_params'];
        $arHash[] = $this->getMerchantKey();

        $sign = strtoupper(hash('sha256', implode(":", $arHash)));

        $data['m_sign'] = $sign;


        return $data;
    }

    private function mParams()
    {
        $arParams = [
            'success_url' => $this->getParameter('success_url'),
            'fail_url' => $this->getParameter('fail_url'),
            'status_url' => $this->getParameter('status_url'),
            'submerchant' => $_SERVER['HTTP_HOST']
        ];

        $key = md5($this->getParameter('params_key') . $this->getTransactionId());

        return urlencode(
            base64_encode(
                @openssl_encrypt(
                    json_encode($arParams),
                    'AES-256-CBC', $key,
                    OPENSSL_RAW_DATA)));
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data, $this->getMerchantEndpoint());
    }
}
