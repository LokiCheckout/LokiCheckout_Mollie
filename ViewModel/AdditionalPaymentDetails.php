<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Vault\Api\Data\PaymentTokenInterface;
use Yireo\LokiCheckout\Payment\Vault\PaymentTokenProvider;
use Yireo\LokiCheckout\ViewModel\CheckoutState;
use Yireo\LokiCheckoutMollie\Provider\IssuerProvider;

class AdditionalPaymentDetails implements ArgumentInterface
{
    public function __construct(
        private readonly CheckoutState $checkoutState,
        private IssuerProvider $issuerProvider,
        private PaymentTokenProvider $paymentTokenProvider,
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
