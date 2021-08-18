<?php

namespace basics;

use Prophecy\Exception\InvalidArgumentException;

class BasicsValidator implements BasicsValidatorInterface
{

    /**
     * @inheritDoc
     */
    public function isMinutesException(int $minute): void
    {
        if ($minute < 0 || $minute > 59) {
            throw new InvalidArgumentException("isMinute only accepts positive numbers from 0 to 60. 
                                                Input was: $minute");
        }
    }

    /**
     * @inheritDoc
     */
    public function isYearException(int $year): void
    {
        if ($year < 1900) {
            throw new InvalidArgumentException("isLeapYear only accepts years from 1900. Input was: $year");
        }
    }

    /**
     * @inheritDoc
     */
    public function isValidStringException(string $input): void
    {
        if (strlen($input) !== 6) {
            throw new InvalidArgumentException("isSumEqual accepts only a 6-digit string. 
                                                    The length of the entered lines: " . strlen($input));
        }
    }
}
