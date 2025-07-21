export default {
  modules: [
    'LokiCheckout_Mollie',
    'Mollie_Payment',
  ],
  profile: 'netherlands',
  config: {
    'payment/mollie_general/enabled': 1,
    'payment/mollie_general/type': 'test',
    'loki_checkout/general/theme': 'onestep',
    'currency/options/base': 'EUR',
  }
};
