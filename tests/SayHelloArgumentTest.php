<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentTest extends TestCase
{
    protected $functions;

    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, $this->functions->sayHelloArgument($input));
    }


    public function positiveDataProvider(): array
    {
        return [
            ['string', 'Hello string'],
            ['Світ', 'Hello Світ'],
            [123, 'Hello 123'],
            [012, 'Hello 10'],
            [true, 'Hello 1'],
            [false, 'Hello ']
        ];
    }
}