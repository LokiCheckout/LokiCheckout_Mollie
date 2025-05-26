import {test} from '@playwright/test';

test.describe('pointofsale payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        test.skip('Not enabled in Mollie account');
    });
});
