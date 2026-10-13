import coreConfig from '@loki-checkout/config';

export const testCard = {
    holder: 'J. B. Reitsma',
    number: process.env.MOLLIE_CREDITCARD_NUMBER || '378282246310005',
    expiry: process.env.MOLLIE_CREDITCARD_EXPIRY || '03/30',
    cvc: process.env.MOLLIE_CREDITCARD_PIN || '1111',
};

export default {
    ...coreConfig,
    modules: [
        'LokiCheckout_Mollie',
        'Mollie_Payment',
    ],
    secure_config: {
        'payment/mollie_general/apikey_test': process.env.MOLLIE_TEST_API_KEY || '',
    },
    config: {
        ...coreConfig.config,
        'currency/options/default': 'EUR',
        'currency/options/allow': 'EUR',
        'payment/mollie_general/enabled': 1,
        'payment/mollie_general/type': 'test',
        'payment/mollie_general/profileid': process.env.MOLLIE_PROFILE_ID || '',
    }
};
