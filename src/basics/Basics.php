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

        return match (true) {
            ($minute > 0 && $minute <= 15)  => 'first',
            ($minute > 15 && $minute <= 30)  => 'second',
            ($minute > 30 && $minute <= 45) => 'third',
            ($minute > 45 && $minute < 60) || $minute === 0 => 'fourth',
            default => "Something went wrong"
        };
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