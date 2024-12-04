<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Magewire\Checkout\Payment\Method;

use Magento\Checkout\Model\Session;
use Magento\Framework\UrlInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mollie\Payment\Config as MollieConfig;
use Mollie\Payment\Model\Adminhtml\Source\ApplePayIntegrationType;
use Mollie\Payment\Service\Mollie\ApplePay\SupportedNetworks;
use Yireo\LokiCheckout\Magewire\Form\Field\FieldComponent;

class ApplePay extends FieldComponent
{
    protected $listeners = [
        'afterSaveShippingMethod' => 'refresh',
        'afterApplyCouponCode' => 'refresh',
        'afterRemoveCouponCode' => 'refresh'
    ];

    public function __construct(
        private UrlInterface            $url,
        private Session                 $checkoutSession,
        private StoreManagerInterface   $storeManager,
        private CartRepositoryInterface $cartRepository,
        private MollieConfig            $mollieConfig,
        private SupportedNetworks       $supportedNetworks
    ) {
    }

    public function boot(): void
    {
        if ($this->mollieConfig->applePayIntegrationType() !== ApplePayIntegrationType::DIRECT) {
            $this->visible = false;
        }

        parent::boot();
    }

    public function getCountryId(): string
    {
        $cart = $this->checkoutSession->getQuote();
        return $cart->getBillingAddress()->getCountryId();
    }

    public function getCurrencyCode(): string
    {
        $cart = $this->checkoutSession->getQuote();
        return $cart->getQuoteCurrencyCode();
    }

    public function getAmount(): string
    {
        return (string)$this->checkoutSession->getQuote()->getGrandTotal();
    }

    public function getStoreName(): string
    {
        return $this->storeManager->getStore()->getName();
    }

    public function getApplePayValidationUrl(): string
    {
        return $this->url->getUrl('mollie/checkout/applePayValidation', ['_secure' => true]);
    }

    public function setApplePayPaymentToken(string $token): string
    {
        $quote = $this->checkoutSession->getQuote();
        $quote->getPayment()->setAdditionalInformation('applepay_payment_token', $token);

        $this->cartRepository->save($quote);

        return $token;
    }

    public function getSupportedNetworks(): array
    {
        return $this->supportedNetworks->execute();
    }

    public function getFieldName(): string
    {
        return 'mollie_applepay';
    }

    public function getFieldLabel(): string
    {
        return 'ApplePay';
    }

    public function save($value): void
    {
        $quote = $this->checkoutSession->getQuote();
        $quote->getPayment()->setAdditionalInformation('applepay_payment_token', $value);
        $this->cartRepository->save($quote);
    }
}
