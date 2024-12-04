<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Magewire\Checkout\Payment\Method;

use Magento\Checkout\Model\Session as SessionCheckout;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Mollie\Payment\Config as MollieConfig;
use Yireo\LokiCheckout\Magewire\Form\Field\FieldComponent;

class Creditcard extends FieldComponent
{
    public function __construct(
        private SessionCheckout $sessionCheckout,
        private CartRepositoryInterface $quoteRepository,
        private ResolverInterface $localeResolver,
        private MollieConfig $mollieConfig
    ) {
    }

    public function boot(): void
    {
        if (false === $this->mollieConfig->creditcardUseComponents() || false === $this->mollieConfig->getProfileId()) {
            $this->visible = false;
        }

        parent::boot();
    }

    public function getProfileId(): string
    {
        return (string)$this->mollieConfig->getProfileId();
    }

    public function isTestMode(): bool
    {
        return (bool)$this->mollieConfig->isTestMode();
    }

    public function getLocale(): string
    {
        $locale = $this->mollieConfig->getLocale();

        if (empty($locale) || $locale == 'store') {
            return $this->localeResolver->getLocale();
        }

        return $locale;
    }

    public function getFieldName(): string
    {
        return 'mollie_creditcard';
    }

    public function getFieldLabel(): string
    {
        return (string)__('Creditcard');
    }

    public function isRequired(): bool
    {
        return true;
    }

    public function save($value): void
    {
        $quote = $this->sessionCheckout->getQuote();
        $quote->getPayment()->setAdditionalInformation('card_token', $value);
        $quote->getPayment()->setAdditionalInformation('is_active_payment_token_enabler', true);

        $this->quoteRepository->save($quote);
    }
}
