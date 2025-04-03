const {PaymentMethod, PlaceOrderButton} = require(process.cwd() + '/helpers/checkout-objects');
const {saveCheckoutConfig} = require(process.cwd() + '/helpers/save-checkout-config');
const {test} = require(process.cwd() + '/fixtures/checkout-page');

import {MolliePortal} from './helpers/mollie-objects';
import mollieConfig from './config/config';

test.describe('creditcard payment without components test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await saveCheckoutConfig(context, {
            ...mollieConfig,
            config: {
                'payment/mollie_methods_creditcard/active': 1,
                'payment/mollie_methods_creditcard/use_components': 0,
            }
        });

        await page.goto('/checkout');

        const paymentMethod = new PaymentMethod(page, 'mollie_methods_creditcard');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const molliePortal = new MolliePortal(page);
        await molliePortal.expectIssuerPage();
    });
});


test.describe('creditcard payment with components test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await saveCheckoutConfig(context, {
            ...mollieConfig,
            config: {
                'payment/mollie_methods_creditcard/active': 1,
                'payment/mollie_methods_creditcard/use_components': 1,
            }
        });

        await page.goto('/checkout');

        const paymentMethod = new PaymentMethod(page, 'mollie_methods_creditcard');
        await paymentMethod.select();

        const idPrefix = '#loki-checkout-payment-payment-methods-mollie-methods-creditcard-form-';

        await page.locator(idPrefix + 'card-holder iframe').contentFrame().locator('id=cardHolder').fill('J. B. Reitsma');
        await page.locator(idPrefix + 'card-number iframe').contentFrame().locator('id=cardNumber').fill('378282246310005');
        await page.locator(idPrefix + 'expiry-date iframe').contentFrame().locator('id=expiryDate').fill('03/30');
        await page.locator(idPrefix + 'verification-code iframe').contentFrame().locator('id=verificationCode').fill('1111');

        await page.waitForTimeout(1000); // Give it a second

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const molliePortal = new MolliePortal(page);
        await molliePortal.expectIssuerPage();
    });
});

