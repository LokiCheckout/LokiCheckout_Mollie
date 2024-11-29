<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Service\Vault;

use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Vault\Api\Data\PaymentTokenInterface;
use Magento\Vault\Api\PaymentTokenRepositoryInterface;

class GetSavedCards
{
    public function __construct(
        private SearchCriteriaBuilderFactory    $searchCriteriaBuilderFactory,
        private PaymentTokenRepositoryInterface $paymentTokenRepository,
        private SerializerInterface             $serializer,
        private Session                         $customerSession
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

        $search = $this->searchCriteriaBuilderFactory->create();
        $search->addFilter(PaymentTokenInterface::IS_VISIBLE, 1);
        $search->addFilter(PaymentTokenInterface::IS_ACTIVE, 1);
        $search->addFilter(PaymentTokenInterface::CUSTOMER_ID, $this->customerSession->getCustomerId());
        $search->addFilter(PaymentTokenInterface::PAYMENT_METHOD_CODE, 'mollie_methods_creditcard');

        $output = [];
        $items = $this->paymentTokenRepository->getList($search->create())->getItems();
        foreach ($items as $item) {
            $details = $this->serializer->unserialize($item->getTokenDetails());
            $details['public_hash'] = $item->getPublicHash();

            $output[] = $details;
        }

        return $output;
    }
}
