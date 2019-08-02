<?php

namespace Omnipay\Payeer\Message;

use Omnipay\Common\Exception\InvalidResponseException;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getMerchantKey()
    {
        return $this->getParameter('merchant_key');
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchant_key', $value);
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

    public function setSubmerchant($value)
    {
        return $this->setParameter('submerchant',$value);
    }

    private function mParams()
    {
        $arParams = [
            'success_url' => $this->getParameter('success_url'),
            'fail_url' => $this->getParameter('fail_url'),
            'status_url' => $this->getParameter('status_url'),
            'submerchant' => $this->getParameter('submerchant')
        ];

        $key = md5($this->getParameter('params_key') . $this->getTransactionId());

        return urlencode(
            base64_encode(
                @openssl_encrypt(
                    json_encode($arParams),
                    'AES-256-CBC', $key,
                    OPENSSL_RAW_DATA)));
    }

    public function getData()
    {
        if ($this->httpRequest->request->get('m_curr') != $this->getCurrency()) {
            throw new InvalidResponseException("Invalid m_curr:" . $this->httpRequest->request->get('m_curr'));
        }

        if ($this->httpRequest->request->get('m_status') != 'success') {
            throw new InvalidResponseException("Invalid m_status:" . $this->httpRequest->request->get('m_status'));
        }

        $arHash = [
            $this->httpRequest->request->get('m_operation_id'),
            $this->httpRequest->request->get('m_operation_ps'),
            $this->httpRequest->request->get('m_operation_date'),
            $this->httpRequest->request->get('m_operation_pay_date'),
            $this->httpRequest->request->get('m_shop'),
            $this->httpRequest->request->get('m_orderid'),
            $this->httpRequest->request->get('m_amount'),
            $this->httpRequest->request->get('m_curr'),
            $this->httpRequest->request->get('m_desc'),
            $this->httpRequest->request->get('m_status'),
            $this->getMerchantKey(),
        ];

        if ($this->httpRequest->request->has('m_params')){
            $arHash[] = $this->httpRequest->request->get('m_params');
        }
        $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

        if ($this->httpRequest->request->get('m_sign') != $sign_hash) {
            throw new InvalidResponseException("Invalid m_sign");
        }

        echo $this->httpRequest->request->get('m_orderid') . '|success';

        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
