import {test} from '@playwright/test';

test.describe('klarnapaylater payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        test.skip('Not enabled in Mollie account');
    });
});
