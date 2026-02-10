<?php

class CharMap
{
    private string $char;

    private function __construct(string $char)
    {
        $this->char = $char;
    }

    /**
     * Create a CharMap instance from a decimal value.
     * Supports single integer/string (codepoint) or space-separated string (bytes).
     * e.g. 203, '203', '195 139', '&#203'
     */
    public static function decimal($input): self
    {
        if (is_string($input)) {
            // Check for HTML entity format &#...
            if (str_starts_with($input, '&#') && !str_starts_with($input, '&#x')) {
                if (!str_ends_with($input, ';')) {
                    $input .= ';';
                }
                // Decode HTML entity
                return new self(html_entity_decode($input, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            }

            // Check for space-separated values (bytes)
            if (str_contains($input, ' ')) {
                $bytes = explode(' ', $input);
                $char = '';
                foreach ($bytes as $byte) {
                    $char .= chr((int) $byte);
                }
                return new self($char);
            }
        }

        // Treat single value as codepoint (or possibly raw byte for < 256?)
        // The example decimal(203) -> Ë (which is U+00CB).
        // If we use chr(203), it's a single byte 0xCB. In UTF-8 context this is invalid if standalone,
        // but if we assume the input 203 is a codepoint, then mb_chr(203) gives Ë.
        // Let's assume codepoint.
        $intVal = (int) $input;
        return new self(mb_chr($intVal, 'UTF-8'));
    }

    /**
     * Create a CharMap instance from a hex value.
     * Supports U+... (codepoint), spaced hex bytes, HTML hex entity, or raw hex.
     * e.g. 'U+00CB', 'C3 8B', '&#xCB', 'CB'
     */
    public static function hex($input): self
    {
        if (str_starts_with($input, 'U+')) {
            // Unicode codepoint U+XXXX
            $hex = substr($input, 2);
            return new self(mb_chr(hexdec($hex), 'UTF-8'));
        }

        if (str_starts_with($input, '&#x')) {
            // HTML hex entity
            // html_entity_decode handles &#x...; usually, but input here is &#xCB (no semicolon?)
            // If no semicolon, standard decode might not catch it if strict.
            // Let's manual parse if needed or try decode.
            // Example: '&#xCB'.
            $decoded = html_entity_decode($input . ';', ENT_QUOTES | ENT_HTML5, 'UTF-8');
            // If decode fails or returns same string (minus semicolon), try manual.
            if ($decoded === $input . ';') {
                $hex = substr($input, 3);
                return new self(mb_chr(hexdec($hex), 'UTF-8'));
            }
            return new self($decoded);
        }

        if (str_contains($input, ' ')) {
            // Space separated hex bytes: C3 8B
            $parts = explode(' ', $input);
            $char = '';
            foreach ($parts as $part) {
                $char .= chr(hexdec($part));
            }
            return new self($char);
        }

        // Raw hex: 'CB'. Treat as codepoint?
        // hex('CB')->ISO() = Ë. 0xCB is Ë in Latin1. U+00CB is Ë.
        // So mb_chr(hexdec('CB')) -> Ë.
        return new self(mb_chr(hexdec($input), 'UTF-8'));
    }

    /**
     * Create a CharMap instance from a named entity.
     * e.g. '&Euml'
     */
    public static function Named($input): self
    {
        // Add semicolon if missing, as html_entity_decode expects it often
        if (!str_ends_with($input, ';')) {
            $input .= ';';
        }
        return new self(html_entity_decode($input, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    public function Unicode(): string
    {
        return $this->char;
    }

    public function UTF8(): string
    {
        return $this->char;
    }

    public function Numeric(): string
    {
        return $this->char;
    }

    public function ISO(): string
    {
        return $this->char;
    }

    public function __toString(): string
    {
        return $this->char;
    }
}
