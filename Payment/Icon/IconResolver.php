<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Payment\Icon;

use Magento\Framework\App\State;
use Magento\Framework\Module\Manager as ModuleManager;
use Mollie\Payment\Helper\General as GeneralHelper;
use Yireo\LokiCheckout\Payment\Icon\IconResolverContext;
use Yireo\LokiCheckout\Payment\Icon\IconResolverInterface;

class IconResolver implements IconResolverInterface
{
    public function __construct(
        private ModuleManager $moduleManager,
        private GeneralHelper $mollieGeneralHelper,
        private State $appState
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

        if ($paymentMethodCode === 'mollie_methods_creditcard_vault') {
            $paymentMethodCode = 'mollie_methods_creditcard';
        }

        if (!preg_match('/^mollie_methods_(.*)$/', $paymentMethodCode, $match)) {
            return false;
        }

        //Mollie_Payment/images/creditcard-issuers/mastercard.svg

        $iconFilePath = $iconResolverContext->getIconPath(
            'Mollie_Payment',
            'view/frontend/web/images/methods/'.$match[1].'.svg'
        );

        $iconOutput = $iconResolverContext->getIconOutput($iconFilePath, 'svg');

        if ($this->appState->getMode() === State::MODE_DEVELOPER) {
            $iconOutput .= '<!-- '.$iconFilePath.' -->';
        }

        return $iconOutput;
    }
}
