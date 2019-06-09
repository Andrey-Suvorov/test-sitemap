<?php


namespace Hantu\Sitemap\Traits;


trait Sitemap
{
    public $columnName = 'alias';

    public $baseUrl = null;

    public function getUrls()
    {
        if ($this->baseUrl) {
            $baseUrl = $this->baseUrl;
        } else {
            $baseUrl = url('/');
        }

        $items = self::all();
        $urls = [];

        foreach ($items as $item) {
            $urls[] = $this->makeUrl($baseUrl, $item);
        }

        return $urls;
    }

    public function makeUrl($baseUrl, $item)
    {
        return $baseUrl . '/' . $item->{$this->columnName};
    }
}