<?php
/**
 * Create Class - Scrapper with method getMovie().
 * getMovie() - should return Movie Class object.
 *
 * Note: Use next namespace for Scrapper Class - "namespace src\oop\app\src;"
 * Note: Dont forget to create variables for TransportInterface and ParserInterface objects.
 * Note: Also you can add your methods if needed.
 */

namespace src\oop\app\src;

use src\oop\app\src\Models\Movie;
use src\oop\app\src\Parsers\ParserInterface;
use src\oop\app\src\Transporters\TransportInterface;

class Scrapper
{
    private TransportInterface $transportObjects;
    private ParserInterface $parserObjects;

    /**
     * @param TransportInterface $transportObjects
     * @param ParserInterface $parserObjects
     */
    public function __construct(TransportInterface $transportObjects, ParserInterface $parserObjects)
    {
        $this->transportObjects = $transportObjects;
        $this->parserObjects = $parserObjects;
    }

    /**
     * @param string $url
     * @return Movie
     */
    public function getMovie(string $url): Movie
    {
        $siteContent = $this->transportObjects->getContent($url);
        $aboutMovie = $this->parserObjects->parseContent($siteContent);

        return new Movie($aboutMovie['title'], $aboutMovie['poster'], $aboutMovie['description']);
    }
}
