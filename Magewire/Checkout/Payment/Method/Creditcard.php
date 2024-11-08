<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Magewire\Checkout\Payment\Method;

use Magento\Checkout\Model\Session as SessionCheckout;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Mollie\Payment\Config;
use Yireo\LokiCheckout\Magewire\Form\Field\FieldComponent;

class Creditcard extends FieldComponent
{
    protected $rules = [
        'cardToken' => 'required',
    ];

    private CartRepositoryInterface $quoteRepository;

    private SessionCheckout $sessionCheckout;

    private ResolverInterface $localeResolver;

    private Config $config;

    public string $profileId = '';

    public bool $isTestMode = false;

    public string $locale = '';

    public string $cardToken = '';

    public function __construct(
        SessionCheckout $sessionCheckout,
        CartRepositoryInterface $quoteRepository,
        ResolverInterface $localeResolver,
        Config $config
    ) {
        $this->sessionCheckout = $sessionCheckout;
        $this->quoteRepository = $quoteRepository;
        $this->localeResolver = $localeResolver;
        $this->config = $config;
    }

    public function getProfileId(): string
    {
        return (string)$this->config->getProfileId();
    }

    public function isTestMode(): bool
    {
        return $this->config->isTestMode();
    }

    public function isComponentsEnabled(): bool
    {
        return $this->config->creditcardUseComponents() && $this->config->getProfileId();
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        $locale = $this->config->getLocale();

        // Empty == autodetect, so use the store.
        if (!$locale || $locale == 'store') {
            return $this->localeResolver->getLocale();
        }

        return $locale;
    }

    public function getFieldName(): string
    {
        return 'mollie_creditcard'; // @todo
    }

    public function getFieldLabel(): string
    {
        return (string)__('Creditcard'); // @todo
    }

    public function save($value): void
    {
        $quote = $this->sessionCheckout->getQuote();
        $quote->getPayment()->setAdditionalInformation('card_token', $value);
        $quote->getPayment()->setAdditionalInformation('is_active_payment_token_enabler', true);

        $this->quoteRepository->save($quote);
    }
}
