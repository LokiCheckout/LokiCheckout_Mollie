<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Plugin;

use Magento\Framework\Component\ComponentRegistrar;
use Yireo\LokiCheckout\ViewModel\PaymentMethodIcon;

class PaymentMethodIconPlugin
{
    public function __construct(
        private ComponentRegistrar $componentRegistrar
    ) {
    }

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

        $modulePath = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, 'Mollie_Payment');
        $iconFilePath = $modulePath . '/view/frontend/web/images/methods/'.$match[1].'.svg';
        if (false === file_exists($iconFilePath)) {
            return $result;
        }

        return file_get_contents($iconFilePath);
    }
}
