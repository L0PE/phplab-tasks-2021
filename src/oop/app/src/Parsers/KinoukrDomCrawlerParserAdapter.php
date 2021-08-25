<?php

namespace src\oop\app\src\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class KinoukrDomCrawlerParserAdapter extends Crawler implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public function parseContent(string $siteContent): array
    {
        $this->add($siteContent);
        $aboutMovie['poster'] = $this->filter('.fcols a')->eq(0)->attr('href');
        $aboutMovie['title'] = $this->filter('h1')->eq(0)->text();
        $descriptionHTML = $this->filter('.fdesc')->html();
        $descriptionHTML = explode("</h2>", $descriptionHTML);
        $aboutMovie['description'] = $descriptionHTML[1];

        return $aboutMovie;
    }
}