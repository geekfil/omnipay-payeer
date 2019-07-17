<?php

namespace PHPSTORM_META {

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
      \Omnipay\Omnipay::create('') => [
        'Payeer' instanceof \Omnipay\Payeer\PayeerGateway,
      ],
      \Omnipay\Common\GatewayFactory::create('') => [
        'Payeer' instanceof \Omnipay\Payeer\PayeerGateway,
      ],
    ];
}
