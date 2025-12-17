# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.17] - 17 December 2025
### Fixed
- Add tsconfig.json that extends LokiCheckout_FunctionalTests

## [2.0.16] - 11 December 2025
### Fixed
- iRemove redundant quote save

## [2.0.15] - 21 November 2025
### Fixed
- Remove deprecated LokiCheckoutPageTestCase in integration tests
- Update composer keywords
- Update composer keywords
- Update composer keywords

## [2.0.14] - 22 October 2025
### Fixed
- Do not escape `$css()` with `escapeHtmlAttr()` but `escapeHtml()`

## [2.0.13] - 30 September 2025
### Fixed
- Remove culprit line causing methods to cause error and disappear

## [2.0.12] - 29 September 2025
### Fixed
- Sort entries of module.xml file
- Sort dependencies of composer.json
- Add escaping

## [2.0.11] - 24 September 2025
### Fixed
- Change containers into blocks to allow for caching
- Rename loki-components container to loki.components

## [2.0.10] - 16 September 2025
### Fixed
- Prevent throwing error when Mollie module is disabled

## [2.0.9] - 04 September 2025
### Fixed
- Add both sequence and real (recursive) module list
- Remove Yireo IntegrationTestHelper

## [2.0.8] - 03 September 2025
### Fixed
- Copy generic CI/CD files

## [2.0.7] - 02 September 2025
### Fixed
- Change loki-checkout.payment.payment-methods to loki-checkout.payment.methods
- Refactor Loki-library location in Playwright tests

## [2.0.6] - 28 August 2025
### Fixed
- Add CI files
- Replace yireo/opensearch with yireo/opensearch-dummy in Gitlab CI

## [2.0.5] - 21 August 2025
### Fixed
- Lazyload all Mollie Component JS code for better performance
- Add dependency with `loki/magento2-css-utils`
- Re-ordering blocks
- Replace LokiComponentsUtilBlockCssClass with LokiCssUtilsUtilCssClass
- Document latest version of template
- Add missing `strict_types` declaration
- Remove duplicate Alpine function

## [2.0.4] - 18 August 2025
### Fixed
- Allow for PHP 8.1 compatibility
- Lower requirements to PHP 8.1
- Fix integration tests with ConfigFixture scope

## [2.0.3] - 06 August 2025
### Fixed
- Rewrite old destroy methods to new destroyMethods
- Rewrite destroyActions to new destroyMethods
- Lower PHP requirement to PHP 8.2+
- Unmount Mollie components when needed

## [2.0.2] - 01 August 2025
### Fixed
- Add escaping to templates

## [2.0.1] - 01 August 2025
### Fixed
- Add missing `$css` wrapper
- Add dep with `Loki_FieldComponents` anyway

## [2.0.0] - 22 July 2025
### Fixed
- Rename PHP namespace from `Yireo_Loki*` to `Loki*`
- Rename composer package from `yireo/magento2-loki*` to `loki/magento2*`
- Bump loki/magento2-components to major 2.0
- Bump loki/magento2-field-components to major 2.0
- Bump `LokiCheckout_Core to 2.0.0`

## [1.0.2] - 08 July 2025
### Fixed
- Add CSS util
- Remove backslash
- Use Loki test-case in Playwright to detect JS errors automatically
- Rewrite @helpers to @loki in Playwright tests

## [1.0.1] - 26 May 2025
### Fixed
- Remove iDeal issuers
- Skip tests not available in account
- Increase timeouts for tests
- Alma test: Set french and minimum amount

## [1.0.0] - 22 May 2025
### Fixed
- Generate new MODULE.json with simple test count
- Rewrite Alpine from initActions object to methods starting with init
- Allow PHP 8.4 in CI
- Fix issue with LokiCheckoutMollie DI type overriding core validators
- Do not make BLOCK constant public
- Rewrite integration test flag $skipDispatchToCheckout
- Rewrite Mollie JS loading in Luma because of CSP
- Add GitLab CI files

## [0.0.9] - 25 April 2025
### Fixed
- Allow upgrading to LokiFieldComponents and LokiCheckout 1.0
- Remove `x-model` because of CSP compliance
- Prevent error if payment method is unknown
- Allow upgrade to LokiComponents 1.0
- Add a DOB check for in3
- Fixes for vault
- Consolidate vault access in core module
- Add "saved" to credit card vault title
- Add helper comment in developer mode
- Fix icon for creditcard vault
- Move Mollie fixture from core to Mollie module
- Remove default params
- Remove CheckoutSession from context
- Remove CartRepository from all contexts
- Rewrite `getCartRepository()->save()` to `getCheckoutState()->saveQuote()`

## [0.0.8] - 16 April 2025
### Fixed
- Rename LokiCheckoutValidator to LokiComponentValidator

## [0.0.7] - 08 April 2025
### Fixed
- Mobile fix

## [0.0.6] - 04 April 2025
### Fixed
- Move to Mollie-specific DI config to Mollie plugin
- Refactor to new payment style
- Failsafe for non-existing `$viewModel` variable
- Prevent rerender of Mollie components form
- Change creditcard fields layout
- Add integration tests
- Add Playwright tests
- Only load Mollie components block if configured
- Refactor PaymentRedirectUrl plugin to resolver
- Refactor PaymentMethodIcon plugins into resolvers

## [0.0.5] - 11 March 2025
### Fixed
- Add module dependencies
- Huge refactoring to move logic into new LokiFieldComponents
- Rename `loki-checkout.css_classes` to `loki-components.css_classes`

## [0.0.4] - 25 February 2025
### Fixed
- Rename checkout:payment:method-activate to loki-checkout prefix
- StepForwardButton not activated after component updates
- Destroy components before updating their HTML
- Attempt to remove Mollie CSS

## [0.0.3] - 21 January 2025
- Finalize Mollie Components

## [0.0.2] - 21 January 2025
- Typo in version strings
- Remove unneeded SearchCriteriaBuilderFactory

## [0.0.1] - 21 January 2025
- Add proper deps
- Initial release
