<?php

use svil4ok\Csrf\Contracts\SessionStorage;
use svil4ok\Csrf\Contracts\Storage;
use svil4ok\Csrf\TokenStorage;

class TokenStorageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $tokenSlug = 'csrfToken';

    /**
     * Re-generate session before each test.
     *
     * @runInSeparateProcess
     */
    protected function setUp()
    {
        @session_destroy();
        @session_start();
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     *
     * @covers TokenStorage
     */
    public function shouldImplementAllContracts()
    {
        $this->assertInstanceOf(Storage::class, new TokenStorage);
        $this->assertInstanceOf(SessionStorage::class, new TokenStorage);
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     *
     * @covers TokenStorage::get()
     */
    public function shouldReturnNullAsToken()
    {
        $storage = new TokenStorage();

        $this->assertNull($storage->get($this->tokenSlug));
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     *
     * @covers TokenStorage::set();
     */
    public function shouldGenerateTokenAndReturnIn()
    {
        $generatedToken = 'token goes here' . uniqid(uniqid(mt_rand(), true));

        $storage = new TokenStorage();
        $storage->set($this->tokenSlug, $generatedToken);

        $this->assertSame(
            $generatedToken,
            (new TokenStorage)->get($this->tokenSlug)
        );
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     *
     * @covers TokenStorage::exists()
     */
    public function shouldCheckIfTokenExists()
    {
        $this->assertFalse(
            (new TokenStorage)->exists($this->tokenSlug)
        );

        $generatedToken = 'token goes here' . uniqid(uniqid(mt_rand(), true));

        (new TokenStorage)->set($this->tokenSlug, $generatedToken);

        $this->assertTrue(
            (new TokenStorage)->exists($this->tokenSlug)
        );

        $this->assertSame(
            $generatedToken,
            (new TokenStorage)->get($this->tokenSlug)
        );
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     *
     * @covers TokenStorage::isStarted()
     */
    public function shouldReturnThatSessionHasBeenStarted()
    {
        $this->assertTrue((new TokenStorage())->isStarted());
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     *
     * @covers TokenStorage::isStarted()
     */
    public function shouldReturnThatSessionHasBeenAborted()
    {
        $storage = new TokenStorage();

        $this->assertTrue($storage->isStarted());

        \session_destroy();

        $this->assertFalse($storage->isStarted());
    }
}
