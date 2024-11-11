<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Yireo\LokiCheckout\Magewire\Checkout\BillingStep\PaymentMethods;

class OverrideDefaultPayment
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    public function afterGetDefaultPayment(PaymentMethods $subject, string $result): string
    {
        $defaultMethod = $this->scopeConfig->getValue('payment/mollie_general/default_selected_method');
        $defaultMethod = trim((string)$defaultMethod);
        if (empty($defaultMethod)) {
            return $result;
        }

        return $defaultMethod;
    }
}
