<?php

use svil4ok\Csrf\Contracts\Generator;
use svil4ok\Csrf\Contracts\Storage;
use svil4ok\Csrf\Contracts\Token as TokenContract;
use svil4ok\Csrf\Token;
use svil4ok\Csrf\TokenGenerator;
use svil4ok\Csrf\TokenStorage;

class TokenTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $tokenSlug = 'csrfToken';

    /**
     * @test
     *
     * @covers Token
     */
    public function shouldImplementAllContracts()
    {
        $storageMock = $this->createMock(Storage::class);
        $generatorMock = $this->createMock(Generator::class);

        $this->assertInstanceOf(
            TokenContract::class,
            new Token($storageMock, $generatorMock)
        );
    }
    
    /**
     * @test
     */
    public function shouldReturnGenerateToken()
    {
        $generatedHash = 'random hash goes here';

        $storage = $this->getMockBuilder(TokenStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['exists', 'set', 'get'])
            ->getMock();

        $generator = $this->getMockBuilder(TokenGenerator::class)
            ->setMethods(['generate'])
            ->getMock();

        $generator->expects($this->once())
            ->method('generate')
            ->with()
            ->will($this->returnValue($generatedHash));

        $storage->expects($this->once())
            ->method('exists')
            ->with($this->tokenSlug)
            ->will($this->onConsecutiveCalls(false, true));

        $storage->expects($this->once())
            ->method('set')
            ->with($this->tokenSlug, $generatedHash);

        $storage->expects($this->once())
            ->method('get')
            ->with($this->tokenSlug)
            ->will($this->returnValue($generatedHash));

        $token = new Token($storage, $generator);

        $this->assertSame($generatedHash, $token->get());
    }
}
