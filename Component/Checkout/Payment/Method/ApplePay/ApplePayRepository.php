<?php
declare(strict_types=1);

namespace LokiCheckout\Mollie\Component\Checkout\Payment\Method\ApplePay;

use Loki\Field\Component\Base\Field\FieldRepository;
use LokiCheckout\Mollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 */
class ApplePayRepository extends FieldRepository
{
    public function getValue(): mixed
    {
        return null;
    }

    public function saveValue(mixed $value): void
    {
        $value = (string)$value;
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $quote->getPayment()->setAdditionalInformation('applepay_payment_token', $value);
    }
}
