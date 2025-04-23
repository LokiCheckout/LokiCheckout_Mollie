<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Validator\Component;

use Yireo\LokiCheckout\ViewModel\CheckoutState;
use Yireo\LokiComponents\Component\ComponentInterface;
use Yireo\LokiComponents\Validator\ValidatorInterface;

class In3DobValidator implements ValidatorInterface
{
    public function __construct(
        private CheckoutState $checkoutState,
        private int $minimumYears = 18
    ) {
    }

    public function validate(mixed $value, ?ComponentInterface $component = null): true|array
    {
        if ($value !== 'mollie_methods_in3') {
            return true;
        }

        $customerDob = $this->checkoutState->getQuote()->getCustomerDob();
        if (empty($customerDob)) {
            return [__('Make sure to enter a valid date of birth')];
        }

        $dob = strtotime($customerDob);
        $minimumAge = $this->minimumYears * 365 * 24 * 60 * 60;
        if (time() - $dob < $minimumAge) {
            return [__('You need to be at least %1 years old', $this->minimumYears)];
        }

        return true;
    }
}
