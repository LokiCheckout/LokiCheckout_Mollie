<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\CreditcardVault;

use Yireo\LokiCheckout\Component\Base\Field\FieldViewModel;
use Yireo\LokiCheckoutMollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 */
class CreditcardVaultViewModel extends FieldViewModel
{
    /**
     * @return array
     */
    public function getSavedCards(): array
    {
        return $this->getContext()->getSavedCards()->execute();
    }

    public function getFieldLabel(): string
    {
        return 'Creditcard';
    }
}
