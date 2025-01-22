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
use Yireo\LokiCheckoutMollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 */
class ApplePayRepository extends FieldRepository
{
    public function getValue(): mixed
    {
        return null;
    }

    public function saveValue(mixed $value): void
    {
        $value = (string)$value;
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $quote->getPayment()->setAdditionalInformation('applepay_payment_token', $value);
        $this->getContext()->getCartRepository()->save($quote);
    }
}
