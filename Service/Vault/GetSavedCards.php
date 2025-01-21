<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Service\Vault;

use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Vault\Api\Data\PaymentTokenInterface;
use Magento\Vault\Api\PaymentTokenRepositoryInterface;

class GetSavedCards
{
    public function __construct(
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private PaymentTokenRepositoryInterface $paymentTokenRepository,
        private SerializerInterface $serializer,
        private Session $customerSession
    ) {
    }

    /**
     * @return array{
     *      array{
     *          "public_hash": string,
     *          "type": string,
     *          "name": string,
     *          "maskedCC": string,
     *     }
     * }
     */
    public function execute(): array
    {
        if (!$this->customerSession->isLoggedIn()) {
            return [];
        }

        $this->searchCriteriaBuilder->addFilter(PaymentTokenInterface::IS_VISIBLE, 1);
        $this->searchCriteriaBuilder->addFilter(PaymentTokenInterface::IS_ACTIVE, 1);
        $this->searchCriteriaBuilder->addFilter(PaymentTokenInterface::CUSTOMER_ID, $this->customerSession->getCustomerId());
        $this->searchCriteriaBuilder->addFilter(PaymentTokenInterface::PAYMENT_METHOD_CODE, 'mollie_methods_creditcard');

        $output = [];
        $items = $this->paymentTokenRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        foreach ($items as $item) {
            $details = $this->serializer->unserialize($item->getTokenDetails());
            $details['public_hash'] = $item->getPublicHash();

            $output[] = $details;
        }

        return $output;
    }
}
