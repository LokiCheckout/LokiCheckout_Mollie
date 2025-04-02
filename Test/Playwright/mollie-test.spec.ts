const {Field} = require(process.cwd() + '/helpers/field');
const {saveCheckoutConfig} = require(process.cwd() + '/helpers/checkout-config');
const {test, expect} = require(process.cwd() + '/fixtures/checkout-page');

test.beforeAll(async ({request}) => {
    await saveCheckoutConfig(request, {
        modules: [
            'Yireo_LokiCheckoutMollie',
            'Mollie_Payment',
            'Yireo_DisableCsp',
        ],
        config: {
            'payment/mollie_general/enabled': 1,
            'payment/mollie_general/type': 'test',
            'payment/mollie_general/enable_magento_vault': 0,
            'payment/mollie_general/default_selected_method': 'mollie_methods_ideal',
            'yireo_loki_checkout/general/theme': 'onestep'
        }
    });
});


test.describe('Yireo_LokiCheckoutMollie test', () => {
    test('should allow me to go to the checkout', async ({checkoutPage}) => {

        const fields = {
            'shipping.country_id': 'NL',
        };

        for (const [fieldName, fieldValue] of Object.entries(fields)) {
            const field = new Field(checkoutPage, fieldName);
            await field.fill(fieldValue);
            await field.expectValue(fieldValue);
        }

        const paymentMethodField = new Field(checkoutPage, 'payment.mollie_methods_ideal');
        await paymentMethodField.fill(true);
    });
});
