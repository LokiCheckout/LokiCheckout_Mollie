const {Field, FieldManager} = require(process.cwd() + '/helpers/field');
const saveCheckoutConfig = require(process.cwd() + '/helpers/checkout-config');
const {test, expect} = require(process.cwd() + '/fixtures/checkout-page');

test.describe.configure({mode: 'serial'});

test.describe('Yireo_LokiCheckoutMollie test', () => {
    test('should allow me to go to the checkout', async ({checkoutPage, request}) => {

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

        await checkoutPage.reload();

        const fieldManager = new FieldManager(checkoutPage, []);
        fieldManager.fill([
            ['customer.email', 'jane@example.com'],
            ['shipping.firstname', 'Jane'],
            ['shipping.lastname', 'Doe'],
            ['shipping.company', 'Yireo'],
            ['shipping.city', 'Baarn'],
            ['shipping.street0', 'Amalialaan'],
            ['shipping.street1', '126'],
            ['shipping.street2', 'D'],
            ['shipping.country-id', 'NL'],
            ['shipping.region', 'Utrecht'],
            ['shipping.phone', '0123456789'],
            ['shipping.fax', '0123456789'],
            ['shipping.vat-id', 'NL1234123412'],
            ['billing.shipping-as-billing', '1']
        ]);

        const paymentMethodField = fieldManager.getField('payment-mollie_methods_ideal');
        paymentMethodField.fill(true);
    });
});
