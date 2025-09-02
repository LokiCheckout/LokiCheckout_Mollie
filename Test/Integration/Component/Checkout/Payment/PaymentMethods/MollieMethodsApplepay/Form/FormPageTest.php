<?php

declare(strict_types=1);

namespace LokiCheckout\Mollie\Test\Integration\Component\Checkout\Payment\PaymentMethods\MollieMethodsApplepay\Form;

use Magento\Catalog\Test\Fixture\Product as ProductFixture;
use Magento\Quote\Test\Fixture\AddProductToCart as AddProductToCartFixture;
use Magento\Quote\Test\Fixture\GuestCart as GuestCartFixture;
use Magento\TestFramework\Fixture\AppArea;
use Magento\TestFramework\Fixture\Config as ConfigFixture;
use Magento\TestFramework\Fixture\DataFixture;
use PHPUnit\Framework\TestCase;
use Yireo\IntegrationTestHelper\Test\Integration\Traits\GetObjectManager;
use LokiCheckout\Core\Test\Fixture\PaymentMethodFixture;
use LokiCheckout\Core\Test\Fixture\ShippingAddressFixture;
use LokiCheckout\Core\Test\Integration\LokiCheckoutPageTestCase;
use LokiCheckout\Core\Test\Integration\Trait\AssertPaymentMethodOnPage;
use LokiCheckout\Mollie\Test\Integration\Trait\AddPayentMethodManagementPluginStub;

#[
    DataFixture(ProductFixture::class, ['sku' => 'simple-product-001'], as: 'product'),
    DataFixture(GuestCartFixture::class, as: 'cart'),
    DataFixture(AddProductToCartFixture::class, ['cart_id' => '$cart.id$', 'product_id' => '$product.id$']),
    DataFixture(ShippingAddressFixture::class, ['cart_id' => '$cart.id$']),
    AppArea('frontend')
]
final class FormPageTest extends LokiCheckoutPageTestCase
{
    use GetObjectManager;
    use AddPayentMethodManagementPluginStub;
    use AssertPaymentMethodOnPage;

    protected ?bool $skipDispatchToCheckout = true;

    public const PAYMENT_METHOD = 'mollie_methods_applepay';

    const BLOCK_NAME = 'loki-checkout.payment.methods.mollie_methods_applepay.form';

    #[
        ConfigFixture('loki_checkout/general/theme', 'onestep', 'store', 'default'),
        ConfigFixture('payment/mollie_general/enabled', '1', 'store', 'default'),
        ConfigFixture('payment/mollie_general/type', 'test', 'store', 'default'),
        ConfigFixture('payment/mollie_general/apikey_test', 'test_thisisalongstringofthirtychars', 'store', 'default'),
        ConfigFixture('payment/mollie_methods_applepay/active', '0', 'store', 'default'),
    ]
    final public function testPaymentNotOnPage(): void
    {
        $this->addMollieStubs();
        $this->dispatchToCheckout();
        $this->assertPaymentMethodNotOnPage(self::PAYMENT_METHOD);
        $this->assertComponentNotExistsOnPage(self::BLOCK_NAME, true);
    }

    #[
        ConfigFixture('loki_checkout/general/theme', 'onestep', 'store', 'default'),
        ConfigFixture('payment/mollie_general/enabled', '1', 'store', 'default'),
        ConfigFixture('payment/mollie_general/type', 'test', 'store', 'default'),
        ConfigFixture('payment/mollie_general/apikey_test', 'test_thisisalongstrongofthirtychars', 'store', 'default'),
        ConfigFixture('payment/mollie_methods_applepay/active', '1', 'store', 'default'),
        ConfigFixture('payment/mollie_methods_creditcard/integration_type', 'direct', 'store', 'default'),
    ]
    final public function testPaymentOnPageButComponentNotOnPage(): void
    {
        $this->addMollieStubs();
        $this->dispatchToCheckout();
        $this->assertPaymentMethodOnPage(self::PAYMENT_METHOD);

        $this->markTestIncomplete('Applepay is currently not fully implemented yet');

        return;
        $this->assertComponentNotExistsOnPage(self::BLOCK_NAME, true);
    }

    #[
        ConfigFixture('loki_checkout/general/theme', 'onestep', 'store', 'default'),
        ConfigFixture('payment/mollie_general/enabled', '1', 'store', 'default'),
        ConfigFixture('payment/mollie_general/type', 'test', 'store', 'default'),
        ConfigFixture('payment/mollie_general/profileid', 'test', 'store', 'default'),
        ConfigFixture('payment/mollie_general/apikey_test', 'test_thisisalongstrongofthirtychars', 'store', 'default'),
        ConfigFixture('payment/mollie_methods_applepay/active', '1', 'store', 'default'),
        ConfigFixture('payment/mollie_methods_creditcard/integration_type', 'direct', 'store', 'default'),
        DataFixture(ProductFixture::class, ['sku' => 'simple-product-001'], as: 'product'),
        DataFixture(GuestCartFixture::class, as: 'cart'),
        DataFixture(AddProductToCartFixture::class, [
            'cart_id' => '$cart.id$',
            'product_id' => '$product.id$',
            'qty' => 1,
        ]),
        DataFixture(ShippingAddressFixture::class, ['cart_id' => '$cart.id$']),
        DataFixture(PaymentMethodFixture::class, [
            'cart_id' => '$cart.id$',
            'payment_method' => 'mollie_methods_applepay',
        ]),
        AppArea('frontend'),
    ]
    final public function testPaymentAndComponentOnPage(): void
    {
        $this->addMollieStubs();
        $this->dispatchToCheckout();

        $this->assertNotNull($this->getQuote()->getPayment()->getMethod(), 'No payment method set in quote');
        $this->assertSame('mollie_methods_applepay', $this->getQuote()->getPayment()->getMethod());

        $this->markTestIncomplete('Applepay is currently not fully implemented yet');

        return;
        $this->assertStringOccursOnPage('payment-'.self::PAYMENT_METHOD);

        //$this->assertComponentExistsOnPage(self::BLOCK_NAME, true);
    }

    private function addMollieStubs(): void
    {
        $this->addPayentMethodManagementPluginStub();
    }
}
