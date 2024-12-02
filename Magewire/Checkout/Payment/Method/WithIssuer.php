<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Magewire\Checkout\Payment\Method;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Api\CartRepositoryInterface;
use Magewirephp\Magewire\Component;
use Mollie\Payment\Config as MollieConfig;
use Mollie\Payment\Service\Mollie\GetIssuers;
use Mollie\Payment\Service\Mollie\MollieApiClient;
use Yireo\LokiCheckout\Magewire\Form\Field\FieldComponentBehaviour\StepBehaviour;
use Yireo\LokiCheckout\Util\CurrentTheme;

class WithIssuer extends Component
{
    use StepBehaviour;

    public array $issuers = [];
    public string $issuer = '';

    public function __construct(
        private CheckoutSession $checkoutSession,
        private CartRepositoryInterface $quoteRepository,
        private MollieApiClient $mollieApiClient,
        private GetIssuers $getIssuers,
        private MollieConfig $mollieConfig,
        private CurrentTheme $currentTheme,
    ) {
    }

    public function boot(): void
    {
        $mollieApiClient = $this->mollieApiClient->loadByStore();
        $method = $this->getPaymentMethod();
        $this->issuers = $this->getIssuers->execute($mollieApiClient, $method, 'list');

        $quote = $this->checkoutSession->getQuote();
        if ($selectedIssuer = $quote->getPayment()->getAdditionalInformation('selected_issuer')) {
            $this->issuer = $selectedIssuer;
        }
    }

    public function getPaymentMethod(): string
    {
        return str_replace('mollie_methods_', '', (string)$this->getParent()->getMethod());
    }

    public function getChildTemplate(): string
    {
        $method = $this->getPaymentMethod();
        $listType = $this->mollieConfig->getIssuerListType($method);
        if ($listType == 'none') {
            return $this->getTemplatePrefix().'/none.phtml';
        }

        if ($listType == 'dropdown') {
            return $this->getTemplatePrefix().'/dropdown.phtml';
        }

        return $this->getTemplatePrefix().'/list.phtml';
    }

    public function saveIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
        $quote = $this->checkoutSession->getQuote();
        $quote->getPayment()->setAdditionalInformation('selected_issuer', $issuer);
        $this->quoteRepository->save($quote);
    }

    private function getTemplatePrefix(): string
    {
        if ($this->currentTheme->isHyva()) {
            return 'Yireo_LokiCheckoutMollie::hyva/method/issuer/';
        }

        return 'Yireo_LokiCheckoutMollie::luma/method/issuer/';
    }
}
