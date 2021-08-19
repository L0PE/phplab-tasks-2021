<?php

namespace strings;

class Strings implements StringsInterface
{

    /**
     * @inheritDoc
     */
    public function snakeCaseToCamelCase(string $input): string
    {
        $words = explode('_', $input);
        for ($i = 1; $i < count($words); $i++) {
            $words[$i] = ucfirst($words[$i]);
        }

        return implode($words);
    }

    /**
     * @inheritDoc
     */
    public function mirrorMultibyteString(string $input): string
    {
        $words = explode(' ', $input);
        for ($i = 0; $i < count($words); $i++) {
            $length = mb_strlen($words[$i], mb_detect_encoding($words[$i]));
            $reversed = '';
            while ($length-- > 0) {
                $reversed .= mb_substr($words[$i], $length, 1, mb_detect_encoding($words[$i]));
            }

            $words[$i] = $reversed;
        }

        return implode(' ', $words);
    }

    /**
     * @inheritDoc
     */
    public function getBrandName(string $noun): string
    {
        if (strtolower($noun[0]) === strtolower($noun[strlen($noun)-1])) {
            return ucfirst($noun . substr($noun, 1));
        } else {
            return 'The ' . ucfirst($noun);
        }
    }
}
