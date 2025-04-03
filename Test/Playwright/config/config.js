export default {
  modules: [
    'Yireo_LokiCheckoutMollie',
    'Mollie_Payment',
  ],
  profile: 'netherlands',
  config: {
    'currency/options/base': 'EUR',
    'currency/options/default': 'EUR',
    'currency/options/allow': 'EUR',
    'payment/mollie_general/enabled': 1,
    'payment/mollie_general/type': 'test',
    'yireo_loki_checkout/general/theme': 'onestep'
  }
};
