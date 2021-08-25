<?php

namespace src\oop\app\src\Models;

class Movie implements MovieInterface
{
    private string $title;
    private string $poster;
    private string $description;

    /**
     * @param string $title
     * @param string $poster
     * @param string $description
     */
    public function __construct(string $title, string $poster, string $description)
    {
        $this->title = $title;
        $this->poster = $poster;
        $this->description = $description;
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @inheritDoc
     */
    public function getPoster(): string
    {
        return $this->poster;
    }

    /**
     * @inheritDoc
     */
    public function setPoster(string $poster): void
    {
        $this->poster = $poster;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}