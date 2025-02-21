<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\Creditcard;

use Yireo\LokiCheckout\Component\Base\Field\FieldViewModel;
use Yireo\LokiCheckoutMollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 */
class CreditcardViewModel extends FieldViewModel
{
    public function isAllowRendering(): bool
    {
        if (false === $this->getContext()->getMollieConfig()->creditcardUseComponents()) {
            return false;
        }

        if (false === $this->getContext()->getMollieConfig()->getProfileId()) {
            return false;
        }

        return true;
    }

    public function getJsComponentName(): ?string
    {
        return 'LokiCheckoutMollieCreditcard';
    }

    public function getJsData(): array
    {
        return [
            'profileId' => $this->getProfileId(),
            'testMode' => $this->isTestMode(),
            'locale' => $this->getLocale(),
        ];
    }

    private function getProfileId(): string
    {
        return (string)$this->getContext()->getMollieConfig()->getProfileId();
    }

    private function isTestMode(): bool
    {
        return (bool)$this->getContext()->getMollieConfig()->isTestMode();
    }

    private function getLocale(): string
    {
        $locale = $this->getContext()->getMollieConfig()->getLocale();

        if (empty($locale) || $locale == 'store') {
            return $this->getContext()->getLocaleResolver()->getLocale();
        }

        return $locale;
    }

    public function getFieldName(): string
    {
        return 'mollie_creditcard';
    }

    public function getFieldLabel(): string
    {
        return 'Creditcard';
    }

    public function isRequired(): bool
    {
        return true;
    }

    public function save($value): void
    {
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $quote->getPayment()->setAdditionalInformation('card_token', $value);
        $quote->getPayment()->setAdditionalInformation('is_active_payment_token_enabler', true);

        $this->getContext()->getCartRepository()->save($quote);
    }
}
