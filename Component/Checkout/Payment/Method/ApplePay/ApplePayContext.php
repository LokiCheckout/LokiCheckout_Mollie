<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\ApplePay;

use Mollie\Payment\Service\Mollie\ApplePay\SupportedNetworks;
use Yireo\LokiCheckoutMollie\Component\MollieContext;
use Yireo\LokiComponents\Component\Behaviour\InheritFromParentContext;
use Yireo\LokiComponents\Component\ComponentContextInterface;

class ApplePayContext implements ComponentContextInterface
{
    use InheritFromParentContext;

    public function __construct(
        private readonly MollieContext $parentContext,
        private readonly SupportedNetworks $supportedNetworks,
    ) {
    }

    public function getSupportedNetworks(): SupportedNetworks
    {
        return $this->supportedNetworks;
    }
}
