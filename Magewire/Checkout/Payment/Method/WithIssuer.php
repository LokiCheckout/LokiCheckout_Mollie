<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Magewire\Checkout\Payment\Method;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Api\CartRepositoryInterface;
use Magewirephp\Magewire\Component;
use Mollie\Payment\Config as MollieConfig;
use Mollie\Payment\Service\Mollie\GetIssuers;
use Mollie\Payment\Service\Mollie\MollieApiClient;

class WithIssuer extends Component
{
    public array $issuers = [];

    public string $selectedIssuer = '';

    public function __construct(
        private CheckoutSession $checkoutSession,
        private CartRepositoryInterface $quoteRepository,
        private MollieApiClient $mollieApiClient,
        private GetIssuers $getIssuers,
        private MollieConfig $mollieConfig,
    ) {
    }

    public function mount(): void
    {
        $mollieApiClient = $this->mollieApiClient->loadByStore();
        $method = str_replace('mollie_methods_', '', (string)$this->getParent()->getMethod());
        $this->issuers = $this->getIssuers->execute($mollieApiClient, $method, 'list');

        $quote = $this->checkoutSession->getQuote();
        if ($selectedIssuer = $quote->getPayment()->getAdditionalInformation('selected_issuer')) {
            $this->selectedIssuer = $selectedIssuer;
        }

        $listType = $this->mollieConfig->getIssuerListType($method);
        if ($listType == 'none') {
            $this->switchTemplate('Yireo_LokiCheckoutMollie::method/issuer/none.phtml');
        }

        if ($listType == 'dropdown') {
            $this->switchTemplate( 'Yireo_LokiCheckoutMollie::method/issuer/dropdown.phtml');
        }

        $this->switchTemplate('Yireo_LokiCheckoutMollie::method/issuer/list.phtml');
    }

    public function updatedSelectedIssuer(string $value): ?string
    {
        $quote = $this->checkoutSession->getQuote();
        $quote->getPayment()->setAdditionalInformation('selected_issuer', $value);
        $this->quoteRepository->save($quote);

        return $value;
    }
}
