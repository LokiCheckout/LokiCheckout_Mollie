<?php
declare(strict_types=1);

namespace LokiCheckout\Mollie\Component\Checkout\Payment\Method\CreditcardVault;

use LokiCheckout\Core\Component\Base\Generic\CheckoutViewModel;
use LokiCheckout\Mollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 */
class CreditcardVaultViewModel extends CheckoutViewModel
{
    /**
     * @return array
     */
    public function getNormalizedPaymentTokens(): array
    {
        return $this->getContext()->getPaymentTokenProvider()->getAllNormalized();
    }

    public function getFieldLabel(): string
    {
        return 'Creditcard';
    }
}
