<?php

namespace Omnipay\Payeer\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Payeer\Support\Helpers;

class RefundResponse extends AbstractResponse
{
    protected $redirectUrl;
    protected $message;
    protected $success;
    protected $historyId;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
        $this->parseResponse($data);
    }

    public function isSuccessful()
    {
        return $this->success;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getTransactionReference()
    {
        return $this->historyId;
    }

    private function parseResponse($data)
    {
        if (is_array($data->errors) && count($data->errors)) {
            $this->message = implode(" | ", $data->errors);
            $this->success = false;
            return false;
        }
        $this->success = true;
        $this->historyId = $data->historyId;
    }
}
