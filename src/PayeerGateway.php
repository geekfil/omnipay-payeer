<?php

namespace Omnipay\Payeer;

use Omnipay\Common\AbstractGateway;

/**
 * Payeer Gateway
 */
class PayeerGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Payeer';
    }

    public function getDefaultParameters()
    {
        return array(
            'key' => '',
            'testMode' => false,
        );
    }

    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }

    /**
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeer\Message\AuthorizeRequest', $parameters);
    }
}
