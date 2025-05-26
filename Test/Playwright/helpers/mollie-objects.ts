const {expect} = require(process.cwd() + '/node_modules/@playwright/test');

export class MolliePortal {
    page;
    locator;

    constructor(page) {
        this.page = page;
    }

    async expectTestPaymentPage() {
        await expect(this.page).toHaveURL(/www.mollie.com\/checkout/, {timeout: 10000});

        const body = await this.page.locator('body');
        await expect(body).toHaveText(/Note: this is a testmode payment/);    }

    async expectIssuerPage() {
        await expect(this.page).toHaveURL(/www.mollie.com\/checkout/, {timeout: 10000});

        const body = await this.page.locator('body');
        await expect(body).toHaveText(/Note: this is a testmode payment/);
    }
}
