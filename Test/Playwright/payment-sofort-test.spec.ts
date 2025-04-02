const {PaymentMethod, PlaceOrderButton} = require(process.cwd() + '/helpers/checkout-objects');
const {saveCheckoutConfig} = require(process.cwd() + '/helpers/save-checkout-config');
const {test} = require(process.cwd() + '/fixtures/checkout-page');

import {MolliePortal} from './helpers/mollie-objects';
import mollieConfig from './config/config';

test.describe('sofort payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await saveCheckoutConfig(context, {
            ...mollieConfig,
            config: {
                'payment/mollie_methods_sofort/active': 1,
            }
        });

        await page.goto('/checkout');
        return; // @todo: Not enabled in Mollie account

        const paymentMethod = new PaymentMethod(page, 'mollie_methods_sofort');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const molliePortal = new MolliePortal(page);
        await molliePortal.expectIssuerPage();
    });
});
