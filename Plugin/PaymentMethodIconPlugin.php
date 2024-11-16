<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Plugin;

use Yireo\LokiCheckout\ViewModel\PaymentMethodIcon;

class PaymentMethodIconPlugin
{
    public function afterGetIcon(
        PaymentMethodIcon $paymentMethodIcon,
        string $result,
        string $paymentMethodCode
    ): string {
        if (false === preg_match('/^mollie_methods_(.*)$/', $paymentMethodCode, $match)) {
            return $result;
        };

        if (empty($match)) {
            return $result;
        }

        $iconFileId = 'Mollie_Payment::images/methods/'.$match[1].'.svg';
        $iconUrl = $paymentMethodIcon->getAssetRepository()->getUrl($iconFileId);

        return '<img src="'.$iconUrl.'" />';
    }
}
