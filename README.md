# This is my package whatsapp-rich-editor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/daljo25/whatsapp-rich-editor.svg?style=flat-square)](https://packagist.org/packages/daljo25/whatsapp-rich-editor)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/daljo25/whatsapp-rich-editor/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/daljo25/whatsapp-rich-editor/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/daljo25/whatsapp-rich-editor/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/daljo25/whatsapp-rich-editor/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/daljo25/whatsapp-rich-editor.svg?style=flat-square)](https://packagist.org/packages/daljo25/whatsapp-rich-editor)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require daljo25/whatsapp-rich-editor
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="whatsapp-rich-editor-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="whatsapp-rich-editor-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="whatsapp-rich-editor-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$whatsappRichEditor = new Daljo25\WhatsappRichEditor();
echo $whatsappRichEditor->echoPhrase('Hello, Daljo25!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [daljo25](https://github.com/daljo25)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
