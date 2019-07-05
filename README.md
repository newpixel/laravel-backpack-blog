# Blog CRUD for Laravel Backpack

[![Latest Version on Packagist](https://img.shields.io/packagist/v/newpixel/laravel-backpack-blog.svg?style=flat-square)](https://packagist.org/packages/newpixel/laravel-backpack-blog)
[![Build Status](https://img.shields.io/travis/newpixel/laravel-backpack-blog/master.svg?style=flat-square)](https://travis-ci.org/newpixel/laravel-backpack-blog)
[![Quality Score](https://img.shields.io/scrutinizer/g/newpixel/laravel-backpack-blog.svg?style=flat-square)](https://scrutinizer-ci.com/g/newpixel/laravel-backpack-blog)
[![Total Downloads](https://img.shields.io/packagist/dt/newpixel/laravel-backpack-blog.svg?style=flat-square)](https://packagist.org/packages/newpixel/laravel-backpack-blog)

An admin panel for blog articles on Laravel 5, using [Backpack\CRUD](https://github.com/Laravel-Backpack/crud). Write articles, with categories and tags.

## Installation

1) Install the package via composer:

```
composer require newpixel/laravel-backpack-blog
```

2) Publish the config and migration:

```
php artisan vendor:publish --provider="Newpixel\BlogCRUD\BlogCRUDServiceProvider"
```

3) Run the migration to have the database table the package needs

```
php artisan migrate
```

4) Run command to add tree links to resources/views/vendor/backpack/base/inc/sidebar_content.blade.php:

```
php artisan blog:add-sidebar-content-link
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email catalin.prodan@newpixel.ro instead of using the issue tracker.

## Credits

- [Catalin Prodan](https://github.com/newpixel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
