import coreConfig from '@loki-checkout/config';

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
        'payment/mollie_general/enabled': 1,
        'payment/mollie_general/type': 'test',
        'payment/mollie_general/profileid': process.env.MOLLIE_PROFILE_ID || '',
    }
};
