import {Field, PaymentMethod, PlaceOrderButton} from '@loki-checkout/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';

import {MolliePortal} from './helpers/mollie-objects';
import mollieConfig from './config/config';

test.describe('in3 payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, {
            ...mollieConfig,
            qty: 2, // in3 requires a minimum order amount of EUR 50
            config: {
                ...mollieConfig.config,
                'customer/address/dob_show': 'opt',
                'payment/mollie_methods_in3/active': 1,
            }
        });

        // in3 requires a date of birth (see In3DobValidator)
        const dobField = new Field(page, 'customer.dob');
        await dobField.fill('1980-01-01');

        const paymentMethod = new PaymentMethod(page, 'mollie_methods_in3');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const molliePortal = new MolliePortal(page);
        await molliePortal.expectIssuerPage();
    });
});
