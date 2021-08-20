<?php

namespace basics;

class Basics implements BasicsInterface
{
    private BasicsValidator $validator;

    /**
     * @param BasicsValidator $validator
     */
    public function __construct(BasicsValidator $validator)
    {
        $this->validator = $validator;
    }


    /**
     * @inheritDoc
     */
    public function getMinuteQuarter(int $minute): string
    {
        $this->validator->isMinutesException($minute);
        if ($minute > 0 && $minute <= 15) {
            $quarter =  'first';
        } elseif ($minute > 15 && $minute <= 30) {
            $quarter = 'second';
        } elseif ($minute > 30 && $minute <= 45) {
            $quarter = 'third';
        } else {
            $quarter = 'fourth';
        }

        return $quarter;
    }

    /**
     * @inheritDoc
     */
    public function isLeapYear(int $year): bool
    {
        $this->validator->isYearException($year);

        return ($year % 400 === 0) || (($year % 100 !== 0) && ($year % 4 === 0));
    }

    /**
     * @inheritDoc
     */
    public function isSumEqual(string $input): bool
    {
        $this->validator->isValidStringException($input);

        return  ($this->getSumOfString(substr($input, 0, 3)) === $this->getSumOfString(substr($input, 3, 3)));
    }

    private function getSumOfString(string $strForSum): int
    {
        return array_sum(str_split($strForSum));
    }
}
