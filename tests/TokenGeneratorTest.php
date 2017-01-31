<?php

use svil4ok\Csrf\Contracts\Generator as TokenGeneratorContract;
use svil4ok\Csrf\TokenGenerator;

class TokenGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @covers TokenGenerator
     */
    public function shouldImplementTokenGeneratorContract()
    {
        $this->assertInstanceOf(TokenGeneratorContract::class, new TokenGenerator);
    }

    /**
     * @test
     *
     * @covers TokenGenerator::generate()
     */
    public function shouldGenerateRandomString()
    {
        $token = (new TokenGenerator)->generate();

        $this->assertNotNull($token);
        $this->assertTrue(is_string($token));
        $this->assertSame(64, strlen($token));
    }
}
