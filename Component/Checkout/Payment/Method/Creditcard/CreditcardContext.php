<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\Creditcard;

use Yireo\LokiCheckoutMollie\Component\MollieContext;
use Yireo\LokiComponents\Component\Behaviour\InheritFromParentContext;
use Yireo\LokiComponents\Component\ComponentContextInterface;

class CreditcardContext implements ComponentContextInterface
{
    use InheritFromParentContext;

    public function __construct(
        private readonly MollieContext $parentContext,
    ) {
    }
}
