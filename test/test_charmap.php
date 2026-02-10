<?php

require_once '../src/CharMap.php';

function assert_char($actual, $expected, $message)
{
    if ($actual !== $expected) {
        echo "FAIL: $message\n";
        echo "  Expected: " . bin2hex($expected) . " ($expected)\n";
        echo "  Actual:   " . bin2hex($actual) . " ($actual)\n";
    } else {
        echo "PASS: $message\n";
    }
}

$expectedChar = 'Ë'; // UTF-8: C3 8B

echo "Testing CharMap...\n";

// Decimal tests
assert_char(CharMap::decimal(203)->Unicode(), $expectedChar, "decimal(203)->Unicode()");
assert_char(CharMap::decimal('195 139')->UTF8(), $expectedChar, "decimal('195 139')->UTF8()");
assert_char(CharMap::decimal('&#203')->Numeric(), $expectedChar, "decimal('&#203')->Numeric()");

// Named test
// Note: Input in README is '&Euml' (no semicolon). Code handles adding check.
assert_char(CharMap::Named('&Euml')->ISO(), $expectedChar, "Named('&Euml')");

// Hex tests
assert_char(CharMap::hex('U+00CB')->Unicode(), $expectedChar, "hex('U+00CB')->Unicode()");
assert_char(CharMap::hex('C3 8B')->UTF8(), $expectedChar, "hex('C3 8B')->UTF8()");
assert_char(CharMap::hex('&#xCB')->UTF8(), $expectedChar, "hex('&#xCB')->UTF8()");
assert_char(CharMap::hex('CB')->ISO(), $expectedChar, "hex('CB')->ISO()");

echo "Done.\n";
