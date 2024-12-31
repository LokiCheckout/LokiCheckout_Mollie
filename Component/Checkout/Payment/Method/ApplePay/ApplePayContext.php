<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\ApplePay;

use Magento\Framework\Url;
use Magento\Framework\UrlFactory;
use Magento\Store\Model\StoreManagerInterface;
use Mollie\Payment\Config as MollieConfig;
use Mollie\Payment\Service\Mollie\ApplePay\SupportedNetworks;
use Yireo\LokiCheckout\Component\Base\Generic\GenericContext;

class ApplePayContext extends GenericContext
{
    public function getStoreManager(): StoreManagerInterface
    {
        return $this->get(StoreManagerInterface::class);
    }

    public function getMollieConfig(): MollieConfig
    {
        return $this->get(MollieConfig::class);
    }

    public function getSupportedNetworks(): SupportedNetworks
    {
        return $this->get(SupportedNetworks::class);
    }

    public function createUrl(): Url
    {
        return $this->get(UrlFactory::class)->create();
    }
}
