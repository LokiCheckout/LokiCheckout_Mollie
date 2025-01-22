<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\WithIssuer;

use Yireo\LokiCheckout\Component\Base\Field\FieldViewModel;
use Yireo\LokiCheckout\Exception\TemplateNotFoundException;
use Yireo\LokiCheckoutMollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 * @method WithIssuerRepository getRepository()
 */
class WithIssuerViewModel extends FieldViewModel
{
    public function getIssuers(): array
    {
        return $this->getRepository()->getIssuers();
    }

    public function getPaymentMethod(): string
    {
        return $this->getRepository()->getPaymentMethod();
    }

    public function getChildTemplate(): string
    {
        $method = $this->getPaymentMethod();
        $listType = $this->getContext()->getMollieConfig()->getIssuerListType($method);

        $childTemplates = $this->getBlock()->getChildTemplate();
        if ($listType === 'radio') {
            $listType = 'list';
        }

        if (isset($childTemplates[$listType])) {
            return $childTemplates[$listType];
        }

        throw new TemplateNotFoundException('No child template "'.$listType.'" found for block "'.$this->getComponentName().'"');
    }

    public function isRequired(): bool
    {
        return $this->hasIssuers();
    }

    public function hasIssuers():bool
    {
        return count($this->getIssuers()) > 0;
    }

    public function getFieldLabel(): string
    {
        return (string)__('Issuer');
    }
}
