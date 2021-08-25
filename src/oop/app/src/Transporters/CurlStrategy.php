<?php

namespace src\oop\app\src\Transporters;

class CurlStrategy implements TransportInterface
{

    /**
     * @inheritDoc
     */
    public function getContent(string $url): string
    {
        $ch  = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $page = curl_exec($ch);
        curl_close($ch);
        return $page;
    }
}