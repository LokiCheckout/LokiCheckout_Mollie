<?php
declare(strict_types=1);

namespace LokiCheckout\Mollie\Plugin;

use Magento\Customer\Model\Session;
use Magento\Quote\Api\PaymentMethodManagementInterface;
use LokiCheckout\Core\Payment\Vault\PaymentTokenProvider;

class HideCreditcardVault
{
    public function __construct(
        private Session $customerSession,
        private PaymentTokenProvider $paymentTokenProvider
    ) {
    }

    public function afterGetList(PaymentMethodManagementInterface $subject, $result, $cartId): array
    {
        if ($this->shouldDisplayVault()) {
            return $result;
        }

        return array_filter($result, function ($method) {
            return $method->getCode() !== 'mollie_methods_creditcard_vault';
        });
    }

    private function shouldDisplayVault(): bool
    {
        if (!$this->customerSession->isLoggedIn()) {
            return false;
        }

        $paymentTokens = $this->paymentTokenProvider->getAll();
        if (empty($paymentTokens)) {
            return false;
        }

        return true;
    }
}
