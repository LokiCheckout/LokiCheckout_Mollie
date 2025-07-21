<?php declare(strict_types=1);

namespace LokiCheckout\Mollie\Test\Integration\Trait;

use Magento\TestFramework\Helper\Bootstrap;
use Mollie\Payment\Plugin\Quote\Api\PaymentMethodManagementPlugin;
use LokiCheckout\Mollie\Test\Integration\Stub\PaymentMethodManagementPluginStub;

trait AddPayentMethodManagementPluginStub
{
    public function addPayentMethodManagementPluginStub()
    {
        $objectManager = Bootstrap::getObjectManager();
        $objectManager->configure([
            'preferences' => [
                PaymentMethodManagementPlugin::class => PaymentMethodManagementPluginStub::class,
            ],
        ]);

        $plugin = $objectManager->get(PaymentMethodManagementPlugin::class);
        $this->assertInstanceOf(PaymentMethodManagementPluginStub::class, $plugin);
    }
}
