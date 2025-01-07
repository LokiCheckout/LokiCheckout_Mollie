<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\WithIssuer;

use Yireo\LokiCheckoutMollie\Component\MollieContext;
use Yireo\LokiCheckoutMollie\Provider\IssuerProvider;
use Yireo\LokiComponents\Component\Behaviour\InheritFromParentContext;
use Yireo\LokiComponents\Component\ComponentContextInterface;

class WithIssuerContext implements ComponentContextInterface
{
    use InheritFromParentContext;

    public function __construct(
        private readonly MollieContext $parentContext,
        private readonly IssuerProvider $issuerProvider
    ) {
    }

    public function getIssuerProvider(): IssuerProvider
    {
        return $this->issuerProvider;
    }
}
