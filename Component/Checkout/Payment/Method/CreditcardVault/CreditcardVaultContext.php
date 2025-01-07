<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\CreditcardVault;

use Yireo\LokiCheckoutMollie\Component\MollieContext;
use Yireo\LokiCheckoutMollie\Service\Vault\GetSavedCards;
use Yireo\LokiComponents\Component\Behaviour\InheritFromParentContext;
use Yireo\LokiComponents\Component\ComponentContextInterface;

class CreditcardVaultContext implements ComponentContextInterface
{
    use InheritFromParentContext;

    public function __construct(
        private readonly MollieContext $parentContext,
        private readonly GetSavedCards $getSavedCards
    ) {
    }

    public function getSavedCards(): GetSavedCards
    {
        return $this->getSavedCards;
    }
}
