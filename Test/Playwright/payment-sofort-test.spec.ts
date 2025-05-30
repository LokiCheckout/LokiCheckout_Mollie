import {test} from '@loki/test';

test.describe('sofort payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        test.skip('Not enabled in Mollie account');
    });
});
