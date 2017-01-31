<?php

namespace svil4ok\Csrf\Contracts;

interface Storage
{
    /**
     * Determine if a token has been generated
     *
     * @param string $key
     *
     * @return bool
     */
    public function exists(string $key) : bool;

    /**
     * Returns the token.
     *
     * @param string $key
     *
     * @return null|string
     */
    public function get(string $key);

    /**
     * Sets the token
     *
     * @param string $key
     * @param string $token
     */
    public function set(string $key, string $token);
}
