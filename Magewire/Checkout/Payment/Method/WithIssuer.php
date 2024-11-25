<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Magewire\Checkout\Payment\Method;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Api\CartRepositoryInterface;
use Magewirephp\Magewire\Component;
use Mollie\Payment\Config as MollieConfig;
use Mollie\Payment\Service\Mollie\GetIssuers;
use Mollie\Payment\Service\Mollie\MollieApiClient;
use Yireo\LokiCheckout\Util\CurrentTheme;

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
        private CurrentTheme $currentTheme,
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
            $this->switchTemplate($this->getTemplatePrefix() . '/none.phtml');
        }

        if ($listType == 'dropdown') {
            $this->switchTemplate( $this->getTemplatePrefix() . '/dropdown.phtml');
        }

        $this->switchTemplate($this->getTemplatePrefix() . '/list.phtml');
    }

    public function updatedSelectedIssuer(string $value): ?string
    {
        $quote = $this->checkoutSession->getQuote();
        $quote->getPayment()->setAdditionalInformation('selected_issuer', $value);
        $this->quoteRepository->save($quote);

        return $value;
    }

    private function getTemplatePrefix(): string
    {
        if ($this->currentTheme->isHyva()) {
            return 'Yireo_LokiCheckoutMollie::hyva/method/issuer/';
        }

        return 'Yireo_LokiCheckoutMollie::luma/method/issuer/';
    }
}
