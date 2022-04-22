# Validation

A validation library for PHP that uses
the [notification pattern](https://martinfowler.com/articles/replaceThrowWithNotification.html).

[![Latest Version on Packagist](https://img.shields.io/github/release/selective-php/validation.svg)](https://packagist.org/packages/selective/validation)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Build Status](https://github.com/selective-php/validation/workflows/build/badge.svg)](https://github.com/selective-php/validation/actions)
[![Coverage Status](https://scrutinizer-ci.com/g/selective-php/validation/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/selective-php/validation/code-structure)
[![Quality Score](https://scrutinizer-ci.com/g/selective-php/validation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/selective-php/validation/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/selective/validation.svg)](https://packagist.org/packages/selective/validation/stats)

## Table of contents

* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
    * [Validating form data](#validating-form-data)
    * [Validating JSON](#validating-json)
    * [Regex](#regex)
* [Validators](#validators)
    * [CakePHP Validator](#cakephp-validator)
    * [Symfony Validator](#symfony-validator)
* [Transformer](#transformer)
* [License](#license)

## Requirements

* PHP 7.2+ or 8.0+

## Installation

```shell
composer require selective/validation
```

## Usage

> A notification is a collection of errors

In order to use a notification, you have to create the `ValidationResult` object. A `ValidationResult` can be really
simple:

```php
<?php

use Selective\Validation\Exception\ValidationException;
use Selective\Validation\ValidationResult;

$validationResult = new ValidationResult();

if (empty($data['username'])) {
    $validationResult->addError('username', 'Input required');
}
```

You can now test the `ValidationResult` and throw an exception if it contains errors.

```php
<?php
if ($validationResult->fails()) {
    throw new ValidationException('Please check your input', $validationResult);
}
```

## Validating form data

Login example:

```php
<?php

use Selective\Validation\Exception\ValidationException;
use Selective\Validation\ValidationResult;

// ...

// Get all POST values
$data = (array)$request->getParsedBody();

$validation = new ValidationResult();

// Validate username
if (empty($data['username'])) {
    $validation->addError('username', 'Input required');
}

// Validate password
if (empty($data['password'])) {
    $validation->addError('password', 'Input required');
}

// Check validation result
if ($validation->fails()) {
    // Trigger error response (see validation middleware)
    throw new ValidationException('Please check your input', $validation);
}
```

### Validating JSON

Validating a JSON request works like validating form data, because in PHP it's just an array from the request object.

```php
<?php
use Selective\Validation\ValidationResult;

// Fetch json data from request as array
$jsonData = (array)$request->getParsedBody();

$validation = new ValidationResult();

// ...

if ($validation->fails()) {
    throw new ValidationException('Please check your input', $validation);
}
```

In vanilla PHP you can fetch the JSON request as follows:

```php
<?php

$jsonData = (array)json_decode(file_get_contents('php://input'), true);

// ...
```

### Regex

The `Selective\Validation\Regex\ValidationRegex` class allows you to validate if
a given string conforms a defined regular expression.

**Example usage:**

```php
use Selective\Validation\Factory\CakeValidationFactory;
use Selective\Validation\Regex\ValidationRegex;
// ...

$data = [ /* ... */ ];

$validationFactory = new CakeValidationFactory();
$validator = $validationFactory->createValidator();

$validator
    ->regex('id', ValidationRegex::ID, 'Invalid')
    ->regex('country', ValidationRegex::COUNTRY_ISO_2, 'Invalid country')
    ->regex('date_of_birth', ValidationRegex::DATE_DMY, 'Invalid date format');
```

### Middleware

The `ValidationExceptionMiddleware` catches the `ValidationException` and converts it into a nice JSON response.

#### Slim 4 integration

Insert a container definition for `ValidationExceptionMiddleware::class`:

```php
<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\Validation\Encoder\JsonEncoder;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Selective\Validation\Transformer\ErrorDetailsResultTransformer;
use Slim\App;
use Slim\Factory\AppFactory;
// ...

return [
    ValidationExceptionMiddleware::class => function (ContainerInterface $container) {
        $factory = $container->get(ResponseFactoryInterface::class);

        return new ValidationExceptionMiddleware(
            $factory, 
            new ErrorDetailsResultTransformer(), 
            new JsonEncoder()
        );
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);

        return $app->getResponseFactory();
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    // ...

];
```

Add the `ValidationExceptionMiddleware` into your middleware stack:

```php
<?php

use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// ...

$app->add(ValidationExceptionMiddleware::class);

// ...

$app->run();
```

#### Usage in Slim

```php
<?php

use Selective\Validation\ValidationException;
use Selective\Validation\ValidationResult;

$validation = new ValidationResult();

// Validate username
if (empty($data->username)) {
    $validation->addError('username', 'Input required');
}

// Check validation result
if ($validation->fails()) {
    // Trigger the validation middleware
    throw new ValidationException('Please check your input', $validation);
}
```

## Validators

You can combine this library with a validator that is doing the actual validation of your input data.

The [converter pattern](https://java-design-patterns.com/patterns/converter/) makes it easy to map instances of one
class into instances of another class.

### CakePHP Validator

The [cakephp/validation](https://github.com/cakephp/validation) library provides features 
to build validators that can validate arbitrary arrays of data with ease.

**Installation**

```
composer require cakephp/validation
```

**Usage**

The `Cake\Validation\Validator::validate()` method returns a non-empty array when 
there are validation failures. The list of errors then can be converted into 
a `ValidationResult` using the `Selective\Validation\Factory\CakeValidationFactory`
or `Selective\Validation\Converter\CakeValidationConverter`.

For example, if you want to validate a login form you could do the following:

```php
use Selective\Validation\Factory\CakeValidationFactory;
use Selective\Validation\Exception\ValidationException;
// ...

// Within the Action class: fetch the request data, e.g. from a JSON request
$data = (array)$request->getParsedBody();

// Within the Application Service class: Do the validation
$validationFactory = new CakeValidationFactory();
$validator = $validationFactory->createValidator();

$validator
    ->notEmptyString('username', 'Input required')
    ->notEmptyString('password', 'Input required');

$validationResult = $validationFactory->createValidationResult(
    $validator->validate($data)
);

if ($validationResult->fails()) {
    throw new ValidationException('Please check your input', $validationResult);
}
```

Please note: The `CakeValidationFactory` should be injected via constructor.

**Read more:** <https://odan.github.io/2020/10/18/slim4-cakephp-validation.html>

## Transformer

If you want to implement a custom response data structure, 
you can implement a custom transformer against the
`\Selective\Validation\Transformer\ResultTransformerInterface` interface.

**Example**

```php
<?php

namespace App\Transformer;

use Selective\Validation\Exception\ValidationException;
use Selective\Validation\Transformer\ResultTransformerInterface;
use Selective\Validation\ValidationResult;

final class MyValidationTransformer implements ResultTransformerInterface
{
    public function transform(
        ValidationResult $validationResult, 
        ValidationException $exception = null
    ): array {
        // Implement your own data structure for the response
        // ...

        return [];
    }
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
