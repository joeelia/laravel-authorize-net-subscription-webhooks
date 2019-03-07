# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joeelia/laravel-authorize-net-subscription-webhooks.svg?style=flat-square)](https://packagist.org/packages/joeelia/laravel-authorize-net-subscription-webhooks)
[![Build Status](https://img.shields.io/travis/joeelia/laravel-authorize-net-subscription-webhooks/master.svg?style=flat-square)](https://travis-ci.org/joeelia/laravel-authorize-net-subscription-webhooks)
[![Quality Score](https://img.shields.io/scrutinizer/g/joeelia/laravel-authorize-net-subscription-webhooks.svg?style=flat-square)](https://scrutinizer-ci.com/g/joeelia/laravel-authorize-net-subscription-webhooks)
[![Total Downloads](https://img.shields.io/packagist/dt/joeelia/laravel-authorize-net-subscription-webhooks.svg?style=flat-square)](https://packagist.org/packages/joeelia/laravel-authorize-net-subscription-webhooks)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require joeelia/laravel-authorize-net-subscription-webhooks
php artisan migrate
php artisan vendor:publish --provider="Joeelia\AuthorizeNet\AuthorizeNetServiceProvider" --tag="config"
```

## Usage
Within config/authorize-net-webhooks.php you need to configure all options. Depending on what webhooks you want to process you can set those values to True.
Once you have configured your values in the config/authorize-net-webhooks.php you need to run 
```bash
php artisan make:webhookjobs
```
This will generate a directory app/WebhookJobs and scaffold the jobs that will recieve the payload from the Authorize.Net webhooks. You can make your logic from there.

### Configure Authorize.Net
In Authorize.Net settings you need to setup your webhook route. The default route is <yourdomain.com>/authnet/webhook. You can set this up in your Authorize.Net dashboard under ACCOUNT>Settings>Webhooks.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mrjoeelia@gmail.com instead of using the issue tracker.

## Credits

- [Joe Elia](https://github.com/joeelia)
- [All Contributors](../../contributors)

## License

The The Unlicense. Please see [License File](LICENSE.md) for more information.
