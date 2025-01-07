<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component;

use Magento\Framework\Locale\ResolverInterface as LocaleResolver;
use Magento\Framework\UrlFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mollie\Payment\Config as MollieConfig;
use Yireo\LokiCheckout\Component\Base\Generic\GenericContext;
use Yireo\LokiComponents\Component\Behaviour\InheritFromParentContext;
use Yireo\LokiComponents\Component\ComponentContextInterface;

class MollieContext implements ComponentContextInterface
{
    use InheritFromParentContext;

    public function __construct(
        private readonly GenericContext $parentContext,
        private readonly StoreManagerInterface $storeManager,
        private readonly MollieConfig $mollieConfig,
        private readonly UrlFactory $urlFactory,
        private readonly LocaleResolver $localeResolver,
    ) {
    }

    public function getStoreManager(): StoreManagerInterface
    {
        return $this->storeManager;
    }

    public function getMollieConfig(): MollieConfig
    {
        return $this->mollieConfig;
    }

    public function createUrl(): UrlInterface
    {
        return $this->urlFactory->create();
    }

    public function getLocaleResolver(): LocaleResolver
    {
        return $this->localeResolver;
    }
}
