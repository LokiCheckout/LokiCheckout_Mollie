const {PaymentMethod, PlaceOrderButton} = require(process.cwd() + '/helpers/checkout-objects');
const {saveCheckoutConfig} = require(process.cwd() + '/helpers/save-checkout-config');
const {test} = require(process.cwd() + '/fixtures/checkout-page');

import {MolliePortal} from './helpers/mollie-objects';
import mollieConfig from './config/config';

test.describe('przelewy24 payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await saveCheckoutConfig(context, {
            ...mollieConfig,
            profile: 'polish',
            config: {
                'payment/mollie_methods_przelewy24/active': 1,
            }
        });

        await page.goto('/checkout');

        const paymentMethod = new PaymentMethod(page, 'mollie_methods_przelewy24');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const molliePortal = new MolliePortal(page);
        await molliePortal.expectIssuerPage();
    });
});
