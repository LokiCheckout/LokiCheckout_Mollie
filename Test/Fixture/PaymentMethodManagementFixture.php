<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Test\Fixture;

use Magento\Framework\DataObject;
use Magento\TestFramework\Fixture\DataFixtureInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Mollie\Payment\Plugin\Quote\Api\PaymentMethodManagementPlugin;
use Yireo\LokiCheckoutMollie\Test\Integration\Stub\PaymentMethodManagementPluginStub;

class PaymentMethodManagementFixture implements DataFixtureInterface
{
    public function apply(array $data = []): ?DataObject
    {
        $objectManager = Bootstrap::getObjectManager();
        $instance = $objectManager->create(PaymentMethodManagementPluginStub::class);

        $objectManager->configure([
            'preferences' => [
                PaymentMethodManagementPlugin::class => PaymentMethodManagementPluginStub::class
            ]
        ]);

        $objectManager->addSharedInstance($instance, PaymentMethodManagementPlugin::class, true);

        return null;
    }
}
