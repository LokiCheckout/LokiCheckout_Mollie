<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\WithIssuer;

use Yireo\LokiCheckout\Component\Base\Field\FieldRepository;

/**
 * @method WithIssuerContext getContext()
 */
class WithIssuerRepository extends FieldRepository
{
    public function getIssuers(): array
    {
        return $this->getContext()->getIssuerProvider()->getIssuers($this->getPaymentMethod());
    }

    public function getPaymentMethod(): string
    {
        return (string) $this->getContext()->getQuote()->getPayment()->getMethod();
    }

    public function getValue(): mixed
    {
        $quote = $this->getContext()->getQuote();
        return (string)$quote->getPayment()->getAdditionalInformation('selected_issuer');
    }

    public function saveValue(mixed $data): void
    {
        $value = (string)$data;
        $quote = $this->getContext()->getQuote();
        $quote->getPayment()->setAdditionalInformation('selected_issuer', $value);
        $this->getContext()->getCartRepository()->save($quote);
    }
}
