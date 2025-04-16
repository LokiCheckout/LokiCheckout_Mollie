# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
