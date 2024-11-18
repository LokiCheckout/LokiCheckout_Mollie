module.exports = {
    content: [
        "../layout/*.xml",
        "../templates/**/*.phtml"
    ],
    options: {
        safelist: [
            'mollie-component',
            'mollie-card-component',
            'apple-pay-button',
        ],
    }
}

