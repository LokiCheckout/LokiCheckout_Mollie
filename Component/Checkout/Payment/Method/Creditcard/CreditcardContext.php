<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\Creditcard;

use Magento\Framework\Locale\ResolverInterface as LocaleResolver;
use Mollie\Payment\Config as MollieConfig;
use Yireo\LokiCheckout\Component\Base\Generic\GenericContext;

class CreditcardContext extends GenericContext
{
    public function getMollieConfig(): MollieConfig
    {
        return $this->get(MollieConfig::class);
    }

    public function getLocaleResolver(): LocaleResolver
    {
        return $this->get(LocaleResolver::class);
    }
}
