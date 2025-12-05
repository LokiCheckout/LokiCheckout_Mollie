<?php
declare(strict_types=1);

namespace LokiCheckout\Mollie\Component\Checkout\Payment\Method\CreditcardVault;

use Magento\Vault\Api\Data\PaymentTokenInterface;
use Loki\Field\Component\Base\Field\FieldRepository;
use LokiCheckout\Mollie\Component\MollieContext;

/**
 * @method MollieContext getContext()
 */
class CreditcardVaultRepository extends FieldRepository
{
    public function getValue(): mixed
    {
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        return $quote->getPayment()->getAdditionalInformation(PaymentTokenInterface::PUBLIC_HASH);
    }

    public function saveValue(mixed $value): void
    {
        $hash = (string)$value;
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $quote->getPayment()->setAdditionalInformation(PaymentTokenInterface::PUBLIC_HASH, $hash);
        $quote->getPayment()->setAdditionalInformation(PaymentTokenInterface::CUSTOMER_ID, $quote->getCustomerId());
    }
}
