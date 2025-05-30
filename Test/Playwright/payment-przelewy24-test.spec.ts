import {PaymentMethod, PlaceOrderButton} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@playwright/test';

import {MolliePortal} from './helpers/mollie-objects';
import mollieConfig from './config/config';

test.describe('przelewy24 payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, {
            ...mollieConfig,
            profile: 'poland',
            config: {
                ...mollieConfig.config,
                'payment/mollie_methods_przelewy24/active': 1,
                'currency/options/base': 'PLN',
            }
        });

        const paymentMethod = new PaymentMethod(page, 'mollie_methods_przelewy24');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const molliePortal = new MolliePortal(page);
        await molliePortal.expectIssuerPage();
    });
});
