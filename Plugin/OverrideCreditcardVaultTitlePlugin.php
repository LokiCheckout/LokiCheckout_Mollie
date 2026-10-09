<?php declare(strict_types=1);

namespace LokiCheckout\Mollie\Plugin;

use Magento\Payment\Model\MethodInterface;

class OverrideCreditcardVaultTitlePlugin
{
    public function afterGetTitle(MethodInterface $subject, string $title): string
    {
        return (string)__('Saved Credit Card');
    }
}
