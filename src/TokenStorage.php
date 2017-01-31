<?php

namespace svil4ok\Csrf;

use svil4ok\Csrf\Contracts\SessionStorage;
use svil4ok\Csrf\Contracts\Storage;

class TokenStorage implements Storage, SessionStorage
{
    /**
     * TokenStorage constructor.
     */
    public function __construct()
    {
        $this->start();
    }

    /**
     * Returns the token.
     *
     * @param string $key
     *
     * @return string|null
     */
    public function get(string $key)
    {
        if ($this->exists($key)) {
            return (string) $_SESSION[$key];
        }

        return null;
    }

    /**
     * Sets the token
     *
     * @param string $key
     * @param string $token
     *
     * @return void
     */
    public function set(string $key, string $token)
    {
        $_SESSION[$key] = $token;
    }

    /**
     * Determine if a token has been generated
     *
     * @param string $key
     *
     * @return bool
     */
    public function exists(string $key) : bool
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * Starts the session storage.
     *
     * @return bool True if session started
     *
     * @throws \RuntimeException If session fails to start.
     */
    public function start()
    {
        if (!$this->isStarted()) {
            // Lifetime of the session cookie, defined in seconds.
            $lifetime = 3600; // 1 hour

            // Path on the domain where the cookie will work.
            // Single slash ('/') indicates for all paths on the domain.
            $path = '/';

            // Cookie domain. To make cookies visible on all subdomains then the
            // domain must be prefixed with a dot like '.cayetano.bg'.
            $domain = null;

            // If TRUE cookie will only be sent over secure connections.
            $secure = $this->isSecure();

            // If set to TRUE then PHP will attempt to send the httponly
            // flag when setting the session cookie.
            $httpOnly = true;

            \session_set_cookie_params($lifetime, $path, $domain, $secure, $httpOnly);

            \session_start();
        }

        return true;
    }

    /**
     * Checks if the session was started.
     *
     * @return bool
     */
    public function isStarted() : bool
    {
        return \session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Determine if the request was made through the HTTPS protocol.
     *
     * @return bool
     */
    protected function isSecure() : bool
    {
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            return true;
        }

        if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] === 443) {
            return true;
        }

        return false;
    }
}
