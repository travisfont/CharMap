# CharMap

```php
CharMap::decimal(203)->Unicode() = Ë
CharMap::decimal(195 139)->UTF8() = Ë
CharMap::decimal('&#203')->Numeric() = Ë
CharMap::Named('&Euml') = Ë
CharMap::decimal(203)->ISO() = Ë

CharMap::hex(U+00CB)->Unicode() = Ë
CharMap::hex(C3 8B)->UTF8() = Ë
CharMap::hex('&#xCB')->UTF8() = Ë
CharMap::hex('CB)->ISO() = Ë
```

https://en.wikipedia.org/wiki/%C3%8B#Character_mappings
