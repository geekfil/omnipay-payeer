<?php

namespace Omnipay\Payeer\Message;

use Omnipay\Common\Exception\InvalidRequestException;

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

    public function getData()
    {
        $this->validate('payeeAccount', 'amount', 'currency', 'description');

        $data['apiPass'] = $this->getApiKey();
        $data['apiId'] = $this->getApiId();
        $data['account'] = $this->getAccount();
        $data['sum'] = $this->getAmount();
        $data['curIn'] = $this->getCurrency();
        $data['curOut'] = $this->getCurrency();
        $data['to'] = $this->getPayeeAccount();
        $data['comment'] = $this->getDescription();
        $data['action'] = $this->getAction()?$this->getAction():'transfer';
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
