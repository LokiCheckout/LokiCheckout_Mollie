export default {
  modules: [
    'Yireo_LokiCheckoutMollie',
    'Mollie_Payment',
  ],
  profile: 'netherlands',
  config: {
    'payment/mollie_general/enabled': 1,
    'payment/mollie_general/type': 'test',
    'yireo_loki_checkout/general/theme': 'onestep'
  }
};
