<?php
declare(strict_types=1);

namespace LokiCheckout\Mollie\Component\Checkout\Payment\Method\Creditcard;

use LokiCheckout\Core\Component\Base\Generic\CheckoutViewModel;
use LokiCheckout\Mollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 */
class CreditcardViewModel extends CheckoutViewModel
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
            'savedCardsEnabled' => $this->isSavedCardsEnabled(),
            'selectedMandateId' => $this->getSelectedMandateId(),
            'storedMandateId' => (string)$this->getContext()->getCheckoutState()->getQuote()->getPayment()
                ->getAdditionalInformation(CreditcardRepository::MANDATE_ID),
            'saveCard' => $this->isSaveCard(),
        ];
    }

    public function isSavedCardsEnabled(): bool
    {
        return $this->getContext()->getSavedCardProvider()->isAvailable();
    }

    public function getMandates(): array
    {
        return $this->getContext()->getSavedCardProvider()->getMandates();
    }

    public function getSelectedMandateId(): string
    {
        if (false === $this->isSavedCardsEnabled()) {
            return '';
        }

        $payment = $this->getContext()->getCheckoutState()->getQuote()->getPayment();
        $mandateId = (string)$payment->getAdditionalInformation(CreditcardRepository::MANDATE_ID);
        if ($mandateId !== '' && null !== $this->getContext()->getSavedCardProvider()->getMandateById($mandateId)) {
            return $mandateId;
        }

        if ((string)$payment->getAdditionalInformation(CreditcardRepository::CARD_TOKEN) !== '') {
            return '';
        }

        $mandates = $this->getMandates();
        if (empty($mandates)) {
            return '';
        }

        return (string)$mandates[0]['mandate_id'];
    }

    public function isSaveCard(): bool
    {
        $payment = $this->getContext()->getCheckoutState()->getQuote()->getPayment();
        return (bool)$payment->getAdditionalInformation(CreditcardRepository::SAVE_CARD);
    }

    public function getConsentText(): string
    {
        return $this->getContext()->getSavedCardProvider()->getConsentText();
    }

    public function getCardLogoUrl(array $mandate): string
    {
        if (empty($mandate['card_type'])) {
            return '';
        }

        return $this->getBlock()->getViewFileUrl('Mollie_Payment::images/cards/'.$mandate['card_type'].'.svg');
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
    }
}
