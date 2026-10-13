<?php
declare(strict_types=1);

namespace LokiCheckout\Mollie\Component\Checkout\Payment\Method\Creditcard;

use Loki\Field\Component\Base\Field\FieldRepository;
use LokiCheckout\Mollie\Component\MollieContext;
use Magento\Quote\Model\Quote\Payment;

/**
 * @method MollieContext getContext()
 */
class CreditcardRepository extends FieldRepository
{
    public const CARD_TOKEN = 'card_token';
    public const MANDATE_ID = 'mollie_mandate_id';
    public const SAVE_CARD = 'mollie_save_card';
    public const CONSENT_TIMESTAMP = 'mollie_consent_timestamp';

    public function getValue(): mixed
    {
        $mandateId = (string)$this->getPayment()->getAdditionalInformation(self::MANDATE_ID);
        if ($mandateId !== '') {
            return $mandateId;
        }

        return null;
    }

    public function saveValue(mixed $value): void
    {
        if (false === is_array($value)) {
            return;
        }

        if (array_key_exists('mandate_id', $value)) {
            $this->saveMandateId((string)$value['mandate_id']);
        }

        if (array_key_exists('token', $value)) {
            $this->saveCardToken((string)$value['token']);
        }

        if (array_key_exists('save_card', $value)) {
            $this->saveSaveCard((bool)$value['save_card']);
        }
    }

    private function saveMandateId(string $mandateId): void
    {
        $payment = $this->getPayment();
        $savedCardProvider = $this->getContext()->getSavedCardProvider();

        if ($mandateId === '' || null === $savedCardProvider->getMandateById($mandateId)) {
            $payment->unsAdditionalInformation(self::MANDATE_ID);
            return;
        }

        $payment->setAdditionalInformation(self::MANDATE_ID, $mandateId);
        $payment->unsAdditionalInformation(self::CARD_TOKEN);
        $payment->unsAdditionalInformation(self::SAVE_CARD);
        $payment->unsAdditionalInformation(self::CONSENT_TIMESTAMP);
    }

    private function saveCardToken(string $cardToken): void
    {
        $payment = $this->getPayment();
        $payment->setAdditionalInformation(self::CARD_TOKEN, $cardToken);
        $payment->unsAdditionalInformation(self::MANDATE_ID);

        if (false === $this->getContext()->getSavedCardProvider()->isSupported()) {
            $payment->setAdditionalInformation('is_active_payment_token_enabler', true);
        }
    }

    private function saveSaveCard(bool $saveCard): void
    {
        $payment = $this->getPayment();
        if (false === $saveCard || false === $this->getContext()->getSavedCardProvider()->isAvailable()) {
            $payment->unsAdditionalInformation(self::SAVE_CARD);
            $payment->unsAdditionalInformation(self::CONSENT_TIMESTAMP);
            return;
        }

        $payment->setAdditionalInformation(self::SAVE_CARD, true);
        $payment->setAdditionalInformation(self::CONSENT_TIMESTAMP, (new \DateTime())->format(DATE_ATOM));
    }

    private function getPayment(): Payment
    {
        return $this->getContext()->getCheckoutState()->getQuote()->getPayment();
    }
}
