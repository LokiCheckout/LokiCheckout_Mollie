const {Field} = require(process.cwd() + '/helpers/checkout-objects');
const {saveCheckoutConfig} = require(process.cwd() + '/helpers/save-checkout-config');
const {test} = require(process.cwd() + '/fixtures/checkout-page');

test.describe('Yireo_LokiCheckoutMollie test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await saveCheckoutConfig(context, {
            modules: [
                'Yireo_LokiCheckoutMollie',
                'Mollie_Payment',
            ],
            config: {
                'payment/mollie_general/enabled': 1,
                'payment/mollie_general/type': 'test',
                'payment/mollie_methods_ideal/active': 1,
                'yireo_loki_checkout/general/theme': 'onestep'
            }
        });

        await page.goto('/checkout');

        const fields = {
            'shipping.country_id': 'NL',
        };

        for (const [fieldName, fieldValue] of Object.entries(fields)) {
            const field = new Field(page, fieldName);
            await field.fill(fieldValue);
            await field.expectValue(fieldValue);
        }

        await page.locator('//input[@value="mollie_methods_ideal"]').check();
    });
});
