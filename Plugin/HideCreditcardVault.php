<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Plugin;

use Magento\Customer\Model\Session;
use Magento\Quote\Api\PaymentMethodManagementInterface;
use Yireo\LokiCheckoutMollie\Service\Vault\GetSavedCards;

class HideCreditcardVault
{
    private Session $customerSession;
    private GetSavedCards $getSavedCards;

    public function __construct(
        Session $customerSession,
        GetSavedCards $getSavedCards
    ) {
        $this->customerSession = $customerSession;
        $this->getSavedCards = $getSavedCards;
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

        $savedCards = $this->getSavedCards->execute();
        if (count($savedCards) === 0) {
            return false;
        }

        return true;
    }
}
