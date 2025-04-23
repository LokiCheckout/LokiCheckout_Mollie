<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Payment\Redirect;

use Magento\Payment\Helper\Data;
use Mollie\Payment\Model\Methods\CreditcardVault;
use Mollie\Payment\Model\Mollie;
use Mollie\Payment\Service\Mollie\Order\RedirectUrl as MollieRedirectUrl;
use Yireo\LokiCheckout\Payment\Redirect\RedirectResolverInterface;
use Yireo\LokiCheckout\Step\FinalStep\RedirectContext;

class RedirectResolver implements RedirectResolverInterface
{
    public function __construct(
        private MollieRedirectUrl $redirectUrl,
        private Data $paymentHelper,
    ) {
    }

    public function resolve(RedirectContext $redirectContext): false|string
    {
        $paymentMethod = $redirectContext->getPaymentMethod();
        if (false === $paymentMethod instanceof Mollie) {
            return false;
        }

        if ($paymentMethod instanceof CreditcardVault) {
            $paymentMethod = $this->paymentHelper->getMethodInstance('mollie_methods_creditcard');
        }

        return $this->redirectUrl->execute($paymentMethod, $redirectContext->getOrder());
    }
}
