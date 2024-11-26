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
        'shipping_method_selected' => 'refresh', // @todo
        'coupon_code_applied' => 'refresh',
        'coupon_code_revoked' => 'refresh'
    ];

    private UrlInterface $url;

    private Session $checkoutSession;

    private StoreManagerInterface $storeManager;

    private CartRepositoryInterface $cartRepository;

    private SupportedNetworks $supportedNetworks;

    private MollieConfig $mollieConfig;

    public string $amount = '';

    public string $countryId = '';

    public string $currencyCode = '';

    public string $storeName = '';

    public string $time = '';

    public function __construct(
        UrlInterface $url,
        Session $checkoutSession,
        StoreManagerInterface $storeManager,
        CartRepositoryInterface $cartRepository,
        MollieConfig $mollieConfig,
        SupportedNetworks $supportedNetworks
    ) {
        $this->url = $url;
        $this->checkoutSession = $checkoutSession;
        $this->storeManager = $storeManager;
        $this->cartRepository = $cartRepository;
        $this->mollieConfig = $mollieConfig;
        $this->supportedNetworks = $supportedNetworks;
    }

    public function mount(): void
    {
        $cart = $this->checkoutSession->getQuote();
        $this->countryId = $cart->getBillingAddress()->getCountryId();
        $this->currencyCode = $cart->getQuoteCurrencyCode();
        $this->storeName = $this->storeManager->getStore()->getName();
    }

    public function boot(): void
    {
        $this->amount = (string)$this->checkoutSession->getQuote()->getGrandTotal();
    }

    public function directIntegrationIsEnabled(): bool
    {
        return $this->mollieConfig->applePayIntegrationType() == ApplePayIntegrationType::DIRECT;
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
