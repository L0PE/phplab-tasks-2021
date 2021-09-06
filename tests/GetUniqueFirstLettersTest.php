<?php

use PHPUnit\Framework\TestCase;

require_once 'src/web/functions.php';


class GetUniqueFirstLettersTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive(array $input, array $expected)
    {
        $this->assertEquals($expected, getUniqueFirstLetters($input));
    }

    /**
     * @dataProvider wrongParameterDataProvider
     */
    public function testWrongParameter($input)
    {
        $this->expectError();

        getUniqueFirstLetters($input);
    }
    /**
     * @dataProvider wrongArrayDataProvider
     */
    public function testWrongArray($input)
    {
        $this->expectException(InvalidArgumentException::class);

        getUniqueFirstLetters($input);
    }

    public function positiveDataProvider(): array
    {
        return [
            [
                [
                    ["name" => 'A'],
                    ["name" => 'B'],
                    ["name" => 'C'],
                    ["name" => 'D']
                ],
                ['A','B','C','D']
            ],
            [
                [
                    ["name" => 'A'],
                    ["name" => 'A'],
                    ["name" => 'A']
                ],
                ['A']
            ],
            [
                [
                    ['name' => 'Pavlo'],
                    ['name' => 'Ivan'],
                    ['name'=>'Stepan'],
                    ['name' => 'Andrew']
                ],
                ['A','I','P','S']
            ]
        ];
    }

    public function wrongParameterDataProvider(): array
    {
        return[
            [12],
            [true],
            ['Some text'],
            [null]
        ];
    }

    public function wrongArrayDataProvider(): array
    {
        return[
            [
                [[]]
            ],
            [
                [
                    ['name' => 'Pavlo'],
                    [0 => 'Ivan'],
                    ['name'=>'Stepan'],
                    [1 => 'Andrew']
                ]
            ],
            [
                [
                    ["New York"],
                    ["Los Angeles"],
                    ["Washington"]
                ]
            ]
        ];
    }
}