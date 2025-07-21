<?php
declare(strict_types=1);

namespace LokiCheckout\Mollie\Component;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Locale\ResolverInterface as LocaleResolver;
use Magento\Framework\Message\ManagerInterface as CoreMessageManager;
use Magento\Framework\UrlFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mollie\Payment\Config as MollieConfig;
use Mollie\Payment\Service\Mollie\ApplePay\SupportedNetworks;
use LokiCheckout\Core\Config\Config as ModuleConfig;
use LokiCheckout\Core\Payment\Vault\PaymentTokenProvider;
use LokiCheckout\Core\Step\StepNavigator;
use LokiCheckout\Core\Util\Component\AttributeProvider;
use LokiCheckout\Core\Util\Component\StepProvider;
use LokiCheckout\Core\Util\CustomerProvider;
use LokiCheckout\Core\ViewModel\CheckoutState;
use LokiCheckout\Core\ViewModel\State\BillingAddressState;
use LokiCheckout\Core\ViewModel\State\ShippingAddressState;
use LokiCheckout\Mollie\Provider\IssuerProvider;
use Loki\Components\Component\ComponentContextInterface;
use Loki\Components\Messages\GlobalMessageRegistry;

class MollieContext implements ComponentContextInterface
{
    public function __construct(
        private CheckoutState $checkoutState,
        private ShippingAddressState $shippingAddressState,
        private BillingAddressState $billingAddressState,
        private CustomerProvider $customerProvider,
        private StepProvider $stepProvider,
        private StepNavigator $stepNavigator,
        private ModuleConfig $moduleConfig,
        private ScopeConfigInterface $scopeConfig,
        private AttributeProvider $attributeProvider,
        private GlobalMessageRegistry $globalMessageRegistry,
        private CoreMessageManager $coreMessageManager,
        private readonly CustomerSession $customerSession,
        private readonly StoreManagerInterface $storeManager,
        private readonly MollieConfig $mollieConfig,
        private readonly UrlFactory $urlFactory,
        private readonly LocaleResolver $localeResolver,
        private readonly PaymentTokenProvider $paymentTokenProvider,
        private readonly IssuerProvider $issuerProvider,
        private readonly SupportedNetworks $supportedNetworks,
    ) {
    }

    public function getStoreManager(): StoreManagerInterface
    {
        return $this->storeManager;
    }

    public function getMollieConfig(): MollieConfig
    {
        return $this->mollieConfig;
    }

    public function createUrl(): UrlInterface
    {
        return $this->urlFactory->create();
    }

    public function getLocaleResolver(): LocaleResolver
    {
        return $this->localeResolver;
    }

    public function getCheckoutState(): CheckoutState
    {
        return $this->checkoutState;
    }

    public function getShippingAddressState(): ShippingAddressState
    {
        return $this->shippingAddressState;
    }

    public function getBillingAddressState(): BillingAddressState
    {
        return $this->billingAddressState;
    }

    public function getCustomerProvider(): CustomerProvider
    {
        return $this->customerProvider;
    }

    public function getStepProvider(): StepProvider
    {
        return $this->stepProvider;
    }

    public function getStepNavigator(): StepNavigator
    {
        return $this->stepNavigator;
    }

    public function getModuleConfig(): ModuleConfig
    {
        return $this->moduleConfig;
    }

    public function getScopeConfig(): ScopeConfigInterface
    {
        return $this->scopeConfig;
    }

    public function getAttributeProvider(): AttributeProvider
    {
        return $this->attributeProvider;
    }

    public function getGlobalMessageRegistry(): GlobalMessageRegistry
    {
        return $this->globalMessageRegistry;
    }

    public function getCoreMessageManager(): CoreMessageManager
    {
        return $this->coreMessageManager;
    }

    public function getCustomerSession(): CustomerSession
    {
        return $this->customerSession;
    }

    public function getUrlFactory(): UrlFactory
    {
        return $this->urlFactory;
    }

    public function getPaymentTokenProvider(): PaymentTokenProvider
    {
        return $this->paymentTokenProvider;
    }

    public function getIssuerProvider(): IssuerProvider
    {
        return $this->issuerProvider;
    }

    public function getSupportedNetworks(): SupportedNetworks
    {
        return $this->supportedNetworks;
    }
}
