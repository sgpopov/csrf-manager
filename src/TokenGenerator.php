<?php

namespace svil4ok\Csrf;

use svil4ok\Csrf\Contracts\Generator;

class TokenGenerator implements Generator
{

    /**
     * Generates and return a token.
     *
     * @return string
     */
    public function generate() : string
    {
        return bin2hex(random_bytes(32));
    }
}
