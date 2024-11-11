<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Plugin;

use Magento\Payment\Model\MethodInterface as PaymentMethod;
use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Payment\Model\Mollie;
use Mollie\Payment\Service\Mollie\Order\RedirectUrl as MollieRedirectUrl;
use Yireo\LokiCheckout\Step\FinalStep\RedirectUrl;

class MollieRedirectUrlPlugin
{
    public function __construct(
        private MollieRedirectUrl $redirectUrl
    ) {
    }

    /**
     * @param RedirectUrl $subject
     * @param string $result
     * @param PaymentMethod $paymentMethod
     * @param OrderInterface $order
     * @return string
     */
    public function afterGet(
        RedirectUrl $subject,
        string $result,
        PaymentMethod $paymentMethod,
        ?OrderInterface $order = null
    ): string {

        if (false === $paymentMethod instanceof Mollie) {
            return $result;
        }

        if (false === $order instanceof OrderInterface) {
            return $result;
        }

        return $this->redirectUrl->execute($paymentMethod, $order);
    }
}
