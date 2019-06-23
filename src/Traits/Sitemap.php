<?php


namespace Hantu\Sitemap\Traits;


trait Sitemap
{
    public $columnName = 'alias';

    public $baseUrl = null;

    public function getUrls() : array
    {
        if ($this->baseUrl) {
            $baseUrl = $this->baseUrl;
        } else {
            $baseUrl = url('/');
        }

        $urls = [];

        self::chunk(100, function ($items) use ($baseUrl, &$urls) {
            foreach ($items as $item) {
                $urls[] = $this->makeUrl($baseUrl, $item);
            }
        });

        return $urls;
    }

    public function makeUrl($baseUrl, $item) : string
    {
        return $baseUrl . '/' . $item->{$this->columnName};
    }
}