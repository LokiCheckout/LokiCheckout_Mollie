<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Payment\Redirect;

use Mollie\Payment\Model\Mollie;
use Mollie\Payment\Service\Mollie\Order\RedirectUrl as MollieRedirectUrl;
use Yireo\LokiCheckout\Payment\Redirect\RedirectResolverInterface;
use Yireo\LokiCheckout\Step\FinalStep\RedirectContext;

class RedirectResolver implements RedirectResolverInterface
{
    public function __construct(
        private MollieRedirectUrl $redirectUrl
    ) {
    }

    public function resolve(RedirectContext $redirectContext): false|string
    {
        $paymentMethod = $redirectContext->getPaymentMethod();
        if (false === $paymentMethod instanceof Mollie) {
            return false;
        }

        return $this->redirectUrl->execute($paymentMethod, $redirectContext->getOrder());
    }
}
