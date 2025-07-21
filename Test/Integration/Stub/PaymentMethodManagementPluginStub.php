<?php declare(strict_types=1);

namespace LokiCheckout\Mollie\Test\Integration\Stub;

use Magento\Quote\Api\PaymentMethodManagementInterface;
use Mollie\Payment\Plugin\Quote\Api\PaymentMethodManagementPlugin;

class PaymentMethodManagementPluginStub extends PaymentMethodManagementPlugin
{
    public function afterGetList(PaymentMethodManagementInterface $subject, $result, $cartId)
    {
        return $result;
    }
}
