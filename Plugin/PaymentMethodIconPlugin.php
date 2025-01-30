<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Plugin;

use Mollie\Payment\Helper\General as GeneralHelper;
use Yireo\LokiCheckout\ViewModel\PaymentMethodIcon;

class PaymentMethodIconPlugin
{
    public function __construct(
        private GeneralHelper $mollieGeneralHelper
    ) {
    }

    public function afterGetIcon(
        PaymentMethodIcon $paymentMethodIcon,
        string $result,
        string $paymentMethodCode
    ): string {
        if (false === $paymentMethodIcon->isModuleEnabled('Mollie_Payment')) {
            return $result;
        }

        if (false === (bool)$this->mollieGeneralHelper->useImage()) {
            return $result;
        }

        if (!preg_match('/^mollie_methods_(.*)$/', $paymentMethodCode, $match)) {
            return $result;
        }

        $iconFilePath = $paymentMethodIcon->getIconPath(
            'Mollie_Payment',
            'view/frontend/web/images/methods/'.$match[1].'.svg'
        );

        if (false === $iconFilePath) {
            return $result;
        }

        return $paymentMethodIcon->getIconOutput($iconFilePath, 'svg');
    }
}
