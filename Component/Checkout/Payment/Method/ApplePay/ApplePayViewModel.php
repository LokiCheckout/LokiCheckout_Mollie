<?php
declare(strict_types=1);

namespace LokiCheckout\Mollie\Component\Checkout\Payment\Method\ApplePay;

use Mollie\Payment\Model\Adminhtml\Source\ApplePayIntegrationType;
use LokiCheckout\Core\Component\Base\Generic\CheckoutViewModel;
use LokiCheckout\Mollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 */
class ApplePayViewModel extends CheckoutViewModel
{
    public function isAllowRendering(): bool
    {
        if ($this->getContext()->getMollieConfig()->applePayIntegrationType() !== ApplePayIntegrationType::DIRECT) {
            return false;
        }

        return true;
    }

    public function getCountryId(): string
    {
        $cart = $this->getContext()->getCheckoutState()->getQuote();
        return $cart->getBillingAddress()->getCountryId();
    }

    public function getCurrencyCode(): string
    {
        $cart = $this->getContext()->getCheckoutState()->getQuote();
        return $cart->getQuoteCurrencyCode();
    }

    public function getAmount(): string
    {
        return (string)$this->getContext()->getCheckoutState()->getQuote()->getGrandTotal();
    }

    public function getStoreName(): string
    {
        return $this->getContext()->getStoreManager()->getStore()->getName();
    }

    public function getApplePayValidationUrl(): string
    {
        return $this->getContext()->createUrl()->getUrl('mollie/checkout/applePayValidation', ['_secure' => true]);
    }

    public function getSupportedNetworks(): array
    {
        return $this->getContext()->getSupportedNetworks()->execute();
    }

    public function getFieldName(): string
    {
        return 'mollie_applepay';
    }

    public function getFieldLabel(): string
    {
        return 'ApplePay';
    }
}
