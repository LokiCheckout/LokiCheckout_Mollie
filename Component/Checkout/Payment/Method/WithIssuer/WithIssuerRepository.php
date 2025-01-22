<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\WithIssuer;

use Yireo\LokiCheckout\Component\Base\Field\FieldRepository;
use Yireo\LokiCheckoutMollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 */
class WithIssuerRepository extends FieldRepository
{
    public function getIssuers(): array
    {
        return $this->getContext()->getIssuerProvider()->getIssuers($this->getPaymentMethod());
    }

    public function getPaymentMethod(): string
    {
        return (string) $this->getContext()->getCheckoutState()->getQuote()->getPayment()->getMethod();
    }

    public function getValue(): mixed
    {
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        return (string)$quote->getPayment()->getAdditionalInformation('selected_issuer');
    }

    public function saveValue(mixed $value): void
    {
        $value = (string)$value;
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $quote->getPayment()->setAdditionalInformation('selected_issuer', $value);
        $this->getContext()->getCartRepository()->save($quote);
    }
}
