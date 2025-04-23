<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\CreditcardVault;

use Yireo\LokiCheckout\Component\Base\Generic\CheckoutViewModel;
use Yireo\LokiCheckoutMollie\Component\MollieContext;

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
