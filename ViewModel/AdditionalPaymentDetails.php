<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\ViewModel;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Yireo\LokiCheckout\ViewModel\CheckoutState;
use Yireo\LokiCheckoutMollie\Provider\IssuerProvider;

class AdditionalPaymentDetails implements ArgumentInterface
{
    public function __construct(
        private readonly CheckoutState $checkoutState,
        private IssuerProvider $issuerProvider
    ) {
    }

    public function getIssuerLabel(): string
    {
        $quote = $this->checkoutState->getQuote();
        $paymentMethodCode = $quote->getPayment()->getMethod();
        if (false === preg_match('/^mollie_methods_(.*)$/', $paymentMethodCode, $match)) {
            return '';
        };

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
}
