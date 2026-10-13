<?php declare(strict_types=1);

namespace LokiCheckout\Mollie\Provider;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mollie\Payment\Config as MollieConfig;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Saved cards (Mollie mandates) as introduced in mollie/magento2 3.x
 */
class SavedCardProvider
{
    private const GET_CUSTOMER_MANDATES_CLASS = 'Mollie\Payment\Service\Mollie\GetCustomerMandates';
    private const SAVED_CARD_CONSENT_TEXT_CLASS = 'Mollie\Payment\Service\Mollie\SavedCardConsentText';

    private const CARD_SLUGS = [
        'Visa' => 'visa',
        'Mastercard' => 'mastercard',
        'American Express' => 'amex',
        'Maestro' => 'maestro',
        'Carte Bancaire' => 'cartebancaire',
        'V PAY' => 'vpay',
    ];

    private ?array $mandates = null;

    public function __construct(
        private readonly ObjectManagerInterface $objectManager,
        private readonly CustomerSession $customerSession,
        private readonly StoreManagerInterface $storeManager,
        private readonly MollieConfig $mollieConfig,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function isSupported(): bool
    {
        return class_exists(self::GET_CUSTOMER_MANDATES_CLASS);
    }

    public function isAvailable(): bool
    {
        if (false === $this->isSupported()) {
            return false;
        }

        if (false === $this->customerSession->isLoggedIn()) {
            return false;
        }

        $storeId = $this->getStoreId();
        if (false === $this->mollieConfig->creditcardEnableCustomersApi($storeId)) {
            return false;
        }

        return $this->mollieConfig->isProductionMode($storeId);
    }

    /**
     * @return array<int, array{
     *     mandate_id: string,
     *     card_label: string,
     *     card_number_last4: string,
     *     card_expiry_date: ?string,
     *     card_holder: ?string,
     *     card_type: ?string
     * }>
     */
    public function getMandates(): array
    {
        if (is_array($this->mandates)) {
            return $this->mandates;
        }

        $this->mandates = [];
        if (false === $this->isAvailable()) {
            return $this->mandates;
        }

        try {
            $getCustomerMandates = $this->objectManager->get(self::GET_CUSTOMER_MANDATES_CLASS);
            $mandates = (array)$getCustomerMandates->execute(
                (int)$this->customerSession->getCustomerId(),
                $this->getStoreId()
            );
        } catch (Throwable $exception) {
            $this->logger->error('Unable to load Mollie saved cards: '.$exception->getMessage());
            return $this->mandates;
        }

        foreach ($mandates as $mandate) {
            $cardLabel = (string)($mandate['card_label'] ?? '');
            $mandate['card_type'] = self::CARD_SLUGS[$cardLabel] ?? null;
            $this->mandates[] = $mandate;
        }

        return $this->mandates;
    }

    public function hasMandates(): bool
    {
        return count($this->getMandates()) > 0;
    }

    public function getMandateById(string $mandateId): ?array
    {
        if ($mandateId === '') {
            return null;
        }

        foreach ($this->getMandates() as $mandate) {
            if ($mandate['mandate_id'] === $mandateId) {
                return $mandate;
            }
        }

        return null;
    }

    public function getConsentText(): string
    {
        if (false === $this->isAvailable() || false === class_exists(self::SAVED_CARD_CONSENT_TEXT_CLASS)) {
            return '';
        }

        try {
            $savedCardConsentText = $this->objectManager->get(self::SAVED_CARD_CONSENT_TEXT_CLASS);
            return (string)$savedCardConsentText->execute($this->getStoreId());
        } catch (Throwable $exception) {
            $this->logger->error('Unable to load Mollie saved card consent text: '.$exception->getMessage());
            return '';
        }
    }

    private function getStoreId(): int
    {
        return (int)$this->storeManager->getStore()->getId();
    }
}
