<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Component\Checkout\Payment\Method\CreditcardVault;

use Magento\Vault\Api\Data\PaymentTokenInterface;
use Yireo\LokiCheckout\Component\Base\Field\FieldRepository;

/**
 * @method CreditcardVaultContext getContext()
 */
class CreditcardVaultRepository extends FieldRepository
{
    protected function getData(): mixed
    {
        $quote = $this->getContext()->getQuote();
        return $quote->getPayment()->getAdditionalInformation(PaymentTokenInterface::PUBLIC_HASH);
    }

    protected function saveData(mixed $data): void
    {
        $hash = (string)$data;
        $quote = $this->getContext()->getQuote();
        $quote->getPayment()->setAdditionalInformation(PaymentTokenInterface::PUBLIC_HASH, $hash);
        $quote->getPayment()->setAdditionalInformation(PaymentTokenInterface::CUSTOMER_ID, $quote->getCustomerId());

        $this->getContext()->getCartRepository()->save($quote);
    }
}
