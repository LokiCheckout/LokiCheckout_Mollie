import coreConfig from '@loki/config';

export default {
    ...coreConfig,
    modules: [
        'LokiCheckout_Mollie',
        'Mollie_Payment',
    ],
    config: {
        ...coreConfig.config,
        'payment/mollie_general/enabled': 1,
        'payment/mollie_general/type': 'test',
    }
};
