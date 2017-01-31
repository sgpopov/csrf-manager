<?php

namespace svil4ok\Csrf;

use svil4ok\Csrf\Contracts\Generator;
use svil4ok\Csrf\Contracts\Storage;
use svil4ok\Csrf\Contracts\Token as TokenContract;

class Token implements TokenContract
{
    /**
     * @var TokenStorage
     */
    protected $storage;

    /**
     * @var Generator
     */
    protected $generator;

    /**
     * @var string
     */
    protected $tokenSlug = 'csrfToken';

    /**
     * Token constructor.
     *
     * @param Storage $storage
     * @param Generator $generator
     */
    public function __construct(Storage $storage, Generator $generator)
    {
        $this->storage = $storage;
        $this->generator = $generator;
    }

    /**
     * Return the token.
     *
     * @return string
     */
    public function get() : string
    {
        if (!$this->storage->exists($this->tokenSlug)) {
            $this->generate();
        }

        return $this->storage->get($this->tokenSlug);
    }

    /**
     * Generates a token.
     *
     * @return void
     */
    public function generate()
    {
        $this->storage->set(
            $this->tokenSlug,
            $this->generator->generate()
        );
    }

    /**
     * Validates a supplied token
     *
     * @param string $token
     *
     * @return bool
     */
    public function isValid(string $token) : bool
    {
        if (!$this->storage->exists($this->tokenSlug)) {
            return false;
        }

        return hash_equals($this->storage->get($this->tokenSlug), $token);
    }
}
