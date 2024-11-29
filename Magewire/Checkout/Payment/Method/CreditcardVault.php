<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Magewire\Checkout\Payment\Method;

use Magento\Checkout\Model\Session as SessionCheckout;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Vault\Api\Data\PaymentTokenInterface;
use Magewirephp\Magewire\Component;
use Yireo\LokiCheckoutMollie\Service\Vault\GetSavedCards;

class CreditcardVault extends Component
{
    public string $hash = '';

    public function __construct(
        private SessionCheckout         $sessionCheckout,
        private CartRepositoryInterface $quoteRepository,
        private GetSavedCards           $getSavedCards
    ) {
    }

    /**
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function mount(): void
    {
        $quote = $this->sessionCheckout->getQuote();
        $this->hash = $quote->getPayment()->getAdditionalInformation(PaymentTokenInterface::PUBLIC_HASH);
    }

    /**
     * @return array
     */
    public function getSavedCards(): array
    {
        return $this->getSavedCards->execute();
    }

    /**
     * @param string $value
     *
     * @return mixed
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function updatedHash(string $hash): string
    {
        $quote = $this->sessionCheckout->getQuote();
        $quote->getPayment()->setAdditionalInformation(PaymentTokenInterface::PUBLIC_HASH, $hash);
        $quote->getPayment()->setAdditionalInformation(PaymentTokenInterface::CUSTOMER_ID, $quote->getCustomerId());

        $this->quoteRepository->save($quote);

        return $hash;
    }
}
