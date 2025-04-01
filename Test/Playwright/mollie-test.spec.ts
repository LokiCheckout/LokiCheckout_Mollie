import FieldManager from "./helpers/field";
import getCheckoutConfig from "./helpers/checkout-config";
import {test, expect} from './fixtures/cart-page';

test.describe.configure({mode: 'serial'});

test.describe('Yireo_LokiCheckoutMollie test', () => {
    test('should allow me to go to the checkout', async ({checkoutPage, request}) => {
        await getCheckoutConfig(request, [
            'Yireo_LokiCheckoutMollie',
            'Mollie_Payment',
            'Yireo_LokiCheckoutHyvaSkinny',
            'Yireo_DisableCsp',
        ], {
            'payment/mollie_general/enabled': 1,
            'payment/mollie_general/type': 'test',
            'payment/mollie_general/enable_magento_vault': 0,
            'payment/mollie_general/default_selected_method': 'mollie_methods_ideal',
            'yireo_loki_checkout/general/theme': 'onestep'
        });

        await checkoutPage.reload();

        const fieldManager = new FieldManager(checkoutPage);
        fieldManager.fillAll([
            {id: 'email', group: 'customer', value: 'jane@example.com'},
            {id: 'firstname', group: 'shipping', value: 'Jane'},
            {id: 'lastname', group: 'shipping', value: 'Doe'},
            {id: 'company', group: 'shipping', value: 'Yireo'},
            {id: 'city', group: 'shipping', value: 'Baarn'},
            {id: 'street0', group: 'shipping', value: 'Amalialaan'},
            {id: 'street1', group: 'shipping', value: '126'},
            {id: 'street2', group: 'shipping', value: 'D'},
            {id: 'country-id', group: 'shipping', value: 'NL'},
            {id: 'region', group: 'shipping', value: 'Utrecht'},
            {id: 'phone', group: 'shipping', value: '0123456789'},
            {id: 'fax', group: 'shipping', value: '0123456789'},
            {id: 'vat-id', group: 'shipping', value: 'NL1234123412'},
            {id: 'shipping-as-billing', group: 'billing', value: '1'},
        ]);

        const paymentMethodField = fieldManager.getLocatorByHtmlId('payment-mollie_methods_ideal');
        fieldManager.fill(paymentMethodField, true, 'radiobox');
    });
});
