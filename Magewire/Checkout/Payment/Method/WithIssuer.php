<?php
declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Magewire\Checkout\Payment\Method;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Api\CartRepositoryInterface;
use Mollie\Payment\Config as MollieConfig;
use Mollie\Payment\Service\Mollie\GetIssuers;
use Mollie\Payment\Service\Mollie\MollieApiClient;
use Yireo\LokiCheckout\Magewire\Form\Field\FieldComponent;
use Yireo\LokiCheckout\Magewire\Form\Field\FieldComponentBehaviour\StepBehaviour;
use Yireo\LokiCheckout\Magewire\Generic\Behaviour\AlpineDataBehaviour;
use Yireo\LokiCheckout\Util\CurrentTheme;

class WithIssuer extends FieldComponent
{
    use StepBehaviour;
    use AlpineDataBehaviour;

    public array $issuers = [];

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
        $this->issuers = $this->getIssuers();

        $quote = $this->checkoutSession->getQuote();
        if ($selectedIssuer = $quote->getPayment()->getAdditionalInformation('selected_issuer')) {
            $this->value = $selectedIssuer;
        }

        if (!empty($this->value)) {
            $this->valid = true;
        }
    }

    private function getIssuers(): array
    {
        $mollieApiClient = $this->mollieApiClient->loadByStore();
        $method = 'mollie_methods_'.$this->getPaymentMethod();
        return (array) $this->getIssuers->execute($mollieApiClient, $method, 'list');
    }

    public function getPaymentMethod(): string
    {
        return (string) $this->checkoutSession->getQuote()->getPayment()->getMethod();
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

    private function getTemplatePrefix(): string
    {
        if ($this->currentTheme->isHyva()) {
            return 'Yireo_LokiCheckoutMollie::hyva/method/issuer/';
        }

        return 'Yireo_LokiCheckoutMollie::luma/method/issuer/';
    }

    public function isRequired(): bool
    {
        return count($this->issuers) > 0;
    }

    public function getFieldLabel(): string
    {
        return (string)__('Issuer');
    }

    public function save($value): void
    {
        $this->valid = true;
        $quote = $this->checkoutSession->getQuote();
        $quote->getPayment()->setAdditionalInformation('selected_issuer', $value);
        $this->quoteRepository->save($quote);
    }
}
