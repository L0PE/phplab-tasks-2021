<?php

namespace arrays;

class Arrays implements ArraysInterface
{

    /**
     * @inheritDoc
     */
    public function repeatArrayValues(array $input): array
    {
        $repeatArray = array();
        for ($i = 0, $count = count($input); $i < $count; $i++) {
            for ($j = 0; $j < $input[$i]; $j++) {
                $repeatArray[] = $input[$i];
            }
        }

        return $repeatArray;
    }

    /**
     * @inheritDoc
     */
    public function getUniqueValue(array $input): int
    {
        if (empty($input) || empty($this->getUniqueArray($input))) {
            return 0;
        }

        $uniqueArr = $this->getUniqueArray($input);
        sort($uniqueArr);

        return $uniqueArr[0];
    }

    /**
     * Return only unique values from the input array
     *
     * @param array $input
     * @return array
     */
    private function getUniqueArray(array $input): array
    {
        $uniqueArr = [];
        for ($i = 0; $i < count($input); $i++) {
            if (in_array($input[$i], $uniqueArr)) {
                unset($uniqueArr[array_search($input[$i], $uniqueArr)]);
            } else {
                $uniqueArr[] = $input[$i];
            }
        }

        return $uniqueArr;
    }

    /**
     * @inheritDoc
     */
    public function groupByTag(array $input): array
    {
        $tagArray = array();
        for ($i = 0, $count = count($input); $i < $count; $i++) {
            for ($j = 0, $tagCount = count($input[$i]['tags']); $j < $tagCount; $j++) {
                $tagArray[$input[$i]['tags'][$j]][] = $input[$i]['name'];
            }
        }

        return $this->sortArray($tagArray);
    }

    /**
     * @param array $input
     * @return array
     */
    private function sortArray(array $input): array
    {
        ksort($input);
        foreach ($input as $key => $arr) {
            sort($arr);
            $input[$key] = $arr;
        }

        return $input;
    }
}
