<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\ApplePay;

use Magento\Framework\UrlInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mollie\Payment\Config as MollieConfig;
use Mollie\Payment\Model\Adminhtml\Source\ApplePayIntegrationType;
use Mollie\Payment\Service\Mollie\ApplePay\SupportedNetworks;
use Yireo\LokiCheckout\Component\Base\Field\FieldComponent;
use Yireo\LokiCheckout\Component\Base\Field\FieldRepository;
use Yireo\LokiCheckout\ViewModel\CheckoutState;

/**
 * @method ApplePayContext getContext()
 */
class ApplePayRepository extends FieldRepository
{
    public function getValue(): mixed
    {
        return null;
    }

    public function saveValue(mixed $data): void
    {
        $value = (string)$data;
        $quote = $this->getContext()->getQuote();
        $quote->getPayment()->setAdditionalInformation('applepay_payment_token', $value);
        $this->getContext()->getCartRepository()->save($quote);
    }
}
