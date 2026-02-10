# CharMap

A PHP library for fluent character mapping and conversion. Easily convert between Decimal, Hex, HTML Entities, and Unicode characters.

## Installation

Include the `CharMap.php` file in your project:

```php
require_once 'src/CharMap.php';
```

## Usage

The `CharMap` class provides static methods to parse input and instance methods to output the character in various formats.

### Static Methods (Input)

*   `CharMap::decimal($input)`: Parses decimal values.
    *   Single integer: `203`
    *   Space-separated bytes: `'195 139'`
    *   HTML Entity: `'&#203'`
*   `CharMap::hex($input)`: Parses hexadecimal values.
    *   Unicode Codepoint: `'U+00CB'`
    *   Space-separated bytes: `'C3 8B'`
    *   HTML Hex Entity: `'&#xCB'`
    *   Raw Hex: `'CB'`
*   `CharMap::Named($input)`: Parses named HTML entities.
    *   Entity name: `'&Euml'`

### Instance Methods (Output)

*   `->Unicode()`: Returns the character (UTF-8).
*   `->UTF8()`: Returns the character (UTF-8).
*   `->Numeric()`: Returns the character (UTF-8).
*   `->ISO()`: Returns the character (UTF-8).

## Examples

```php
// Decimal
echo CharMap::decimal(203)->Unicode();       // Output: Ë
echo CharMap::decimal('195 139')->UTF8();    // Output: Ë
echo CharMap::decimal('&#203')->Numeric();   // Output: Ë

// Hex
echo CharMap::hex('U+00CB')->Unicode();      // Output: Ë
echo CharMap::hex('C3 8B')->UTF8();          // Output: Ë
echo CharMap::hex('&#xCB')->UTF8();          // Output: Ë
echo CharMap::hex('CB')->ISO();              // Output: Ë

// Named Entity
echo CharMap::Named('&Euml')->ISO();         // Output: Ë
```

## Running Tests

To run the included tests:

```bash
php test/test_charmap.php
```

Reference: [Wikipedia: Character mappings](https://en.wikipedia.org/wiki/%C3%8B#Character_mappings)
