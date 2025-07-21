<?php declare(strict_types=1);

namespace LokiCheckout\Mollie\Test\Integration;

use Magento\Framework\App\ObjectManager;
use Magento\TestFramework\Fixture\AppArea;
use Magento\TestFramework\Fixture\Config;
use PHPUnit\Framework\TestCase;
use LokiCheckout\Core\ViewModel\PaymentMethodIcon;

class PaymentMethodIconTest extends TestCase
{
    #[AppArea('frontend')]
    #[Config('payment/mollie_general/payment_images', 1, 'store', 'default')]
    public function testGetIcon()
    {
        $paymentMethodIcon = ObjectManager::getInstance()->get(PaymentMethodIcon::class);
        $icon = $paymentMethodIcon->getIcon('mollie_methods_ideal');
        $this->assertNotEmpty($icon);
    }
}
