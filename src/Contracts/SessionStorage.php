<?php

namespace svil4ok\Csrf\Contracts;

interface SessionStorage
{
    /**
     * Starts the session storage.
     *
     * @return bool True if session started
     *
     * @throws \RuntimeException If session fails to start.
     */
    public function start();

    /**
     * Checks if the session was started.
     *
     * @return bool
     */
    public function isStarted() : bool;
}
