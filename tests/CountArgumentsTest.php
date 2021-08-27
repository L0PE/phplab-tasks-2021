<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
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
        $this->assertEquals($expected, $this->functions->countArguments(...$input));
    }


    public function positiveDataProvider(): array
    {
        return [
            [
                ['string'],
                [
                "argument_count" => 1,
                "argument_values" => ['string']
                ]
            ],
            [
                ['first', 'second', 'third', 'fourth'],
                [
                    "argument_count" => 4,
                    "argument_values" => ['first', 'second', 'third', 'fourth']
                ]
            ],
            [
                ['1', 2, '3', 4, '5', 6, '7', 8, '9'],
                [
                    "argument_count" => 9,
                    "argument_values" => ['1', 2, '3', 4, '5', 6, '7', 8, '9']
                ]
            ],
            [
                [],
                [
                    "argument_count" => 0,
                    "argument_values" => []
                ]
            ],
            [
                [[]],
                [
                    "argument_count" => 1,
                    "argument_values" => [[]]
                ]
            ]
        ];
    }
}
