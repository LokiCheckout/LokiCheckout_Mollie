import {Field} from '@helpers/checkout-objects';
import {setupCheckout} from '@helpers/setup-checkout';
import {test, expect} from '@playwright/test';
import mollieConfig from './config/config';

test.describe('Yireo_LokiCheckoutMollie test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, {
            ...mollieConfig,
            config: {
                ...mollieConfig.config,
                'payment/mollie_methods_ideal/active': 1,
            }
        });

        const fields = {
            'shipping.country_id': 'NL',
        };

        for (const [fieldName, fieldValue] of Object.entries(fields)) {
            const field = new Field(page, fieldName);
            await field.fill(fieldValue);
            await field.expectValue(fieldValue);
        }

        await page.locator('//input[@value="mollie_methods_ideal"]').check();
    });
});
