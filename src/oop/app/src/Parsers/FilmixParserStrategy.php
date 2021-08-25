<?php

namespace src\oop\app\src\Parsers;

class FilmixParserStrategy implements ParserInterface
{


    /**
     * @inheritDoc
     */
    public function parseContent(string $siteContent): array
    {
        $siteContent = mb_convert_encoding($siteContent, "utf-8", "windows-1251");
        $pattern = '/(?:<a\sclass="fancybox"(?:[A-z0-9="\s])+href=")([A-z0-9:\/\-\.]+)(?:">)/';
        $aboutMovie['poster'] = $this->getContentByRegex($pattern, $siteContent);
        $pattern = '/(?:<h1\sclass="name"[A-z0-9="\s]+>)(.+)(?:<\/h1>)/uU';
        $aboutMovie['title']= $this->getContentByRegex($pattern, $siteContent);
        $pattern = '/(?:<div\sclass="full-story">)(.+)(?:<\/div>)/uU';
        $aboutMovie['description'] = $this->getContentByRegex($pattern, $siteContent);

        return $aboutMovie;
    }


    /**
     * @param string $pattern
     * @param string $subject
     * @return string
     */
    private function getContentByRegex(string $pattern, string $subject): string
    {
        preg_match($pattern, $subject, $matches);
        return $matches[1];
    }
}
