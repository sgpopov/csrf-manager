<?php

namespace svil4ok\Csrf\Contracts;

interface Generator
{
    /**
     * Generates and return a token.
     *
     * @return string
     */
    public function generate() : string;
}
