<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\WithIssuer;

use Mollie\Payment\Config as MollieConfig;
use Yireo\LokiCheckout\Component\Base\Generic\GenericContext;
use Yireo\LokiCheckoutMollie\Provider\IssuerProvider;

class WithIssuerContext extends GenericContext
{
    public function getMollieConfig(): MollieConfig
    {
        return $this->get(MollieConfig::class);
    }

    public function getIssuerProvider(): IssuerProvider
    {
        return $this->get(IssuerProvider::class);
    }
}
