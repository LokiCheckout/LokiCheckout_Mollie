<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Payment\Icon;

use Magento\Framework\Module\Manager as ModuleManager;
use Mollie\Payment\Helper\General as GeneralHelper;
use Yireo\LokiCheckout\Payment\Icon\IconResolverContext;
use Yireo\LokiCheckout\Payment\Icon\IconResolverInterface;

class IconResolver implements IconResolverInterface
{
    public function __construct(
        private ModuleManager $moduleManager,
        private GeneralHelper $mollieGeneralHelper,
    ) {
    }

    public function resolve(IconResolverContext $iconResolverContext): false|string
    {
        $paymentMethodCode = $iconResolverContext->getPaymentMethodCode();
        if (false === $this->moduleManager->isEnabled('Mollie_Payment')) {
            return false;
        }

        if (false === (bool)$this->mollieGeneralHelper->useImage()) {
            return false;
        }

        if (!preg_match('/^mollie_methods_(.*)$/', $paymentMethodCode, $match)) {
            return false;
        }

        if ($paymentMethodCode === 'mollie_methods_creditcard_vault') {
            $paymentMethodCode = 'mollie_methods_creditcard';
        }

        $iconFilePath = $iconResolverContext->getIconPath(
            'Mollie_Payment',
            'view/frontend/web/images/methods/'.$match[1].'.svg'
        );

        return $iconResolverContext->getIconOutput($iconFilePath, 'svg');
    }
}
