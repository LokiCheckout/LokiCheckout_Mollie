<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Plugin;

use Magento\Framework\Component\ComponentRegistrar;
use Mollie\Payment\Helper\General as GeneralHelper;
use Yireo\LokiCheckout\ViewModel\PaymentMethodIcon;

class PaymentMethodIconPlugin
{
    public function __construct(
        private ComponentRegistrar $componentRegistrar,
        private GeneralHelper $mollieGeneralHelper
    ) {
    }

    public function afterGetIcon(
        PaymentMethodIcon $paymentMethodIcon,
        string $result,
        string $paymentMethodCode
    ): string {
        // @todo: Make sure Mollie_Payment is enabled

        if (false === (bool)$this->mollieGeneralHelper->useImage()) {
            return $result;
        }

        if (preg_match('/^mollie_methods_(.*)$/', $paymentMethodCode, $match)) {
            return $result;
        };

        $modulePath = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, 'Mollie_Payment');
        $iconFilePath = $modulePath . '/view/frontend/web/images/methods/'.$match[1].'.svg';
        if (false === file_exists($iconFilePath)) {
            return $result;
        }

        return file_get_contents($iconFilePath);
    }
}
