[![Latest Stable Version](https://poser.pugx.org/tankfairies/guid/v/stable)](https://packagist.org/packages/tankfairies/guid)
[![Total Downloads](https://poser.pugx.org/tankfairies/guid/downloads)](https://packagist.org/packages/tankfairies/guid)
[![Latest Unstable Version](https://poser.pugx.org/tankfairies/guid/v/unstable)](https://packagist.org/packages/tankfairies/guid)
[![License](https://poser.pugx.org/tankfairies/guid/license)](https://packagist.org/packages/tankfairies/guid)
[![Build Status](https://travis-ci.com/tankfairies/guid.svg?branch=master)](https://travis-ci.com/tankfairies/guid)

#GUID

It's PHP 7.1+ library for generating and working with [RFC 4122][rfc4122] version 1, 3, 4, and 5 
universally unique identifiers (UUID) / globally unique identifiers (GUID).

Derived from code by [Fredrik Lindberg](https://github.com/fredriklindberg).


## Installation

Install with [Composer](https://getcomposer.org/):

```bash
composer require tankfairies/guid
```

## API documentation

The [latest class API documentation][apidocs] is available online.


## Usage

There are four GUID types available.
GUID Version: -
```
    GuidInterface::UUID_TIME      -> Time based UUID        (version 1)
    GuidInterface::UUID_NAME_MD5  -> Name based (MD5) UUID  (version 3)
    GuidInterface::UUID_RANDOM    -> Random UUID            (version 4)
    GuidInterface::UUID_NAME_SHA1 -> Name based (SHA1) UUID (version 5)
```

All the GUIDs can be generated in one of three formats String, binary and byte.
GUID format: -
```
    GuidInterface::FMT_STRING
    GuidInterface::FMT_BINARY
    GuidInterface::FMT_BYTE
```

The guid generate function has four parameters: -

```
$guid->generate(
    type/version,
    output format,
    salt,
    namespace
)
```

The salt needs to be at least 6 characters long.

A salt is required for versions 1 but optional for versions 3 and 5.

Generate a Version one GUID. (The third parameter is a salt and is required).
```php
use Tankfairies/guid;

$guid = new Guid();
$guidToken = $guid->generate(
    GuidInterface::UUID_TIME,
    GuidInterface::FMT_STRING,
    'thesalt'
);
```

Generate a Version three GUID.
```php
use Tankfairies/guid;

$guid = new Guid();
$guidToken = $guid->generate(
    GuidInterface::UUID_NAME_MD5,
    GuidInterface::FMT_STRING,
    'thesalt',
    'thenamespace'
);
```

Generate a Version four GUID.
```php
use Tankfairies/guid;

$guid = new Guid();
$guidToken = $guid->generate(
    GuidInterface::UUID_RANDOM,
    GuidInterface::FMT_STRING
);
```

Generate a Version five GUID.
```php
use Tankfairies/guid;

$guid = new Guid();
$guidToken = $guid->generate(
    GuidInterface::UUID_NAME_SHA1,
    GuidInterface::FMT_STRING
);
```

## Copyright and license

The tankfairies/guid library is Copyright (c) 2019 Tankfairies (https://tankfairies.com) and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.