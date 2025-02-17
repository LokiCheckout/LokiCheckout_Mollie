<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Template;

class RemoveCheckoutConfig implements ObserverInterface
{
    const BLOCK_TEMPLATE = 'Mollie_Payment::checkout/checkout-config.phtml';

    public function execute(Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if (false === $block instanceof Template) {
            return;
        }

        if ($block->getTemplate() !== self::BLOCK_TEMPLATE) {
            return;
        }

        $transport = $observer->getEvent()->getTransport();
        $transport->setHtml('');
    }
}
