<?php

namespace src\oop\app\src\Transporters;

use GuzzleHttp\Client;

class GuzzleAdapter extends Client implements TransportInterface
{

    /**
     * @inheritDoc
     */
    public function getContent(string $url): string
    {
        $res = $this->request('GET', $url);
        $body = $res->getBody();
        return $body->getContents();
    }
}