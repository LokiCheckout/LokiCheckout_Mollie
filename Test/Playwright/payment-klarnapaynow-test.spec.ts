import {PaymentMethod, PlaceOrderButton} from '@helpers/checkout-objects';
import {setupCheckout} from '@helpers/setup-checkout';
import {test, expect} from '@playwright/test';

import {MolliePortal} from './helpers/mollie-objects';
import mollieConfig from './config/config';

test.describe('klarnapaynow payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, {
            ...mollieConfig,
            config: {
                ...mollieConfig.config,
                'payment/mollie_methods_klarnapaynow/active': 1,
            }
        });

        return; // @todo: Not enabled in Mollie account

        const paymentMethod = new PaymentMethod(page, 'mollie_methods_klarnapaynow');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const molliePortal = new MolliePortal(page);
        await molliePortal.expectIssuerPage();
    });
});
