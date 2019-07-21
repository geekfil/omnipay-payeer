<?php

namespace Omnipay\Payeer\Message;

class RefundRequest extends AbstractRequest
{
    protected $endpoint = 'https://payeer.com/ajax/api/api.php';

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

    public function getPayeeAccount()
    {
        return $this->getParameter('payeeAccount');
    }

    public function setPayeeAccount($value)
    {
        return $this->setParameter('payeeAccount', $value);
    }

    public function getAction()
    {
        return $this->getParameter('action');
    }

    public function setAction($value)
    {
        return $this->setParameter('action', $value);
    }

    public function getPs()
    {
        return $this->getParameter('ps');
    }

    public function setPs($value)
    {
        return $this->setParameter('ps', $value);
    }

    public function getParamAccountNumber()
    {
        return $this->getParameter('param_account_number');
    }

    public function setParamAccountNumber($value)
    {
        return $this->setParameter('param_account_number', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'currency', 'description','action');

        $data['apiPass'] = $this->getApiKey();
        $data['apiId'] = $this->getApiId();
        $data['curIn'] = $this->getCurrency();
        $data['curOut'] = $this->getCurrency();
        $data['action'] = $this->getAction();
        $data['account'] = $this->getAccount();

        if ($this->getAction() == 'transfer') {
            $data['comment'] = $this->getDescription();
            $data['to'] = $this->getPayeeAccount();
            $data['sum'] = $this->getAmount();
        } else if ($this->getAction() == 'output' or $this->getAction() == 'initOutput') {
            $data['sumIn'] = $this->getAmount();
            $data['ps'] = $this->getPs();
            $data[$this->getParamAccountNumber()] = $this->getPayeeAccount();
        }
        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->endpoint, [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ], $data);
        $jsonResponse = json_decode($httpResponse->getBody(true));
        return new RefundResponse($this, $jsonResponse);
    }
}
