<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Plugin;

class OverrideCreditcardVaultTitlePlugin
{
    public function afterGetTitle(\Mollie\Payment\Model\Methods\CreditcardVault $subject, string $title): string
    {
        return $title . ' (saved)';
    }
}
