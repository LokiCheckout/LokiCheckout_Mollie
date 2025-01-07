<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\Creditcard;

use Yireo\LokiCheckout\Component\Base\Field\FieldRepository;

/**
 * @method CreditcardContext getContext()
 */
class CreditcardRepository extends FieldRepository
{
    protected function getValue(): mixed
    {
        return null;
    }

    protected function saveValue(mixed $data): void
    {
        $value = (string)$data;
        $quote = $this->getContext()->getQuote();
        $quote->getPayment()->setAdditionalInformation('card_token', $value);
        $quote->getPayment()->setAdditionalInformation('is_active_payment_token_enabler', true);

        $this->getContext()->getCartRepository()->save($quote);
    }
}
