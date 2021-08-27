<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
{
    protected $functions;

    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    /**
     * @dataProvider negativeDataProvider
     */
    public function testNegative($input)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->functions->countArgumentsWrapper(...$input);
    }

    public function negativeDataProvider():array
    {
        return [
            [[1,2,3]],
            [['string', null]],
            [['first', 'second', 'third', $this->functions]],
            [['1','2','3','4','5','6','7','8',9]]
        ];
    }
}