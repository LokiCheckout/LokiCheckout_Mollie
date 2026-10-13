<?php declare(strict_types=1);

namespace LokiCheckout\Mollie\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Vault\Api\Data\PaymentTokenInterface;
use LokiCheckout\Core\Payment\Vault\PaymentTokenProvider;
use LokiCheckout\Core\ViewModel\CheckoutState;
use LokiCheckout\Mollie\Component\Checkout\Payment\Method\Creditcard\CreditcardRepository;
use LokiCheckout\Mollie\Provider\IssuerProvider;
use LokiCheckout\Mollie\Provider\SavedCardProvider;

class AdditionalPaymentDetails implements ArgumentInterface
{
    public function __construct(
        private readonly CheckoutState $checkoutState,
        private IssuerProvider $issuerProvider,
        private PaymentTokenProvider $paymentTokenProvider,
        private SavedCardProvider $savedCardProvider,
    ) {
    }

    public function getAdditionalHtml(): string
    {
        $quote = $this->checkoutState->getQuote();
        $paymentMethodCode = $quote->getPayment()->getMethod();
        if (!preg_match('/^mollie_methods_(.*)$/', $paymentMethodCode, $match)) {
            return '';
        }

        $issuerLabel = $this->getIssuerLabel();
        if (!empty($issuerLabel)) {
            return $issuerLabel;
        }

        $savedCardInfo = $this->getSavedCardInfo();
        if (!empty($savedCardInfo)) {
            return $savedCardInfo;
        }

        $paymentTokenInfo = $this->getPaymentTokenInfo();
        if (!empty($paymentTokenInfo)) {
            return $paymentTokenInfo;
        }

        return '';
    }

    private function getIssuerLabel(): string
    {
        $quote = $this->checkoutState->getQuote();

        $selectedIssuer = $quote->getPayment()->getAdditionalInformation('selected_issuer');
        if (empty($selectedIssuer)) {
            return '';
        }

        $label = $this->issuerProvider->getIssuerLabel($selectedIssuer);
        if (empty($label)) {
            return '';
        }

        return $label;
    }

    private function getSavedCardInfo(): string
    {
        $quote = $this->checkoutState->getQuote();
        $mandateId = (string)$quote->getPayment()->getAdditionalInformation(CreditcardRepository::MANDATE_ID);
        if ($mandateId === '') {
            return '';
        }

        $mandate = $this->savedCardProvider->getMandateById($mandateId);
        if (null === $mandate) {
            return '';
        }

        return $mandate['card_label'] . ' ending with ' . $mandate['card_number_last4'];
    }

    private function getPaymentTokenInfo(): string
    {
        $quote = $this->checkoutState->getQuote();
        $publicHash = $quote->getPayment()->getAdditionalInformation(PaymentTokenInterface::PUBLIC_HASH);
        if (empty($publicHash)) {
            return '';
        }

        $normalizedPaymentToken = $this->paymentTokenProvider->getByHash($publicHash);
        return $normalizedPaymentToken->getName() . ' ending with '.$normalizedPaymentToken->getHint();
    }
}
