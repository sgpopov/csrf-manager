<?php

namespace svil4ok\Csrf\Contracts;

interface Token
{
    /**
     * Return the token.
     *
     * @return string
     */
    public function get() : string;

    /**
     * Generates a token.
     *
     * @return void
     */
    public function generate();

    /**
     * Validates a supplied token
     *
     * @param string $token The supplied token
     *
     * @return bool
     */
    public function isValid(string $token) : bool;
}
