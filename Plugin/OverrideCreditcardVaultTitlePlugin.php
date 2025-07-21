<?php declare(strict_types=1);

namespace LokiCheckout\Mollie\Plugin;

class OverrideCreditcardVaultTitlePlugin
{
    public function afterGetTitle(\Mollie\Payment\Model\Methods\CreditcardVault $subject, string $title): string
    {
        return (string)__('Saved Credit Card');
    }
}
